<?php namespace Modules\Cristales\Repositories\Cache;

use Modules\Cristales\Repositories\TipoCristalesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTipoCristalesDecorator extends BaseCacheDecorator implements TipoCristalesRepository
{
    public function __construct(TipoCristalesRepository $tipocristales)
    {
        parent::__construct();
        $this->entityName = 'cristales.tipocristales';
        $this->repository = $tipocristales;
    }
}
