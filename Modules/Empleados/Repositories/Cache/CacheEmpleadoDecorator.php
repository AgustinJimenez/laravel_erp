<?php namespace Modules\Empleados\Repositories\Cache;

use Modules\Empleados\Repositories\EmpleadoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheEmpleadoDecorator extends BaseCacheDecorator implements EmpleadoRepository
{
    public function __construct(EmpleadoRepository $empleado)
    {
        parent::__construct();
        $this->entityName = 'empleados.empleados';
        $this->repository = $empleado;
    }
}
