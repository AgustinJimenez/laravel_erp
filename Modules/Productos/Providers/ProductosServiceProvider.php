<?php namespace Modules\Productos\Providers;

use Illuminate\Support\ServiceProvider;

class ProductosServiceProvider extends ServiceProvider
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
            'Modules\Productos\Repositories\CategoriaProductoRepository',
            function () {
                $repository = new \Modules\Productos\Repositories\Eloquent\EloquentCategoriaProductoRepository(new \Modules\Productos\Entities\CategoriaProducto());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Productos\Repositories\Cache\CacheCategoriaProductoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Productos\Repositories\ProductoRepository',
            function () {
                $repository = new \Modules\Productos\Repositories\Eloquent\EloquentProductoRepository(new \Modules\Productos\Entities\Producto());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Productos\Repositories\Cache\CacheProductoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Productos\Repositories\MarcaRepository',
            function () {
                $repository = new \Modules\Productos\Repositories\Eloquent\EloquentMarcaRepository(new \Modules\Productos\Entities\Marca());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Productos\Repositories\Cache\CacheMarcaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Productos\Repositories\AltabajaProductoRepository',
            function () {
                $repository = new \Modules\Productos\Repositories\Eloquent\EloquentAltabajaProductoRepository(new \Modules\Productos\Entities\AltabajaProducto());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Productos\Repositories\Cache\CacheAltabajaProductoDecorator($repository);
            }
        );
// add bindings




    }
}
