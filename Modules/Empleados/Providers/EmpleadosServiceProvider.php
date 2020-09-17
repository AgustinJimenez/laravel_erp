<?php namespace Modules\Empleados\Providers;

use Illuminate\Support\ServiceProvider;

class EmpleadosServiceProvider extends ServiceProvider
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
            'Modules\Empleados\Repositories\EmpleadoRepository',
            function () {
                $repository = new \Modules\Empleados\Repositories\Eloquent\EloquentEmpleadoRepository(new \Modules\Empleados\Entities\Empleado());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Empleados\Repositories\Cache\CacheEmpleadoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Empleados\Repositories\PagoEmpleadoRepository',
            function () {
                $repository = new \Modules\Empleados\Repositories\Eloquent\EloquentPagoEmpleadoRepository(new \Modules\Empleados\Entities\PagoEmpleado());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Empleados\Repositories\Cache\CachePagoEmpleadoDecorator($repository);
            }
        );
// add bindings


    }
}
