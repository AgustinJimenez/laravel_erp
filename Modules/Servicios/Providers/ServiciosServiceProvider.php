<?php namespace Modules\Servicios\Providers;

use Illuminate\Support\ServiceProvider;

class ServiciosServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Servicios\Repositories\ServicioRepository',
            function () {
                $repository = new \Modules\Servicios\Repositories\Eloquent\EloquentServicioRepository(new \Modules\Servicios\Entities\Servicio());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Servicios\Repositories\Cache\CacheServicioDecorator($repository);
            }
        );
// add bindings

    }
}
