<?php namespace Modules\Servicios\Repositories\Cache;

use Modules\Servicios\Repositories\ServicioRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServicioDecorator extends BaseCacheDecorator implements ServicioRepository
{
    public function __construct(ServicioRepository $servicio)
    {
        parent::__construct();
        $this->entityName = 'servicios.servicios';
        $this->repository = $servicio;
    }
}
