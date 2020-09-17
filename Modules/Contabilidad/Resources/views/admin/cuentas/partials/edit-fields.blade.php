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
            <select id="tipo" name="tipo" class="form-control input-md col-sm-1 tipo" @if($cuenta->relacion_cuentas_fijas) disabled="disabled" @endif>
                @foreach($tipos as $tipo)
                    @if($tipo->id == $cuenta->tipo_nombre->id)<option value="{{ $tipo->id }}" selected="">{{ $tipo->nombre }}</option>
                    @else<option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>@endif 
                @endforeach
            </select>
        </div>
    
        <div class="col-md-5"> 
            <label>Padre</label>
            <select id="padre" name="padre" class="form-control input-md col-sm-1 padre" @if($cuenta->relacion_cuentas_fijas) disabled="disabled" @endif>
                <option  value="" >--</option>
                @foreach($cuentas as $cuenta_padre)
                    @if($cuenta->padre_nombre && $cuenta_padre->id == $cuenta->padre_nombre->id)
                        <option value="{{ $cuenta_padre->id }}" selected="" class="@if( $cuenta_padre->tipo_nombre ){{ $cuenta_padre->tipo_nombre->id }}@endif">{{ $cuenta_padre->codigo." -".$cuenta_padre->nombre }}</option>
                    @else
                        <option value="{{ $cuenta_padre->id }}" class="@if( $cuenta_padre->tipo_nombre ){{ $cuenta_padre->tipo_nombre->id }}@endif">{{ $cuenta_padre->codigo." -".$cuenta_padre->nombre }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            @if($cuenta->relacion_cuentas_fijas)
                {!! Form::normalInput('codigo', 'Codigo', $errors, null, ['readonly' => 'readonly']) !!} 
            @else
                {!! Form::normalInput('codigo', 'Codigo', $errors, null) !!} 
            @endif
            <div class="alert_codigo"></div>
        </div>
    </div>
    {!! Form::normalInput('nombre', 'Nombre', $errors, $cuenta, ['required' => '']) !!}
    {!! Form::hidden('codigo_real') !!}
    @if(isset($sin_hijo))
        @if(!$cuenta->relacion_cuentas_fijas)
            {!! Form::normalCheckbox('tiene_hijo_aux', 'Tiene Hijos', $errors, (object)['tiene_hijo_aux' => $cuenta->tiene_hijo]) !!}
        @else
            <p style="color:red;"> La cuenta tiene relacion con cuentas fijas, no se pueden modificar algunos datos.</p>
        @endif
    @endif  
    {!! Form::normalCheckbox('activo', 'Activo', $errors, $cuenta) !!}
    @if(isset($tiene_hijo))
    <p style="color:red;"> Tiene Hijos no podrá ser modificado debido a que la Cuenta seleccionada posee Cuentas Hijas.</p>
    @endif

</div>
@include('contabilidad::admin.cuentas.partials.error-modal')

@include('contabilidad::admin.cuentas.partials.script')
