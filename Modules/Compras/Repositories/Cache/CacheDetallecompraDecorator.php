<?php namespace Modules\Compras\Repositories\Cache;

use Modules\Compras\Repositories\DetallecompraRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDetallecompraDecorator extends BaseCacheDecorator implements DetallecompraRepository
{
    public function __construct(DetallecompraRepository $detallecompra)
    {
        parent::__construct();
        $this->entityName = 'compras.detallecompras';
        $this->repository = $detallecompra;
    }
}
