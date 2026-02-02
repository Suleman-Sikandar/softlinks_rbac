<?php

namespace Softlinks\Rbac;

use Illuminate\Support\ServiceProvider;
use Softlinks\Rbac\Console\Commands\InstallRbac;
use Softlinks\Rbac\Console\Commands\DeleteRbac;

class RbacServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerAuthConfigs();
    }
 
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallRbac::class,
                DeleteRbac::class,
            ]);
        }
    }

    /**
     * Dynamically register AUTH configs if they are missing from config/auth.php
     * This ensures the package works even if the installation command missed the config file.
     */
    protected function registerAuthConfigs()
    {
        // Register Admin Guard
        if (!config()->has('auth.guards.admin')) {
            config()->set('auth.guards.admin', [
                'driver'   => 'session',
                'provider' => 'tbl_admin',
            ]);
        }

        // Register Admin Provider
        if (!config()->has('auth.providers.tbl_admin')) {
            config()->set('auth.providers.tbl_admin', [
                'driver' => 'eloquent',
                'model'  => \App\Models\ACL\AdminUserModel::class,
            ]);
        }
    }
}
