<?php namespace Modules\Ventas\Repositories\Cache;

use Modules\Ventas\Repositories\FacturaVentaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFacturaVentaDecorator extends BaseCacheDecorator implements FacturaVentaRepository
{
    public function __construct(FacturaVentaRepository $facturaventa)
    {
        parent::__construct();
        $this->entityName = 'ventas.facturaventas';
        $this->repository = $facturaventa;
    }
}
