<?php

namespace Modules\Productos\Events;

use Modules\Productos\Entities\Producto;
use Modules\Media\Contracts\StoringMedia;

class ProductoWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Producto
     */
    public $producto;

    public function __construct($producto, array $data)
    {
        $this->data = $data;

        $this->producto = $producto;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->producto;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
