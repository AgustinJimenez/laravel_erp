<div class="box-body">
	<div class="row">
	<div class="col-md-3">
    	{!! Form::normalInput('monto_inicial','Monto Inicial', $errors, isset($caja)?(object)['monto_inicial' => $caja->monto_inicial.' ']:(object)['monto_inicial' => '0']) !!}
    </div>

    @if(isset($caja) && $caja->cierre == '0000-00-00 00:00:00')
	    <div class="col-md-3">
	    	{!! Form::normalCheckbox('activo','Activo', $errors, isset($caja)?$caja:(object)['activo' => 1]) !!}
	    </div>
    @endif
    </div>
   	<div class="row"> 
   	<br>
    	<div class="col-md-6"> 
    		<p style="color:gray"><b > OBS :</b> Para cerrar la caja debe desmarcar la opcion ACTIVO </p>
		</div>
    </div>
</div>
