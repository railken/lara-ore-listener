<?php

namespace Railken\LaraOre;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Railken\LaraOre\Api\Support\Router;
use Railken\LaraOre\Listener\ListenerManager;
use Railken\LaraOre\Work\WorkManager;

class ListenerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ore.listener.php' => config_path('ore.listener.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutes();

        config(['ore.user.permission.managers' => array_merge(Config::get('ore.user.permission.managers'), [
            \Railken\LaraOre\Listener\ListenerManager::class,
        ])]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ore.listener.php', 'ore.listener');
        $this->app->register(\Railken\Laravel\Manager\ManagerServiceProvider::class);
        $this->app->register(\Railken\LaraOre\ApiServiceProvider::class);
        $this->app->register(\Railken\LaraOre\UserServiceProvider::class);
        $this->app->register(\Railken\LaraOre\WorkServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TemplateServiceProvider::class);

        Event::listen(Config::get('ore.listener.events'), function ($event_name, $events) {
            $lm = new ListenerManager();
            $wm = new WorkManager();
            $listeners = $lm->getRepository()->findByEventClass($event_name);

            foreach ($listeners as $listener) {
                foreach ($events as $event) {
                    $wm->dispatch($listener->work, $event->data);
                }
            }
        });
    }

    /**
     * Load routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Router::group(array_merge(Config::get('ore.listener.router'), [
            'namespace' => 'Railken\LaraOre\Http\Controllers',
        ]), function ($router) {
            $router->get('/', ['uses' => 'ListenersController@index']);
            $router->post('/', ['uses' => 'ListenersController@create']);
            $router->put('/{id}', ['uses' => 'ListenersController@update']);
            $router->delete('/{id}', ['uses' => 'ListenersController@remove']);
            $router->get('/{id}', ['uses' => 'ListenersController@show']);
        });
    }
}
