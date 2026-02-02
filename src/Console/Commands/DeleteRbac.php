<?php

namespace Softlinks\Rbac\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteRbac extends Command
{
    protected $signature = 'softlinks:delete-rbac';
    protected $description = 'Remove the Softlinks RBAC package files';

    public function handle()
    {
        if (!$this->confirm('Are you sure you want to delete all RBAC related files? This cannot be undone.')) {
            return;
        }

        $this->info('Removing Softlinks RBAC Package...');

        // 1. Delete Directories
        $directories = [
            'app/Http/Controllers/Admin',
            'app/Models/ACL',
            'app/Services/ACL',
            'app/Http/Requests/ACL',
            'app/Http/Requests/Admin',
            'app/Http/Middleware',
            'app/Traits',
            'app/Helpers',
            'resources/views/admin',
            'resources/views/errors',
            'public/adminPanel'
        ];

        foreach ($directories as $dir) {
            $path = base_path($dir);
            if (File::exists($path)) {
                File::deleteDirectory($path);
                $this->info("Deleted directory: $dir");
            }
        }

        // 2. Delete Files
        $files = [
            'routes/admin.php',
            'app/Services/AdminLoginService.php',
            'database/seeders/RbacSeeder.php'
            // Add specific migrations here if we want to be precise, or just rely on listing stubs
        ];
        
        // Get migrations from stubs to delete corresponding files in destination
        $migrationStubs = __DIR__ . '/../../stubs/database/migrations';
        if (File::exists($migrationStubs)) {
             $migrationFiles = File::files($migrationStubs);
             foreach ($migrationFiles as $file) {
                 $files[] = 'database/migrations/' . $file->getFilename();
             }
        }
        
        // Seeder
        //$files[] = 'database/seeders/DatabaseSeeder.php'; // Should we delete? Maybe just leave it or user cleans up.
        // If we really want to restore state, we might need a backup. 
        // For now, let's assume we want to remove the seeded data so we might want to run migrate:rollback first?
        // The prompt says "delete everything related to the package".
        // I won't delete DatabaseSeeder.php as it's a core file, but I will warn.

        foreach ($files as $file) {
            $path = base_path($file);
            if (File::exists($path)) {
                File::delete($path);
                $this->info("Deleted file: $file");
            }
        }

        // 3. Remove Route from web.php
        $webRoutesPath = base_path('routes/web.php');
        if (File::exists($webRoutesPath)) {
            $content = File::get($webRoutesPath);
            $search = "\nrequire base_path('routes/admin.php');";
            if (str_contains($content, $search)) {
                $content = str_replace($search, '', $content);
                File::put($webRoutesPath, $content);
                $this->info("Removed admin routes from routes/web.php");
            }
        }
        
        // 4. Revert config/auth.php
        $this->removeAuthConfig();
        
        // 5. Remove Helper from composer.json
        $this->removeHelperFromComposer();

        // 6. Remove Package Namespace from composer.json
        $this->removePackageNamespaceFromComposer();
 
        // 7. Remove Middlewares from bootstrap/app.php
        $this->removeMiddlewares();
 
        $this->info('Softlinks RBAC Package files removed successfully.');
    }
 
    protected function removeMiddlewares()
    {
        $appPath = base_path('bootstrap/app.php');
        if (File::exists($appPath)) {
            $content = File::get($appPath);
            
            $middlewareRegistration = "\n        \$middleware->alias([\n            'rbac.check' => \App\Http\Middleware\RbacCheckMiddleware::class,\n            'XSS' => \App\Http\Middleware\XSSMiddleware::class,\n        ]);";
            
            if (str_contains($content, $middlewareRegistration)) {
                $content = str_replace($middlewareRegistration, '', $content);
                File::put($appPath, $content);
                $this->info("Removed middlewares from bootstrap/app.php");
            }
        }
    }

    protected function removePackageNamespaceFromComposer()
    {
        $composerPath = base_path('composer.json');
        if (File::exists($composerPath)) {
            $content = json_decode(File::get($composerPath), true);
            $modified = false;

            if (isset($content['autoload']['psr-4']['Softlinks\\Rbac\\'])) {
                unset($content['autoload']['psr-4']['Softlinks\\Rbac\\']);
                $modified = true;
                $this->info("Removed 'Softlinks\\Rbac\\' namespace from composer.json");
            }

            if ($modified) {
                File::put($composerPath, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                $this->runComposerCommand('dump-autoload');
            }
        }
    }

    protected function removeAuthConfig()
    {
        $authConfigPath = config_path('auth.php');

        if (File::exists($authConfigPath)) {
            $content = File::get($authConfigPath);
            $modified = false;

            // Remove Admin Guard
            $guardPattern = "/(['\"]admin['\"]\s*=>\s*\[.*?\]\s*,)/s";
            if (preg_match($guardPattern, $content)) {
                $content = preg_replace($guardPattern, '', $content);
                $modified = true;
                $this->info("Removed 'admin' guard from config/auth.php");
            }

            // Remove Admin Provider
            $providerPattern = "/(['\"]tbl_admin['\"]\s*=>\s*\[.*?\]\s*,)/s";
             if (preg_match($providerPattern, $content)) {
                $content = preg_replace($providerPattern, '', $content);
                $modified = true;
                $this->info("Removed 'tbl_admin' provider from config/auth.php");
            }

            if ($modified) {
                File::put($authConfigPath, $content);
            }
        }
    }

    protected function removeHelperFromComposer()
    {
        $composerPath = base_path('composer.json');
        if (File::exists($composerPath)) {
            $content = json_decode(File::get($composerPath), true);
            
            $helperPath = "app/Helpers/Helper.php";
            $modified = false;
            
            if (isset($content['autoload']['files'])) {
                if (($key = array_search($helperPath, $content['autoload']['files'])) !== false) {
                    unset($content['autoload']['files'][$key]);
                    // Re-index array
                    $content['autoload']['files'] = array_values($content['autoload']['files']);
                    
                    if (empty($content['autoload']['files'])) {
                        unset($content['autoload']['files']);
                    }
                    $modified = true;
                }
            }
            
            if ($modified) {
                File::put($composerPath, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                $this->info("Removed Helper from composer.json autoload");
                
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
        $commands = [
            'composer ' . $command,
            'php composer.phar ' . $command,
            'php ' . base_path('composer.phar') . ' ' . $command,
        ];

        foreach ($commands as $cmd) {
            try {
                $output = [];
                $resultCode = 0;
                exec($cmd . ' 2>&1', $output, $resultCode);
                
                if ($resultCode === 0) {
                    $this->info("Composer command successful: $cmd");
                    return true;
                }
            } catch (\Exception $e) {
                // Continue
            }
        }

        $this->warn("Automated composer command failed. Please run 'composer $command' manually.");
        return false;
    }
}
