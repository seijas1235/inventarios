

<div style="text-align: center;"> 
	<h2> ESTACIÓN DE SERVICIO TECULUTÁN </h2>
</div>
@foreach ($corte as $cc)
<div>
	<h3> Integración de Corte con Fecha: {{Carbon\Carbon::parse($cc->fecha_corte)->format('d-m-Y')}}  </h3>
</div>

<div style="height: 200px; margin-top: 40px;">
	<table  class="table" width="100%">

		<tr>
			<td width="40%"> VENTAS DE LUBRICANTES </td>
			<td width="20%"></td>
			<td width="20%"></td>
			<td width="20%" style="text-align: right;">Q.{{{number_format((float) $cc->lubricantes, 2) }}}</td>
		</tr>
		<tr>
			<td> VENTAS SEGUN SISTEMA </td>
			<td></td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->combustible, 2) }}}</td>
		</tr>
		<tr>
			<td><strong> TOTAL DE VENTAS </strong></td>
			<td></td>
			<td></td>
			<td style="text-align: right;"><strong>Q.{{{number_format((float) $cc->total_ventas, 2) }}}</strong></td>
		</tr>
		<br>
		<tr>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
		</tr>
		<br>
		<tr>
			<td> DEPOSITO GRANDE </td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->deposito_grande, 2) }}}</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td> DEPOSITO COLAS </td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->deposito_colas, 2) }}}</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td> DEPOSITO POSTERIOR </td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->deposito_posterior, 2) }}}</td>
			<td style="text-align: right;"><strong>Q.{{{number_format((float) $cc->total_efectivo, 2) }}}</strong></td>
			<td></td>
		</tr>
		<tr>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
		</tr>
		<tr>
			<td> EFECTIVO </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->total_efectivo, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> VALES </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->vales, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> TARJETA </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->tarjeta, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> GASTOS </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->gastos, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> DEVOLUCIONES </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->devoluciones, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> CALIBRACIONES </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->calibraciones, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> ANTICIPOS EMPLEADOS </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->anticipo_empleado, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> FALTANTES DE EFECTIVO </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->faltantes, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> CUPONES PUMA </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->cupones, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td> TOTAL GASTOS BG </td>
			<td></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->gastos_bg, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td><strong> TOTAL VENTAS TURNO </strong></td>
			<td></td>
			<td style="text-align: right;"><strong>Q.{{{number_format((float) $cc->total_ventas_turno, 2) }}}</strong></td>
			<td style="text-align: right;"><strong>Q.{{{number_format((float) $cc->total_ventas, 2) }}}</strong></td>
		</tr>
		<tr>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
		</tr>
		<tr>
			<td><strong> Resultado: </strong></td>
			<td style="text-align: left;"> {{$cc->resultado_turno}}</td>
			<td style="text-align: left;">Q.{{{number_format((float) $cc->resultado_q, 2) }}}</td>
			<td></td>
		</tr>
		<tr>
			<td ><strong> Observaciones: </strong></td>
			<td colspan="3" style="text-align: left;">{{$cc->observaciones}} </td>
		</tr>
		<tr>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
		</tr>
		<tr>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
		</tr>
		<tr>
			<td width="25%" style="text-align: left;"><strong> COMBUSTIBLE </strong></td>
			<td width="25%" style="text-align: right;"><strong> GALONAJE </strong></td>
			<td width="25%" style="text-align: right;"><strong>  </strong></td>
			<td width="25%" style="text-align: right;"><strong> VALOR </strong></td>
		</tr>
		<tr>
			<td>SUPER</td>
			<td style="text-align: right;">{{{number_format((float) $cc->gal_super, 2) }}}</td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->total_super, 2) }}}</td>
		</tr>
		<tr>
			<td>REGULAR</td>
			<td style="text-align: right;">{{{number_format((float) $cc->gal_regular, 2) }}}</td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->total_regular, 2) }}}</td>
		</tr>
		<tr>
			<td>DIESEL</td>
			<td style="text-align: right;">{{{number_format((float) $cc->gal_diesel, 2) }}}</td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;">Q.{{{number_format((float) $cc->total_diesel, 2) }}}</td>
		</tr>
		<tr>
			<td><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{{number_format((float) $cc->gal_diesel+$cc->gal_super+$cc->gal_regular, 2) }}}</strong></td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;"><strong>Q.{{{number_format((float) $cc->total_diesel+$cc->total_super+$cc->total_regular, 2) }}}</strong></td>
		</tr>
	</table>

	@endforeach
