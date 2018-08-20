<h2> Gasolinera Puma  </h2>
<h3> Teculután, Zacapa </h3>
<h4> Factura Cambiaria No. {{$factura->id}}</h4> 
<div>
	Cliente: {{App\Cliente::find($factura->cliente_id)->cl_nombres}}
	{{App\Cliente::find($factura->cliente_id)->cl_apellidos}} 
</div>
<div> Fecha: {{$factura->created_at}} </div>
<table  class="table">
	<thead>
		<tr>
			<th width=100>Cant</th>
			<th style="text-align: left;" width=300>Producto</th>
			<th style="text-align: right;" width=0.000008%>Total</th>
		</tr>
	</thead>
	<hr>
	<tbody>
		@foreach ($detalles as $detalle)
		<tr>
			<td>
				{{$detalle->cantidad}}
			</td>
			<td>
				@if ($detalle->combustible_id != 0)
				{{App\combustible::find($detalle->combustible_id)->combustible}} 
				@endif

				@if ($detalle->producto_id != 0)
				{{App\producto::find($detalle->producto_id)->nombre}} 
				@endif
			</td>
			<td style="text-align: right;">
				Q.{{{number_format((float) $detalle->subtotal, 2) }}}
			</td>

		</tr>
		@endforeach
	</tbody>
</table>
<div>
	Total: Q.{{{number_format((float) $factura->total, 2) }}}
</div>

<div>
	{{ $word}}
</div>
</br>

