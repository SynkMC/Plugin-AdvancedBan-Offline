<?php

namespace Azuriom\Plugin\AdvancedBan\Providers;

use Azuriom\Models\Permission;
use Azuriom\Extensions\Plugin\BasePluginServiceProvider;

class AdvancedBanServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        Permission::registerPermissions([
            'advancedban.admin' => 'advancedban::admin.permission',
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'advancedban.index' => 'advancedban::messages.title',
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            'advancedban' => [
            	'name' => 'advancedban::admin.nav.title',
            	'icon' => 'fas fa-hammer',
            	'route' => 'advancedban.admin.settings',
            	'permission' => 'advancedban.admin'
            ],
        ];
    }
}
