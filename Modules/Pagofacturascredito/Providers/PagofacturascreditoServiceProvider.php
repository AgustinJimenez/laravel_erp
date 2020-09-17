<?php namespace Modules\Pagofacturascredito\Providers;

use Illuminate\Support\ServiceProvider;

class PagofacturascreditoServiceProvider extends ServiceProvider
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
            'Modules\Pagofacturascredito\Repositories\PagofacturacreditoRepository',
            function () {
                $repository = new \Modules\Pagofacturascredito\Repositories\Eloquent\EloquentPagofacturacreditoRepository(new \Modules\Pagofacturascredito\Entities\Pagofacturacredito());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pagofacturascredito\Repositories\Cache\CachePagofacturacreditoDecorator($repository);
            }
        );
// add bindings

    }
}
