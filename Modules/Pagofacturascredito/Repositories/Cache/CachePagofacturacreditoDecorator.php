<?php namespace Modules\Pagofacturascredito\Repositories\Cache;

use Modules\Pagofacturascredito\Repositories\PagofacturacreditoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePagofacturacreditoDecorator extends BaseCacheDecorator implements PagofacturacreditoRepository
{
    public function __construct(PagofacturacreditoRepository $pagofacturacredito)
    {
        parent::__construct();
        $this->entityName = 'pagofacturascredito.pagofacturacreditos';
        $this->repository = $pagofacturacredito;
    }
}
