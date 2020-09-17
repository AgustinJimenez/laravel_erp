<?php namespace Modules\Compras\Repositories\Cache;

use Modules\Compras\Repositories\CompraRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCompraDecorator extends BaseCacheDecorator implements CompraRepository
{
    public function __construct(CompraRepository $compra)
    {
        parent::__construct();
        $this->entityName = 'compras.compras';
        $this->repository = $compra;
    }
}
