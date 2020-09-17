<?php namespace Modules\Cristales\Entities;

use Illuminate\Database\Eloquent\Model;

class Cristales extends Model
{
    protected $table = 'cristales__cristales';
    protected $fillable = 
    [
    	'nombre',
    	'categoria_cristal_id'
    ];

    public function categoria()
    {
        return $this->belongsTo('Modules\Cristales\Entities\CategoriaCristales', 'categoria_cristal_id');
    }

    public function tipocristales()
    {
        return $this->hasMany('Modules\Cristales\Entities\TipoCristales', 'cristal_id');
    }

    






}
