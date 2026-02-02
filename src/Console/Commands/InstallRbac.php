<?php

namespace Softlinks\Rbac\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallRbac extends Command
{
    protected $signature = 'softlinks:install-rbac';
    protected $description = 'Install the Softlinks RBAC package';

    public function handle()
    {
        $this->info('Installing Softlinks RBAC Package...');

        // 1. Copy Controllers
        $this->copyDirectory('app/Http/Controllers/Admin');

        // 2. Copy Models
        $this->copyDirectory('app/Models/ACL');

        // 3. Copy Services
        $this->copyDirectory('app/Services/ACL');

        // 4. Copy Requests
        $this->copyDirectory('app/Http/Requests/ACL');
        $this->copyDirectory('app/Http/Requests/Admin');

        // 5. Copy Views
        $this->copyDirectory('resources/views/admin');

        // 6. Copy Public Assets
        $this->copyDirectory('public/adminPanel');

        // 7. Copy Services (AdminLoginService)
        $this->copyFile('app/Services/AdminLoginService.php');
        
        // 8. Copy Routes
        $this->copyFile('routes/admin.php');
        
        // 9. Copy Migrations
        $this->copyMigrations();
        
        // 10. Copy Seeder
        $this->copyFile('database/seeders/RbacSeeder.php');
        
        // 11. Copy Middleware
        $this->copyDirectory('app/Http/Middleware');
        
        // 12. Copy Traits
        $this->copyDirectory('app/Traits');
        
        // 13. Copy Helpers
        $this->copyDirectory('app/Helpers');

        // 14. Append Route to web.php
        $this->appendRoute();
        
        // 15. Append Helper to composer.json (autoload)
        $this->appendHelperToComposer();

        // 16. Update config/auth.php
        $this->appendAuthConfig();
        
        // 17. Copy Error Pages
        $this->copyDirectory('resources/views/errors');
 
        // 18. Register Middlewares in bootstrap/app.php
        $this->registerMiddlewares();
 
        $this->info('Softlinks RBAC Package files installed successfully.');
 
        // 19. Clear Config Cache
        $this->info('Clearing config cache...');
        $this->call('config:clear');
 
        // Ask to run migrations
        if ($this->confirm('Do you want to run the migrations now?')) {
            $this->call('migrate');
        }
 
        // Ask to run seeder
        if ($this->confirm('Do you want to seed the database with initial RBAC data now? (Creates Admin User and basic setup)')) {
            $this->call('db:seed', ['--class' => 'Database\Seeders\RbacSeeder']);
        }
        
        $this->info('Installation complete.');
    }
 
