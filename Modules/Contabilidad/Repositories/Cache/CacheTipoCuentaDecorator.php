<?php namespace Modules\Contabilidad\Repositories\Cache;

use Modules\Contabilidad\Repositories\TipoCuentaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTipoCuentaDecorator extends BaseCacheDecorator implements TipoCuentaRepository
{
    public function __construct(TipoCuentaRepository $tipocuenta)
    {
        parent::__construct();
        $this->entityName = 'contabilidad.tipocuentas';
        $this->repository = $tipocuenta;
    }
}
