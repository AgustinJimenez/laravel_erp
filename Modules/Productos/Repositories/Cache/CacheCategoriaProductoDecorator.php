<?php namespace Modules\Productos\Repositories\Cache;

use Modules\Productos\Repositories\CategoriaProductoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoriaProductoDecorator extends BaseCacheDecorator implements CategoriaProductoRepository
{
    public function __construct(CategoriaProductoRepository $categoriaproducto)
    {
        parent::__construct();
        $this->entityName = 'productos.categoriaproductos';
        $this->repository = $categoriaproducto;
    }
}
