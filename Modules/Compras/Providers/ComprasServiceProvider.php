<?php namespace Modules\Compras\Providers;

use Illuminate\Support\ServiceProvider;

class ComprasServiceProvider extends ServiceProvider
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
            'Modules\Compras\Repositories\CompraRepository',
            function () {
                $repository = new \Modules\Compras\Repositories\Eloquent\EloquentCompraRepository(new \Modules\Compras\Entities\Compra());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Compras\Repositories\Cache\CacheCompraDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Compras\Repositories\DetallecompraRepository',
            function () {
                $repository = new \Modules\Compras\Repositories\Eloquent\EloquentDetallecompraRepository(new \Modules\Compras\Entities\Detallecompra());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Compras\Repositories\Cache\CacheDetallecompraDecorator($repository);
            }
        );
// add bindings


    }
}
