<?php namespace Modules\Cristales\Repositories\Cache;

use Modules\Cristales\Repositories\CristalesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCristalesDecorator extends BaseCacheDecorator implements CristalesRepository
{
    public function __construct(CristalesRepository $cristales)
    {
        parent::__construct();
        $this->entityName = 'cristales.cristales';
        $this->repository = $cristales;
    }
}
