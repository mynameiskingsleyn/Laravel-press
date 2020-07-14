<?php

namespace Kings\Press;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Kings\Press\Facades\Press;

class PressBaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
        $this->registerFacades();
        $this->registerResources();
        $this->registerRoutes();
    }

    public function register()
    {
        //dd('working I think');
        $this->commands([
          Console\ProcessCommand::class,
        ]);
    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'press');
        //$this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    protected function registerPublishing()
    {
        $this->publishes([
        __DIR__.'/../config/press.php'=>config_path('press.php')
      ], 'press-config');
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    private function routeConfiguration()
    {
        return[
        'prefix'=>Press::path(),
        'namespace'=>'Kings\Press\Http\Controllers',
      ];
    }

    protected function registerFacades()
    {
        $this->app->singleton('Press', function ($app) {
            return new \Kings\Press\Press();
        });
    }
}
