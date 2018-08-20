<div width="450" style="text-align: right;">
	Por Q.{{{number_format((float) $recibo->monto, 2) }}}
</div>
<br>
<table  class="table" width="450" style="text-align: left;">
	<tr> 
		<td width="300" style="text-align: left;">
			<div> Chiquimula: {{$recibo->created_at}} </div>
		</td>
		<td width="150" style="text-align: right;">
			<div>NIT: {{App\cliente::find($recibo->cliente_id)->cl_nit}}</div>
		</td>
	</tr>
</table>
<br>
<div style="text-align: left;">
	Pagamos a: Gasolinera Puma Teculután.
</div>
<br>
<div style="text-align: left;">
	{{ $word}}
</div>
<br>
<div>
	Recibí de : {{App\cliente::find($recibo->cliente_id)->cl_nombres}}
	{{App\cliente::find($recibo->cliente_id)->cl_apellidos}} 
</div>
<br>
<div style="text-align: left;">
	Por concepto de: Cancelación de Vales de Combustibles solicitados a ésta Distribuidora de Servicio, por concepto de combustible.
</div>
<br>
<table  class="table" width="450" style="text-align: left;">
	<tr> 
		<td width="225" style="text-align: left;">
			<div> Documento No: {{$recibo->cheque}} </div>
		</td>
		<td width="225" style="text-align: left;">
			<div> Tipo Pago: {{App\Tipo_Pago::find($recibo->tipo_pago_id)->tipo_pago}} </div>
		</td>
	</tr>
	<tr> 
		<td width="225" style="text-align: left;">
			<div> Banco: {{App\Banco::find($recibo->banco_id)->nombre}}</div>
		</td>
		<td width="225" style="text-align: left;">
			<div> Valor: Q.{{{number_format((float) $recibo->monto, 2) }}}</div>
		</td>
	</tr>
</table>
<br>
<table  class="table" width="150" style="text-align: left;">
	<tr> 
		<td width="100" style="text-align: left;">
			Saldo Anterior: 
		</td>
		<td width="50" style="text-align: right;">
			Q.{{{number_format((float) $recibo->saldo_anterior, 2) }}}
		</td>
	</tr>
	<tr>
		<td width="100" style="text-align: left;">
			Abono de Hoy:  
		</td>
		<td width="50" style="text-align: right;">
			Q.{{{number_format((float) $recibo->monto, 2) }}}
		</td>
	</tr>
	<tr>
		<td width="100" style="text-align: left;">
			Saldo Actual: 
		</td>
		<td width="50" style="text-align: right;">
			Q.{{{number_format((float) $recibo->saldo_actual, 2) }}}
		</td>
	</tr>
</table>
<br>
