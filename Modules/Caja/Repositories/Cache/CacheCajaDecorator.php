<?php namespace Modules\Caja\Repositories\Cache;

use Modules\Caja\Repositories\CajaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCajaDecorator extends BaseCacheDecorator implements CajaRepository
{
    public function __construct(CajaRepository $caja)
    {
        parent::__construct();
        $this->entityName = 'caja.cajas';
        $this->repository = $caja;
    }
}
