<?php namespace Modules\Contabilidad\Repositories\Cache;

use Modules\Contabilidad\Repositories\AsientoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAsientoDecorator extends BaseCacheDecorator implements AsientoRepository
{
    public function __construct(AsientoRepository $asiento)
    {
        parent::__construct();
        $this->entityName = 'contabilidad.asientos';
        $this->repository = $asiento;
    }
}
