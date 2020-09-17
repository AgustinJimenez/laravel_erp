 <style type="text/css">
     .input_white
    {
        border:0px; 
        font-size:14pt; 
        background-color:white;
    }
    select option
    {
        width: 350%;
    } 
}

 </style>
    
    @if(!$isOtros)<!--SOLO MUESTRA NUMERO DE SOBRE CUANDO LA VENTA NO ES (OTRAS VENTAS)-->
        <div class="col-md-2 text-center">
            {!! Form::normalInput('nro_seguimiento', 'Nro de Sobre', $errors, isset($venta)?$venta:(object)['nro_seguimiento'=> $nro_seguimiento], ['required' => '', 'class' => 'form-control text-center nro_sobre1'] ) !!} 
            
        </div>         
    @endif

        <div class="col-md-2 text-center" @if(isset($isPreventa) and $isPreventa) style="display:none;"@endif>
            {!! Form::normalInput('fecha_venta', 'Fecha de Venta', $errors, isset($venta)?$venta:(object)['fecha_venta' => $fecha], ['required' => '' , 'class'=> 'form-control text-center'] ) !!} 
        </div>

        @if( (isset($isPreventa) and $isPreventa) OR isset($venta) and $venta->tipo=='preventa')
            <div class="col-md-2 text-center">
                {!! Form::normalInput('fecha_entrega', 'Fecha de Entrega', $errors, isset($venta)?$venta:(object)['fecha_entrega' => $fecha], ['required' => '' , 'class'=> 'form-control text-center'] ) !!} 
            </div>
        @endif

<br>


    @if(!isset($venta))
        @include('ventas::admin.ventas.partials.detalles-create')
        
    @else
        @include('ventas::admin.ventas.partials.detalles-edit')
    @endif

    @if( isset($venta) and $venta->tipo == "preventa" and !$venta->anulado)
        <div class="row container-fluid">
            <a class="btn btn-primary" id="button-agregar-item-preventa">AGREGAR ITEM</a>
        </div>
    @endif
    <br>

    <div class="row text-center">

        <div class="col-md-3 text-center">
            {!! Form::normalInput('monto_total', 'Monto Total', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::normalInput('monto_total_letra', 'Total a Pagar', $errors, isset($venta)?$venta:null , ['class' => 'form-control text-center']) !!}
        </div>

    </div>
    <div class="row">

        <div class="col-md-3 text-center">
            {!! Form::normalInput('total_iva_5', 'IVA 5%', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
        </div>

        <div class="col-md-3 text-center">
            {!! Form::normalInput('total_iva_10', 'IVA 10%', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
        </div>

        <div class="col-md-3 text-center">
            {!! Form::normalInput('total_iva', 'IVA Total', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
        </div>

    </div>
    @if(isset($isOtros) && $isOtros==false)
        <div class="row">
            <div class="col-md-3">
                {!! Form::label("my_label","VISI&Oacute;N LEJANA") !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 text-center">
                {!! Form::normalInput('ojo_izq', 'Ojo Izquierdo', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
            </div>

            <div class="col-md-3 text-center">
                {!! Form::normalInput('ojo_der', 'Ojo Derecho', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
            </div>

            <div class="col-md-3 text-center">
                {!! Form::normalInput('distancia_interpupilar', 'Distancia Interpupilar', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                 {!! Form::label("my_label","VISI&Oacute;N CERCANA") !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 text-center">
                {!! Form::normalInput('ojo_izq_cercano', 'Ojo Izquierdo', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
            </div>
            <div class="col-md-3 text-center">
                {!! Form::normalInput('ojo_der_cercano', 'Ojo Derecho', $errors, isset($venta)?$venta:null, ['class' => 'form-control text-center']) !!}
            </div>
        </div>
    @endif
    @if(isset($isOtros) && isset($isVenta) && isset($isPreventa))
        {!! Form::normalInput('observacion_venta', 'Observaciones: ', $errors, isset($venta)?$venta:null, ['class' => 'form-control ']) !!}
    @else
        {!! Form::normalInput('observacion_venta', 'Observaciones: ', $errors, isset($venta)?$venta:null, ['class' => 'form-control ', 'readonly'=>'']) !!}
    @endif

   

<br>

<script type="text/javascript">
   $( document ).ready(function() 
    {
        $('#mensaje_precio').hide();
    });
</script>

