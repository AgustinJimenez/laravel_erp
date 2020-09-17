<?php namespace Modules\Empleados\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Anticipo extends Model
{
    protected $table = 'empleados__anticipos';
    protected $dates = ['created_at', 'updated_at', 'fecha'];
    protected $dateFormat = 'U';
    protected $casts = ['fecha' => 'date'];
    protected $fillable = 
    [
    	'empleado_id',
        'anulado',
        'pago_empleado_id',
        'fecha',
        'monto',
        'observacion',
        'descontado'
    ];

    public function setFechaAttribute($value)
    {
        $this->attributes['fecha']  = Carbon::createFromFormat('d/m/Y', $value);
    }
    public function getFechaAttribute($value)
    {   
        return gettype( $value ) == "string" ? Carbon::createFromFormat('Y-m-d', $value) : $value;
    }
    public function getMontoAttribute($value)
    {
        return number_format( $value,0 ,'', '.' );
    }
    public function setMontoAttribute($value)
    {
        $this->attributes['monto']  = (int)str_replace('.', '', $value);
    }
    public function unformated($attr = null, $type = "number")
    {
        if($type == "number")
            return str_replace('.','',$this[$attr]);
        else if( $type == "date")
            return "not yet ready";
    }
    public function empleado()
    {
        return $this->belongsTo(\Empleado::class);
    }

    public function asientos()
    {
        return $this->morphMany(\Asiento::class, 'entidad');
    }

    public function with_edit_link()
    {
        $this->format_attributes();
        $this->fecha = $this->add_edit_link( 'fecha' );
        $this->monto = $this->add_edit_link( 'monto' );
        return $this;
    }

    function add_edit_link($attribute)
    {
        $route = route("admin.empleados.anticipos.edit", $this->id);
        return "<a href='{$route}'>{$this[$attribute]}</a>";
    }

    public function getTipoAttribute()
    {
        return 'anticipo';
    }


    public function generar_asientos( $usuario_id )
    {
        $asiento = new \Asiento();
        $asiento->fecha = date('Y-m-d');
        $asiento->operacion = "Anticipo";
        $asiento->observacion  = "Anticipo a empleado | " . $this->empleado->nombre_apellido . " | ";
        $asiento->usuario_create_id = $usuario_id;
        $asiento->entidad_id = $this->id;
        $asiento->entidad_type = get_class( $this );
        $asiento->save();

        $asiento_detalle = new \AsientoDetalle();
        $asiento_detalle->asiento_id = $asiento->id;
        $asiento_detalle->cuenta_id = \CuentasFijas::get('empleados.anticipos.anticipo_store.caja')->id;
        $asiento_detalle->debe = 0;
        $asiento_detalle->haber = $this->unformated('monto');
        $asiento_detalle->save();

        $asiento_detalle = new \AsientoDetalle();
        $asiento_detalle->asiento_id = $asiento->id;
        $asiento_detalle->cuenta_id = \CuentasFijas::get('empleados.anticipos.anticipo_store.anticipo_de_salario')->id;
        $asiento_detalle->debe = $this->unformated('monto');
        $asiento_detalle->haber = 0;
        $asiento_detalle->save();
    }

}