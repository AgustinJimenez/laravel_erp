<?php namespace Modules\Cristales\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoriaCristales extends Model
{
    protected $table = 'cristales__categoriacristales';
    protected $fillable = 
    [
    	'nombre'
    ];

    public function cristal()
    {
        return $this->hasMany('Modules\Cristales\Entities\Cristales', 'categoria_cristal_id');
    }

    public function tipocristales()
    {
        return $this->hasMany('Modules\Cristales\Entities\TipoCristales', 'categoria_cristal_id');
    }


}
