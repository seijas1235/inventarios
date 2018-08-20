
<div style="text-align: center;"> 
	<h2> ESTACIÓN DE SERVICIO TECULUTÁN </h2>
</div>
@foreach ($corte as $cc)
<div>
	<h3> Fecha: {{Carbon\Carbon::parse($cc->fecha_corte)->format('d-m-Y')}}  </h3>
</div>

<div style="height: 200px; margin-top: 40px;">
	<table  class="table" width="100%">
		<tr>
			<td width="40%"></td>
			<td width="30%"></td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: center;"><h2> Resumen de Corte Diario</h2></td>
		</tr>
		<tr>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: center;"><h3> Movimiento de Combustibles</h3></td>
		</tr>
		<tr>
			<td width="40%" style="text-align: left;"><strong> PRODUCTO </strong></td>
			<td width="30%" style="text-align: right;"><strong> GALONAJE </strong></td>
			<td width="30%" style="text-align: right;"><strong> SUBTOTAL </strong></td>
		</tr>
		<tr>
			<td width="40%">SUPER</td>
			<td width="30%" style="text-align: right;">{{{number_format((float) $cc->gal_super, 2) }}}</td>
			<td width="30%" style="text-align: right;">Q.{{{number_format((float) $cc->total_super, 2) }}}</td>
		</tr>
		<tr>
			<td width="40%">REGULAR</td>
			<td width="30%" style="text-align: right;">{{{number_format((float) $cc->gal_regular, 2) }}}</td>
			<td width="30%" style="text-align: right;">Q.{{{number_format((float) $cc->total_regular, 2) }}}</td>
		</tr>
		<tr>
			<td width="40%">DIESEL</td>
			<td width="30%" style="text-align: right;">{{{number_format((float) $cc->gal_diesel, 2) }}}</td>>
			<td width="30%" style="text-align: right;">Q.{{{number_format((float) $cc->total_diesel, 2) }}}</td>
		</tr>
		<tr>
			<td width="40%"></td>
			<td width="30%"><strong>TOTAL</strong></td>
			<td width="30%" style="text-align: right;"><strong>Q.{{{number_format((float) $cc->total_diesel+$cc->total_super+$cc->total_regular, 2) }}}</strong></td>
		</tr>
		<tr>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
			<td><font color="white">--</font></td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: center;"><h3> Movimiento de Efectivo</h3></td>
		</tr>
		<tr>
			<td colspan="2"><strong> DESCRIPCION </strong></td>
			<td><strong> TOTAL </strong></td>
		</tr>
		<tr>
			<td colspan="2"> Faltante en Efectivo </td>
			<td style="text-align: left;">Q.{{{number_format((float) $cc->faltantes, 2) }}}</td>
		</tr>
		<tr>
			<td colspan="2"> Venta Crédito </td>
			<td style="text-align: left;">Q.{{{number_format((float) $cc->vales, 2) }}}</td>
		</tr>
		<tr>
			<td colspan="2"> Venta en Efectivo </td>
			<td style="text-align: left;">Q.{{{number_format((float) $cc->total_efectivo+$cc->gastos+$cc->anticipo_empleado+$cc->devoluciones+$cc->calibraciones+$cc->gastos_bg, 2) }}}</td>
		</tr>
		<tr>
			<td colspan="2"> Venta Tarjeta </td>
			<td style="text-align: left;">Q.{{{number_format((float) $cc->tarjeta, 2) }}}</td>
		</tr>
		<tr>
			<td colspan="2"><strong> TOTAL </strong></td>
			<td style="text-align: left;"><strong>Q.{{{number_format((float) $cc->total_efectivo+$cc->gastos+$cc->anticipo_empleado+$cc->devoluciones+$cc->calibraciones+$cc->gastos_bg+$cc->tarjeta+$cc->vales+$cc->faltantes, 2) }}}</strong></td>
		</tr>
	</table>
</div>

@endforeach
