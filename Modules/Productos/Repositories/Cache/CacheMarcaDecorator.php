<?php namespace Modules\Productos\Repositories\Cache;

use Modules\Productos\Repositories\MarcaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMarcaDecorator extends BaseCacheDecorator implements MarcaRepository
{
    public function __construct(MarcaRepository $marca)
    {
        parent::__construct();
        $this->entityName = 'productos.marcas';
        $this->repository = $marca;
    }
}
