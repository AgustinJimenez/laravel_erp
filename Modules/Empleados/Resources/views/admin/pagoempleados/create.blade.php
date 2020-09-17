@extends('layouts.master')

@section('content-header')
    <h1>
        Crear Pago 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.empleados.pagoempleado.index') }}">{{ trans('empleados::pagoempleados.title.pagoempleados') }}</a></li>
        <li class="active">{{ trans('empleados::pagoempleados.title.create pagoempleado') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.empleados.pagoempleado.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('empleados::admin.pagoempleados.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        {{-- <button  class="btn btn-primary btn-flat" id="fakesubmit" >Guardar</button> --}}
                        <button type="submit" class="btn btn-primary btn-flat" id="guardar_button"><b>Guardar</b></button>
                        <p id="waring_message_monto_inferior" style="color:red;">El Total a entregar no puede ser negativo</p>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.empleados.pagoempleado.index')}}"><i class="fa fa-times"></i> <b>Cancelar</b></a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::script('js/jquery.number.min.js') !!}
    {!! Theme::script('vendor/jquery-ui/jquery-ui.min.js') !!}
{!! Theme::style('css/vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') !!}
{!! Theme::script('vendor/jquery-ui/ui/minified/i18n/datepicker-es.min.js') !!}
    <script type="text/javascript">

    $( document ).ready(function() 
    {             
        $("#fecha").datepicker($.datepicker.regional[ "es" ]);
        $(".anticipo-checkbox").click(function()
        {
            calculate();
            

        });

        $("#salario").number( true , 0, '', '.' );

        $("#extra").number( true , 0, ',', '.' );
        $('#extra').val(0);

        $("#total_pagar_empleado").number( true , 0, ',', '.' );
        
        $("#total_pagar").number( true , 0, ',', '.' );

        $("#descuento_ips").number( true , 0, ',', '.' );

        $("#monto_ips").number( true , 0, ',', '.' );
        
        $('#extra').keyup(function(e)
        {
            calculate();
        });

        $('#extra').keyup();

        function calculate()
        {
            var suma_anticipos = 0;

            $(".anticipo-checkbox").each(function()
            {
                if( $(this).is(':checked') )
                    suma_anticipos += parseInt( $(this).closest('tr').find('.monto').text().split(".").join("") );
            });

            var salario = parseInt( $("#salario").attr('salario-original') );

            
            @if($empleado->ips)
                var ips_empleado = parseInt(salario*0.09);
                var ips_empresa = parseInt(salario*0.165);
                var aux_total_empleado = parseInt( salario-ips_empleado );
            @else
                var ips_empleado = 0;
                var ips_empresa = 0;
                var aux_total_empleado = parseInt( salario-ips_empleado );
            @endif
            var extra = parseInt( $("#extra").val() );

            if(!extra)
                extra = 0;

            //console.log(parseInt(salario*0.165));

            $("#descuento_ips").val( ips_empleado );
            //console.log( "salario="+salario+" ips_empleado="+ips_empleado+" suma_anticipos="+suma_anticipos+" aux_total_empleado="+aux_total_empleado );

            $("#total_pagar_empleado").val( aux_total_empleado + extra - suma_anticipos );

            $("#monto_ips").val( ips_empresa );

            
            $("#total_pagar").val( ips_empresa+salario+extra );   //gasto total por empleado
            $("#salario").val( salario );
            $("#suma-total-montos").html("SUMA TOTAL MONTOS: "+spaces(22)+(suma_anticipos).formatMoney(0, ',', '.'));

            if(aux_total_empleado+extra-suma_anticipos<0)
            {
                $("#waring_message_monto_inferior").show();
                $("#guardar_button").attr("disabled", true);
            }
            else
            {
                $("#waring_message_monto_inferior").hide();
                $("#guardar_button").attr("disabled", false);
            }
        }

    });
    $( document ).ready(function() {$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});});
    $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.empleados.pagoempleado.index') }}" }]});
    function spaces(number = 0)
    {
        var spaces = '';
        for(i=0; i<number; i++)
            spaces += '&nbsp';
        return spaces;
    }
    Number.prototype.formatMoney = function(c, d, t)
    {
        var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
     };
</script>
@stop
