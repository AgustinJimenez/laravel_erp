<?php namespace Modules\Ventas\Repositories\Cache;

use Modules\Ventas\Repositories\DetalleVentaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDetalleVentaDecorator extends BaseCacheDecorator implements DetalleVentaRepository
{
    public function __construct(DetalleVentaRepository $detalleventa)
    {
        parent::__construct();
        $this->entityName = 'ventas.detalleventas';
        $this->repository = $detalleventa;
    }
}
