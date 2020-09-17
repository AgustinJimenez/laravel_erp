<?php namespace Modules\Contabilidad\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AsientoDetalle extends Model
{
    use Translatable;

    protected $table = 'contabilidad__asientodetalles';
    public $translatedAttributes = [];
    protected $fillable = [];
}
