<?php namespace Modules\Cristales\Providers;

use Illuminate\Support\ServiceProvider;

class CristalesServiceProvider extends ServiceProvider
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
            'Modules\Cristales\Repositories\CategoriaCristalesRepository',
            function () {
                $repository = new \Modules\Cristales\Repositories\Eloquent\EloquentCategoriaCristalesRepository(new \Modules\Cristales\Entities\CategoriaCristales());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Cristales\Repositories\Cache\CacheCategoriaCristalesDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Cristales\Repositories\CristalesRepository',
            function () {
                $repository = new \Modules\Cristales\Repositories\Eloquent\EloquentCristalesRepository(new \Modules\Cristales\Entities\Cristales());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Cristales\Repositories\Cache\CacheCristalesDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Cristales\Repositories\TipoCristalesRepository',
            function () {
                $repository = new \Modules\Cristales\Repositories\Eloquent\EloquentTipoCristalesRepository(new \Modules\Cristales\Entities\TipoCristales());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Cristales\Repositories\Cache\CacheTipoCristalesDecorator($repository);
            }
        );
// add bindings



    }
}
