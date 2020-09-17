<?php namespace Modules\Proveedores\Repositories\Cache;

use Modules\Proveedores\Repositories\ProveedorRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProveedorDecorator extends BaseCacheDecorator implements ProveedorRepository
{
    public function __construct(ProveedorRepository $proveedor)
    {
        parent::__construct();
        $this->entityName = 'proveedores.proveedors';
        $this->repository = $proveedor;
    }
}
