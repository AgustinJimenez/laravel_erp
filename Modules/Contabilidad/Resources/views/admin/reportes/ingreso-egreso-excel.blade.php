<table>
	<tr>
		<th colspan="4">
			Año {{ $anho }}
		</th>
	</tr>
	<tr>
		<th>MES</th>
		<th>INGRESO</th>
		<th>EGRESO</th>
		<th>DIFERENCIA</th>
	</tr>
	@for($i = 0; $i < count($egresos) ; $i++)
	    <tr>
	        <td >{{$meses[$i]}}</td>
	        <td>{{ $ingresos[$i] }}</td>
	        <td>{{ $egresos[$i] }}</td>
	        <td>{{ $diferencia[$i] }}</td>
	    </tr>
	@endfor
</table>





