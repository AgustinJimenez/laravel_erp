<style type="text/css">
    .alert_codigo
    {
        color: red;
    }
    .input_codigo_warning
    {
        border: 2px solid red;
    }
</style>
<div class="box-body">
	<div class="row">
        <div class="col-md-2"> 
        	<label>Tipo</label>
            <select id="tipo" name="tipo" class="form-control input-md col-sm-1 tipo">
    			@foreach($tipos as $tipo)
    			<option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
    			@endforeach
			</select>
        </div>
    
        <div class="col-md-5"> 
        	<label>Padre</label>
            <select id="padre" name="padre" class="form-control input-md col-sm-1 padre selectpicker" required=""  data-live-search="true">
                <option  value="" >--</option>
                @foreach($cuentas as $cuenta)
				    <option value="{{ $cuenta->id }}" class="@if( $cuenta->tipo_nombre ){{ $cuenta->tipo_nombre->id }}@endif">{{ $cuenta->codigo }} - {{ $cuenta->nombre }}</option>
                @endforeach
			</select>
        </div>
        <div class="col-md-2"> 
            {!! Form::normalInput('codigo', 'Codigo:', $errors, null,['required' => 'required', 'maxlength' => '2']) !!}
            <div class="alert_codigo"></div>
        </div>
    </div>
    {!! Form::hidden('codigo_real') !!}
    {!! Form::normalInput('nombre', 'Nombre', $errors, null, ['required' => 'required']) !!}
    {!! Form::normalCheckbox('tiene_hijo', 'Tiene Hijos', $errors) !!}
    {!! Form::normalCheckbox('activo', 'Activo', $errors) !!}
</div>
@include('contabilidad::admin.cuentas.partials.error-modal')
