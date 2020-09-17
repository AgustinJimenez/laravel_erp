<?php namespace Modules\Caja\Providers;

use Illuminate\Support\ServiceProvider;

class CajaServiceProvider extends ServiceProvider
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
            'Modules\Caja\Repositories\CajaRepository',
            function () {
                $repository = new \Modules\Caja\Repositories\Eloquent\EloquentCajaRepository(new \Modules\Caja\Entities\Caja());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Caja\Repositories\Cache\CacheCajaDecorator($repository);
            }
        );
// add bindings

    }
}