    protected function registerMiddlewares()
    {
        $appPath = base_path('bootstrap/app.php');
        if (File::exists($appPath)) {
            $content = File::get($appPath);
            
            // Check if already registered
            if (str_contains($content, "'XSS'") || str_contains($content, '"XSS"')) {
                $this->info("Middlewares already registered in bootstrap/app.php");
                return;
            }
 
            $middlewareRegistration = "\n        \$middleware->alias([\n            'auth' => \App\Http\Middleware\AuthMiddleware::class,\n            'XSS' => \App\Http\Middleware\XSSMiddleware::class,\n        ]);";
            
            // Match ->withMiddleware(function (Middleware $middleware) { ... }) 
            // OR ->withMiddleware(function ($middleware) { ... })
            // Looking for the closing paren or brace of the function if it's empty
            $pattern = "/(withMiddleware\s*\(\s*function\s*\(\s*(Middleware\s+)?\\\$[\w]+\s*\)\s*\{)/i";
            
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, "$1" . $middlewareRegistration, $content);
                File::put($appPath, $content);
                $this->info("Registered middlewares in bootstrap/app.php");
            } else {
                $this->warn("Could not handle automatic middleware registration. Please add it manually to bootstrap/app.php.");
            }
        }
    }

    protected function copyDirectory($path)
    {
        $source = __DIR__ . '/../../stubs/' . $path;
        $destination = base_path($path);

        if (File::exists($source)) {
            File::ensureDirectoryExists(dirname($destination));
            // Create destination directory if it doesn't exist to avoid error
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            File::copyDirectory($source, $destination);
            $this->info("Copied directory: $path");
        } else {
            $this->warn("Source directory not found: $path");
        }
    }

    protected function copyFile($path)
    {
        $source = __DIR__ . '/../../stubs/' . $path;
        $destination = base_path($path);

        if (File::exists($source)) {
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);
            $this->info("Copied file: $path");
        } else {
            $this->warn("Source file not found: $path");
        }
    }

    protected function copyMigrations()
    {
        $source = __DIR__ . '/../../stubs/database/migrations';
        $destination = base_path('database/migrations');

        if (File::exists($source)) {
            $files = File::files($source);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                // Check if migration already exists (ignoring timestamp potentially, but for now exact match)
                // Actually, let's just copy them. Laravel will handle it. 
                // To avoid duplicate class names if timestamps differ, we should be careful.
                // But here we are installing specifically these files.
                File::copy($file->getPathname(), $destination . '/' . $filename);
                $this->info("Copied migration: $filename");
            }
        }
    }
    


    protected function appendRoute()
    {
        $webRoutesPath = base_path('routes/web.php');
        $routeContent = "\nrequire base_path('routes/admin.php');";

        if (File::exists($webRoutesPath)) {
            $content = File::get($webRoutesPath);
            if (!str_contains($content, "require base_path('routes/admin.php');")) {
                File::append($webRoutesPath, $routeContent);
                $this->info("Appended admin routes to routes/web.php");
            } else {
                $this->info("Admin routes already present in routes/web.php");
            }
        }
    }

    protected function appendHelperToComposer()
    {
        $composerPath = base_path('composer.json');
        if (File::exists($composerPath)) {
            $content = json_decode(File::get($composerPath), true);
            
            $helperPath = "app/Helpers/Helper.php";
            
            if (!isset($content['autoload']['files'])) {
                $content['autoload']['files'] = [];
            }
            
            if (!in_array($helperPath, $content['autoload']['files'])) {
                $content['autoload']['files'][] = $helperPath;
                File::put($composerPath, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                $this->info("Added Helper to composer.json autoload");
                
                $this->info("Running composer dump-autoload...");
                $this->runComposerCommand('dump-autoload');
            }
        }
    }

    /**
     * Run a composer command robustly
     */
    protected function runComposerCommand($command)
    {
        // Try common composer command variations
        $commands = [
            'composer ' . $command,
            'php composer.phar ' . $command,
            'php ' . base_path('composer.phar') . ' ' . $command,
        ];

        foreach ($commands as $cmd) {
            try {
                // Use exec or shell_exec
                $output = [];
                $resultCode = 0;
                exec($cmd . ' 2>&1', $output, $resultCode);
                
                if ($resultCode === 0) {
                    $this->info("Composer command successful: $cmd");
                    return true;
                }
            } catch (\Exception $e) {
                // Continue to next command
            }
        }

        $this->warn("Automated composer command failed. Please run 'composer $command' manually.");
        return false;
    }

    protected function appendAuthConfig()
    {
        $authConfigPath = config_path('auth.php');

        if (File::exists($authConfigPath)) {
            $content = File::get($authConfigPath);

            // Add Admin Guard
            if (!str_contains($content, "'admin' => [") && !str_contains($content, "\"admin\" => [")) {
                $guardConfig = "\n        'admin' => [\n            'driver' => 'session',\n            'provider' => 'tbl_admin',\n        ],";
                // More flexible match for 'guards' => [
                $pattern = "/(['\"]guards['\"])\s*=>\s*\[/i";
                if (preg_match($pattern, $content)) {
                    $content = preg_replace($pattern, '$0' . $guardConfig, $content, 1);
                    $this->info("Added 'admin' guard to config/auth.php");
                } else {
                    $this->warn("Could not find 'guards' array in config/auth.php. Please add admin guard manually.");
                }
            }

            // Add Admin Provider
            if (!str_contains($content, "'tbl_admin' => [") && !str_contains($content, "\"tbl_admin\" => [")) {
                $providerConfig = "\n        'tbl_admin' => [\n            'driver' => 'eloquent',\n            'model' => App\Models\ACL\AdminUserModel::class,\n        ],";
                $pattern = "/(['\"]providers['\"])\s*=>\s*\[/i";
                if (preg_match($pattern, $content)) {
                    $content = preg_replace($pattern, '$0' . $providerConfig, $content, 1);
                    $this->info("Added 'tbl_admin' provider to config/auth.php");
                } else {
                     $this->warn("Could not find 'providers' array in config/auth.php. Please add tbl_admin provider manually.");
                }
            }

            File::put($authConfigPath, $content);
        }
    }
}
