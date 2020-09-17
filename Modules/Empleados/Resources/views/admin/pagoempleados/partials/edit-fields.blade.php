<div class="box-body">
    <div class="form-group " style="display: none;">
        <label for="id">empleado_id</label>
        {{-- <input class="form-control" placeholder="empleado_id" name="empleado_id" type="text" value="{{ $empleado->id }}" id="empleado_id" readonly> --}}
    </div>
    <div class="row">
        <div class="col-md-3">
            {!! Form::normalInput('fecha', 'Fecha', $errors, $pagoempleado, ['readonly'=>'']) !!}
        </div>
    </div>
    <br>
    <h4><b>Empleado:</b> </h4>
    <hr>
     @if( count($anticipos))
     <?php $suma_monto_anticipos = 0;?>
    <div class="row">
        <div class="col-md-7">
            <br>
                <table class="table ">
                    <thead class="btn-primary">
                        <tr>
                            <th colspan="3" class="text-center">
                                ANTICIPOS
                            </th>
                        </tr>
                        <tr>
                            <th>FECHA</th>
                            <th>MONTO</th>
                            <th>OBSERVACION</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($anticipos as $anticipo)
                        <tr>
                            <td>
                                {!! Form::label('anticipo-fecha-'.$anticipo->id, $anticipo->fecha->format('d/m/Y'), array('class' => 'mylabel')) !!}
                            </td>
                            <td>
                                {!! Form::label('anticipo-monto'.$anticipo->id, $anticipo->monto, array('class' => "monto")) !!}
                            </td>
                            <td>
                                {!! Form::label($anticipo->observacion, $anticipo->observacion , array('class' => "obs")) !!}
                            </td>
                        </tr>
                        <?php $suma_monto_anticipos += $anticipo->unformated('monto');?>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="3" class="btn-primary" id="suma-total-montos">
                            SUMA TOTAL MONTOS: {{ number_format($suma_monto_anticipos,0 ,'', '.') }}
                        </th>
                    </tfoot>
                </table>
        </div>
        @else
            <?php $suma_monto_anticipos = 0;?>
        @endif
    <div class="row">
        <div class="col-md-5">
            {!! Form::normalInput('salario', 'Salario', $errors, $pagoempleado, ['readonly'=>'']) !!}
            {!! Form::normalInput('extra', 'Extra', $errors,$pagoempleado,['required'=>'','readonly'=>'']) !!}
            @if($pagoempleado->monto_ips)
            <?php $descuento_ips = $pagoempleado->salario*0.09;?>
            @else
            <?php $descuento_ips = 0;?>
            @endif
            {!! Form::normalInput('descuento_ips', 'Descuento IPS (9%)', $errors, (object)['descuento_ips' => $descuento_ips], ['readonly'=>'']) !!}
            {!! Form::normalInput('total_pagar_empleado', 'Total a entregar al Empleado:', $errors,(object)['total_pagar_empleado' => ($pagoempleado->salario + $pagoempleado->extra - $descuento_ips - $suma_monto_anticipos)], ['readonly'=>'']) !!}
        </div>
    </div>

    <br><br>
    <h4><b>Empresa:</b> </h4>
    <hr>
    

    <div class="row">
        <div class="col-md-5">
            {!! Form::normalInput('monto_ips', 'Aporte Patronal IPS (16,5%)', $errors, $pagoempleado,['readonly'=>'']) !!}
        </div>
        <div class="col-md-5">
            {!! Form::normalInput('total_pagar', 'Gasto Total por Empleado', $errors,(object)['total_pagar' => ($pagoempleado->salario + $pagoempleado->extra + $pagoempleado->monto_ips)],['readonly'=>'']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::normalInput('observacion', 'Observacion', $errors, $pagoempleado,['readonly'=>''] ) !!}
        </div>
    </div>

    
 <br><br>
    <h4><b>Asientos:</b> </h4>
    <hr>
    

    {{-- @if( count($pagoempleado->pagos)>0 ) --}}
        @foreach($pagoempleado->asientos as $pago)

                <a class="text-center btn btn-primary" href="{{ route('admin.contabilidad.asiento.edit', $pago->id) }}">Asiento de {{ $pago->operacion }} </a>
            
            @if( count($pagoempleado->asientos) < 2 )
                <button class="btn btn-danger btn-flat eliminar-anticipo" id="anular-button">
                    <b>ANULAR</b>
                </button>
            @endif

        @endforeach                   
  {{--   @endif --}}

</div>


@include('empleados::admin.pagoempleados.partials.edit-anular-confirmation-modal')

{!! Theme::script('js/jquery.number.min.js') !!}
<style type="text/css">     
        #cke_1_top
        {
            display: none;
        }

        #cke_1_bottom
        {
            display: none;
        }
        
    </style>

<script type="text/javascript">
	$( document ).ready(function() 
    {   
        $("#anular-button").click(function(event)
        {
            event.preventDefault();
            $("#pago-anular-confirmation").modal('show');
        });
        $(".anular-asiento-button").on('click',function(event)
        {
            event.preventDefault();

            var button = $(this);

            var modal_target = button.attr('data-target');

            $(modal_target).modal();

        });          
       // calculate_anticipos();
        $("#salario").number( true , 0, '', '.' );

        $("#extra").number( true , 0, ',', '.' );

        $("#total_pagar_empleado").number( true , 0, ',', '.' );
        
        $("#total_pagar").number( true , 0, ',', '.' );

        $("#descuento_ips").number( true , 0, ',', '.' );

        $("#monto_ips").number( true , 0, ',', '.' );

        function calculate()
        {
  /*
            var suma_anticipos = 0;

            var ips_empresa =parseInt(salario*0.165);

            var salario = parseInt($("#salario").val());

            var aux_total_empleado = parseInt(salario*0.91);

            var ips_empleado = parseInt(salario*0.09);

            var extra = parseInt($("#extra").val());
            
            console.log(parseInt(salario*0.165));

            $("#descuento_ips").val(ips_empleado);

            $("#total_pagar_empleado").val(aux_total_empleado+extra);

            $("#monto_ips").val((parseInt(salario*0.165)));

            $("#total_pagar").val((parseInt(salario*0.165))+aux_total_empleado+extra);
            
            $(".monto").each(function()
            {
                suma_anticipos += parseInt( $(this).text().split(".").join("") );
                console.log( suma_anticipos );
            });
*/
            //$("#suma-total-montos").html("SUMA TOTAL MONTOS: " + spaces(50) + suma_anticipos );
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

        function spaces(number = 0)
        {
            var spaces = '';
            for(i=0; i<number; i++)
                spaces += '&nbsp';
            return spaces;
        }

       


    });
</script>