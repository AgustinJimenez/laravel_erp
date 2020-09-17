<?php namespace Modules\Productos\Repositories\Cache;

use Modules\Productos\Repositories\AltabajaProductoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAltabajaProductoDecorator extends BaseCacheDecorator implements AltabajaProductoRepository
{
    public function __construct(AltabajaProductoRepository $altabajaproducto)
    {
        parent::__construct();
        $this->entityName = 'productos.altabajaproductos';
        $this->repository = $altabajaproducto;
    }
}
