<?php namespace Modules\Contabilidad\Repositories\Cache;

use Modules\Contabilidad\Repositories\CuentaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCuentaDecorator extends BaseCacheDecorator implements CuentaRepository
{
    public function __construct(CuentaRepository $cuenta)
    {
        parent::__construct();
        $this->entityName = 'contabilidad.cuentas';
        $this->repository = $cuenta;
    }
}
