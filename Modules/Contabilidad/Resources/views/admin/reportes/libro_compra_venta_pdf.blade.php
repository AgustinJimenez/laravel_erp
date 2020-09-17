<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		@if(isset($libro_ventas))
		<title> Libro de Ventas</title>
		<center><h2>Libro de Ventas - Artronic</h2></center>
		@else
		<title> Libro de Compras</title>

		<center><h2>Libro de Compras - Artronic</h2></center>
		@endif
		<style type="text/css">

			table 
			{
				font-size: 10pt;
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%;
			}
			td, th 
			{
			    border: 1px solid #dddddd;
				padding-left: 5px;
				padding-right: 5px;
				padding-top: 0px;
				padding-bottom: 0px;

			}


		</style>
	</head>
		<div class="" style=" margin-left:0%;margin-right:0%; ">
			<div style="" >
				<span style=""><b>Fecha de Doc:</b> </span>
				<span style="">{{ $fecha }}</span><br>
			</div>
		</div>
		<div class="" style=" margin-left:0%;margin-right:0%; ">
			<div style="" >
				<span style=""><b>Ejercicio Contable:</b></span>
				<span style="">{{ $año_ejercicio }}</span><br>
			</div>
		</div>
		<br>
		<body style="">
		<script type="text/php">
		if ( isset($pdf) ) {
		$x = 72;   $y = 18;    $text = "pagina {PAGE_NUM} de {PAGE_COUNT}";
		$font = $fontMetrics->get_font("helvetica", "bold");
		$size = 6;
		$color = array(0,0,0);
		$word_space = 0.0;  //  default
		$char_space = 0.0;  //  default
		$angle = 0.0;   //  default
		$pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
		}
		</script>
		<div id="tabla" >
		@if(isset($libro_ventas))
            <table cellpadding="2" style="width: 100%;">
                <thead>
                    <tr>
                        <td rowspan="2" bgcolor="#3c8dbc;" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                    <strong> Fecha </strong></span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="2" bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>N° Factura</strong>
                                    
                                </span>
                            </p>
                        </td>
                        <td rowspan="2" bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>RUC</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="2" bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>Cliente</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="2" bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>Subtotal Exento</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="1" colspan="2" bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>Subtotales Gravados</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="1" colspan="2" bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>IVA</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="2" bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>Total</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="1"  bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>5%</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="1"  bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>10%</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="1"  bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>5%</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td rowspan="1"  bgcolor="#3c8dbc" >
                            <p align="center">
                                <span style="color: #ffffff;">
                                    <span style="font-family: Calibri, serif;">
                                        <strong>10%</strong>
                                    </span>
                                </span>
                            </p>
                        </td>
                        
                    </tr>
                </thead>
                <tbody>
                        @foreach ($libro_ventas as $libro_venta)
                        
                        <tr valign="bottom">
                            
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;">{{ $libro_venta->fecha_venta_format }}</span></p>
                            </td>
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;">{{ isset($libro_venta->factura)?$libro_venta->factura->nro_factura:'Sin Factura' }}</span></p>
                            </td>
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;" >{{ $libro_venta->cliente->ruc }}</span></p>
                            </td>
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;">{{ $libro_venta->cliente->razon_social }}</span></p>
                            </td>
                            
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;">{{ number_format($libro_venta->grabado_excenta, 0, '', '.') }}</span></p>
                            </td>
                            
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;" >{{ number_format($libro_venta->grabado_5, 0, '', '.') }}</span></p>
                            </td>
                            
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;" >{{ number_format($libro_venta->grabado_10, 0, '', '.') }}</span></p>
                            </td>
                            
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;" >{{ number_format($libro_venta->total_iva_5, 0, '', '.') }}</span></p>
                            </td>
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;" >{{ number_format($libro_venta->total_iva_10, 0, '', '.') }}</span></p>
                            </td>
                            <td bgcolor="#ffffff" >
                                <p align="center"><span style="color: #000000;" >{{ number_format($libro_venta->total_grabado, 0, '', '.') }}</span></p>
                            </td>
                        </tr>
                        
                        @endforeach
                    
                </tbody>
            </table>
        @endif

		@if(isset($libro_compras))
			<table cellpadding="2" style="width: 100%;">
				<thead>
					<tr>
						<td rowspan="2" bgcolor="#3c8dbc;" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
									<strong> Fecha </strong></span>
								</span>
							</p>
						</td>
						<td rowspan="2" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>N° Factura</strong>
									
								</span>
							</p>
						</td>
						<td rowspan="2" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>RUC</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="2" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Cliente</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="2" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Subtotal Exento</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1" colspan="2" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Subtotales Gravados</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1" colspan="2" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>IVA</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="2" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Total</strong>
									</span>
								</span>
							</p>
						</td>

					</tr>
					<tr>
						<td rowspan="1"  bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>5%</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="1"  bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>10%</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1"  bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>5%</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="1"  bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>10%</strong>
									</span>
								</span>
							</p>
						</td>
						
					</tr>

				</thead>

				<tbody>
						@foreach ($libro_compras as $libro_compra)
							
								<tr valign="bottom">
									
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;">{{ $libro_compra->format('fecha', 'date') }}</span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;">{{ $libro_compra->nro_factura }}</span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{ $libro_compra->proveedor->ruc }}</span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;">{{ $libro_compra->proveedor->razon_social }}</span></p>
									</td>
									
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;">{{ number_format($libro_compra->grabado_excenta, 0, '', '.') }}</span></p>
									</td>	
								
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{ number_format($libro_compra->grabado_5, 0, '', '.') }}</span></p>
									</td>
							
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{ number_format($libro_compra->grabado_10, 0, '', '.') }}</span></p>
									</td>


									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{ number_format($libro_compra->total_iva_5, 0, '', '.') }}</span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{ number_format($libro_compra->total_iva_10, 0, '', '.') }}</span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{ number_format($libro_compra->total_grabado_iva, 0, '', '.') }}</span></p>
									</td>					

								</tr>
						@endforeach
                    
                </tbody>
			</table>
		@endif
		
		</body>
	</html>
	<script type="text/javascript">
	</script>
	
	@section('scripts')
		<script src="{{ asset('js/jquery.number.min.js') }}"></script>

		<script type="text/javascript">
			$( document ).ready(function()
			{
				$("#area").number( true , 0, '', '.' );
				$("#carga_aplicada").number( true , 0, '', '.' );
				$("#resistencia").number( true , 0, '', '.' );
			});


		</script>

		 

	@stop