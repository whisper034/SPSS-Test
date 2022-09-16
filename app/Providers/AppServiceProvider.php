<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Collective\Html\FormFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * List of repositories that needs to be binded
     *
     * @var array
     */
    private $repositories = [
        'AdminRepository',
        'DetailPesertaRepository',
        'JawabanRepository',
        'PembayaranRepository',
        'PesertaRepository',
        'RoleRepository',
        'TimelineRepository',
    ];

    /**
     * List of services that needs to be binded
     *
     * @var array
     */
    private $services = [
        'AdminService',
        'AuthService',
        'DashboardService',
        'LombaService',
        'NotificationService',
        'RegistrasiService',
        'TimelineService'
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register all repositories
        foreach ($this->repositories as $repository) {
            $this->app->singleton("App\Repository\Contracts\I{$repository}",
                             "App\Repository\Repositories\\{$repository}");
        }

        // Register all services
        foreach ($this->services as $service) {
            $this->app->singleton("App\Service\Contracts\I{$service}", 
                             "App\Service\Modules\\{$service}");
        }

        if (app()->environment('production')){
            $this->app->bind('path.public', function() {
                return realpath(base_path().'/../public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->collectionMacro();
    }

    /**
     * Group custome collection features macro
     * 
     * @return void
     */
    public function collectionMacro()
    {
        Collection::macro('toDropdown', function ($value_key, $text_key)
        {
            return $this->mapWithKeys(function ($item) use ($value_key, $text_key)
            {
                return [$item[$value_key] => $item[$text_key]];
            });
        });
    }
}
