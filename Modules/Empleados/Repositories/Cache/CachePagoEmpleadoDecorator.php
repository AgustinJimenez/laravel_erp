<?php namespace Modules\Empleados\Repositories\Cache;

use Modules\Empleados\Repositories\PagoEmpleadoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePagoEmpleadoDecorator extends BaseCacheDecorator implements PagoEmpleadoRepository
{
    public function __construct(PagoEmpleadoRepository $pagoempleado)
    {
        parent::__construct();
        $this->entityName = 'empleados.pagoempleados';
        $this->repository = $pagoempleado;
    }
}
