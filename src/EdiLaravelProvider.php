<?php
namespace Bgies\EdiLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Bgies\EdiLaravel\Http\Middleware\CheckAuthorization;

class EdiLaravelProvider extends ServiceProvider
{
   /* php artisan vendor:publish --provider="Bgies\EdiLaravel\EdiLaravelProvider" */
   /* php artisan vendor:publish --provider="Bgies\EdiLaravel\EdiLaravelProvider" --tag='migrations' */
   /* php artisan vendor:publish --provider="Bgies\EdiLaravel\EdiLaravelProvider" --tag='assets' */
      
    public function boot()    
    {
       /* Routes */
       $this->registerRoutes();
       //$this->loadRoutesFrom(__DIR__ . '/routes/web.php');

       /* Migrations */
       $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
       
       $this->loadViewsFrom(__DIR__ . '/resources/views', 'edilaravel');

       $this->publishes([
          __DIR__ . '/path/to/assets' => public_path('vendor/edilaravel'),
       ], 'public');
       
       
       $router = $this->app->make(Router::class);
       $router->pushMiddlewareToGroup('edi', CheckAuthorization::class);

       if ($this->app->runningInConsole()) {

          /* Seeds */
          $this->publishes([
                __DIR__ . '/database/seeders/' => database_path('seeders')
             ], 'seeders');
       
          /* Config */
          $this->publishes([
                __DIR__ . '/config/config.php' => config_path('edilaravel.php')
             ], 'config');
       
          /* This will publish the js and css files if users want to customize them */      
          $this->publishes([
                __DIR__ . '/resources/views/' => base_path('resources/views/vendor/edilaravel'),
                __DIR__ . '/resources/js/' => base_path('resources/assets/js/vendor/edilaravel')
          ], 'assets');
                    
          /* Views */
          $this->publishes([
             __DIR__ . '/resources/views' => resource_path('views/vendor/edilaravel'),
          ], 'views');
       }
            
    }

    public function register()
    {
       $this->loadViewsFrom(__DIR__ . '/../resources/views', 'edi-laravel-pages');
       $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'edi-laravel');
       
    }
    
    protected function registerRoutes()
    {
       Route::group($this->routeConfiguration(), function () {
          $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
       });
    }
    
    protected function routeConfiguration()
    {
       return [
          'prefix' => config('edilaravel.prefix'),
          'middleware' => config('edilaravel.middleware'),
       ];
    }
    
}