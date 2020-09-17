<?php namespace Modules\Contabilidad\Repositories\Cache;

use Modules\Contabilidad\Repositories\AsientoDetalleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAsientoDetalleDecorator extends BaseCacheDecorator implements AsientoDetalleRepository
{
    public function __construct(AsientoDetalleRepository $asientodetalle)
    {
        parent::__construct();
        $this->entityName = 'contabilidad.asientodetalles';
        $this->repository = $asientodetalle;
    }
}
