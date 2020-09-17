<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title> Iventario de Productos</title>
		<center><h2>Iventario de Productos - Artronic</h2></center>
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
		<div id="tabla" >
		@if(isset($query))
			<table cellpadding="2" style="width: 100%;">
				<thead>
					<tr>
						<td rowspan="1" bgcolor="#3c8dbc;" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;"><strong> Código </strong></span>
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Tipo</strong>
									
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Nombre</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>debe</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>haber</strong>
									</span>
								</span>
							</p>
						</td>

					</tr>
				</thead>

				<tbody>
						@foreach ($query as $tabla)
							@if($tabla->tiene_hijo)
								<tr valign="bottom">
									
									<td bgcolor="#ffffff" >
										<p align="left"><span style="color: #000000;"><b>{{ $tabla->codigo }}</b></span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;"><b>{{ $tabla->tipo_nombre }}</b></span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" ><b>{{ $tabla->nombre }}</b></span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;"><b>{{
										number_format($tabla->totalEjercicioContable()->debe, 0, '', '.')}}</b></span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" ><b>{{
										number_format($tabla->totalEjercicioContable()->haber, 0, '', '.')}}</b></span></p>
									</td>						

								</tr>
							@else
								<tr valign="bottom">
									
									<td bgcolor="#ffffff" >
										<p align="left"><span style="color: #000000;">{{ $tabla->codigo }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;"> {{ $tabla->tipo_nombre }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" > {{ $tabla->nombre }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;">{{
										number_format($tabla->totalEjercicioContable()->debe, 0, '', '.')}}</span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{
										number_format($tabla->totalEjercicioContable()->haber, 0, '', '.')}}</span></p>
									</td>						

								</tr>
							@endif
						@endforeach
                    
                </tbody>
			</table>
		@endif
		@if(isset($balance))
			<table cellpadding="2" style="width: 100%;">
				<thead>
					<tr>
						<td rowspan="1" bgcolor="#3c8dbc;" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;"><strong> Código </strong></span>
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Tipo</strong>
									
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Nombre</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>debe</strong>
									</span>
								</span>
							</p>
						</td>
						<td rowspan="1" bgcolor="#3c8dbc" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>haber</strong>
									</span>
								</span>
							</p>
						</td>

					</tr>
				</thead>

				<tbody>
						@foreach ($balance as $tabla)
							@if($tabla->tiene_hijo)
								<tr valign="bottom">
									
									<td bgcolor="#ffffff" >
										<p align="left"><span style="color: #000000;"><b>{{ $tabla->codigo }}</b></span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;"><b>{{ $tabla->tipo_nombre }}</b></span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" ><b>{{ $tabla->nombre }}</b></span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;"><b>{{
										number_format($tabla->totalEjercicioContable()->debe, 0, '', '.')}}</b></span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" ><b>{{
										number_format($tabla->totalEjercicioContable()->haber, 0, '', '.')}}</b></span></p>
									</td>						

								</tr>
							@else
								<tr valign="bottom">
									
									<td bgcolor="#ffffff" >
										<p align="left"><span style="color: #000000;">{{ $tabla->codigo }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;"> {{ $tabla->tipo_nombre }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" > {{ $tabla->nombre }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;">{{
										number_format($tabla->totalEjercicioContable()->debe, 0, '', '.')}}</span></p>
									</td>

									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" >{{
										number_format($tabla->totalEjercicioContable()->haber, 0, '', '.')}}</span></p>
									</td>						

								</tr>
							@endif
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