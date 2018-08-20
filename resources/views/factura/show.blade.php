

<div style="margin-top: 150px; text-align: right;"> Chiquimula, {{ Carbon\Carbon::parse($factura->created_at)->format('d-m-Y') }} </div>
<div>
	Cliente: {{App\Cliente::find($factura->cliente_id)->cl_nombres}}
	{{App\Cliente::find($factura->cliente_id)->cl_apellidos}} 
</div>
<div>
	Dirección: {{App\Cliente::find($factura->cliente_id)->cl_direccion}} 
</div>
<div style="text-align: right;">
	NIT: {{App\Cliente::find($factura->cliente_id)->cl_nit}} 
</div>
<div style="height: 200px; margin-top: 40px;">
	<table  class="table">
		<tbody>
			@foreach ($detalles as $detalle)
			<tr>
				<td width=80>
					{{$detalle->cantidad}}
				</td>
				<td style="text-align: left;" width=165>
					@if ($detalle->combustible_id != 0)
					{{App\combustible::find($detalle->combustible_id)->combustible}} 
					@endif

					@if ($detalle->producto_id != 0)
					{{App\producto::find($detalle->producto_id)->nombre}} 
					@endif
				</td>
				<td style="text-align: right;" width=75>
					Q.{{{number_format((float) $detalle->subtotal, 2) }}}
				</td>

			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div style="text-align: left;">
	Total IDP:	Q.{{{number_format((float) $factura->idp_total, 2) }}}
</div>
<div style="text-align: left;">
	{{{$word}}}
</div>
<div style="text-align: right;">
	Total: Q.{{{number_format((float) $factura->total, 2) }}}
</div>
</br>
