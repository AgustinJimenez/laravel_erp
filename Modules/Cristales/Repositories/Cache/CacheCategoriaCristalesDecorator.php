<?php namespace Modules\Cristales\Repositories\Cache;

use Modules\Cristales\Repositories\CategoriaCristalesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoriaCristalesDecorator extends BaseCacheDecorator implements CategoriaCristalesRepository
{
    public function __construct(CategoriaCristalesRepository $categoriacristales)
    {
        parent::__construct();
        $this->entityName = 'cristales.categoriacristales';
        $this->repository = $categoriacristales;
    }
}
