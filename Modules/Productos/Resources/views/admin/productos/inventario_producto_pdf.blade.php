<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title> Inventario de Productos</title>
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
		
		<body style="">
			<center><h2>Inventario de Productos - Artronic</h2></center>
			<div class="" style=" margin-left:0%;margin-right:0%; ">
				<div style="" >
					<span style=""><b>Fecha de Doc:</b> </span>
					<span style="">{{ $fecha }}</span><br>
				</div>
			</div>
			<div class="" style=" margin-left:0%;margin-right:0%; ">
				<div style="" >
					<span style=""><b>Ejercicio Contable:</b></span>
					<span style="">{{ $anho_ejercicio }}</span><br>
				</div>
			</div>
			<br>
			<script type="text/php">
			if ( isset($pdf) ) 
			{
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
		<div id="tabla">
		@if(isset($categorias_productos))
			@foreach ($categorias_productos as $key => $categoria)
			<div style="background-color:#F2F2F2;"> 
	            <center>
		            <label >
		                <h3>
		                    {{ $categoria->codigo }} - {{ $categoria->nombre }}  
		                </h3>           
		            </label> 
	            </center>
            </div> 
			<table cellpadding="2" style="width: 100%;">
				<thead>
					<tr>
						<td rowspan="1" bgcolor="#3c8dbc;" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;"><strong>Codigo</strong></span>
								</span>
							</p>
						</td>
						@if($imagen)
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Imagen</strong>
								</span>
							</p>
						</td>
						@endif
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Producto</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Stock</strong>
									</span>
								</span>
							</p>
						</td>
						@if($precio_compra)
							<td rowspan="1" bgcolor="#3c8dbc" >
								<p align="center">
									<span style="color: #ffffff;">
										<span style="font-family: Calibri, serif;">
											<strong>Precio Compra</strong>
										</span>
									</span>
								</p>
							</td>
						@endif
						@if($precio_venta)
							<td rowspan="1" bgcolor="#3c8dbc" >
								<p align="center">
									<span style="color: #ffffff;">
										<span style="font-family: Calibri, serif;">
											<strong>Precio Venta</strong>
										</span>
									</span>
								</p>
							</td>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach($categoria->producto as $producto)
						<tr>
							<td bgcolor="#ffffff" >
								<p align="center"><span style="color: #000000;">{{ $producto->codigo }}</span></p>
							</td>
							@if($imagen)
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;"> <img src="{{ $producto->getArchivoPath() }}" style="height: 90px; width: 70px;"></span></p>
								</td>
							@endif
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;" > {{ $producto->nombre }}</span></p>
								</td>
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;">{{ $producto->stock }}</span></p>
								</td>
							@if($precio_compra)
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;">{{ number_format($producto->precio_compra, 0, '', '.') }}</span></p>
								</td>
							@endif	
							@if($precio_venta)
								<td bgcolor="#ffffff" > 
									<p align="center"><span style="color: #000000;">{{ number_format($producto->precio_venta, 0, '', '.') }}</span></p>
								</td>
							@endif			

						</tr>
					@endforeach					   
                </tbody>
			</table>
			<br>
			@endforeach
		@endif

		</body>
	</html>
