<?php namespace Modules\Ventas\Providers;

use Illuminate\Support\ServiceProvider;

class VentasServiceProvider extends ServiceProvider
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
            'Modules\Ventas\Repositories\VentaRepository',
            function () {
                $repository = new \Modules\Ventas\Repositories\Eloquent\EloquentVentaRepository(new \Modules\Ventas\Entities\Venta());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ventas\Repositories\Cache\CacheVentaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ventas\Repositories\DetalleVentaRepository',
            function () {
                $repository = new \Modules\Ventas\Repositories\Eloquent\EloquentDetalleVentaRepository(new \Modules\Ventas\Entities\DetalleVenta());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ventas\Repositories\Cache\CacheDetalleVentaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ventas\Repositories\FacturaVentaRepository',
            function () {
                $repository = new \Modules\Ventas\Repositories\Eloquent\EloquentFacturaVentaRepository(new \Modules\Ventas\Entities\FacturaVenta());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ventas\Repositories\Cache\CacheFacturaVentaDecorator($repository);
            }
        );
// add bindings



    }
}
