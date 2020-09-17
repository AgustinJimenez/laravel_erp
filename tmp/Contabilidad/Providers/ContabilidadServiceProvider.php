<?php namespace Modules\Contabilidad\Providers;

use Illuminate\Support\ServiceProvider;

class ContabilidadServiceProvider extends ServiceProvider
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
            'Modules\Contabilidad\Repositories\CuentaRepository',
            function () {
                $repository = new \Modules\Contabilidad\Repositories\Eloquent\EloquentCuentaRepository(new \Modules\Contabilidad\Entities\Cuenta());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Contabilidad\Repositories\Cache\CacheCuentaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Contabilidad\Repositories\AsientoRepository',
            function () {
                $repository = new \Modules\Contabilidad\Repositories\Eloquent\EloquentAsientoRepository(new \Modules\Contabilidad\Entities\Asiento());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Contabilidad\Repositories\Cache\CacheAsientoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Contabilidad\Repositories\AsientoDetalleRepository',
            function () {
                $repository = new \Modules\Contabilidad\Repositories\Eloquent\EloquentAsientoDetalleRepository(new \Modules\Contabilidad\Entities\AsientoDetalle());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Contabilidad\Repositories\Cache\CacheAsientoDetalleDecorator($repository);
            }
        );
// add bindings



    }
}
