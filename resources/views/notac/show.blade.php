
<br>
<br>

<div style="text-align: right; margin-bottom: 20px"> Chiquimula,  
	{{ Carbon\Carbon::parse($nota->created_at)->format('d-m-Y') }}
</div>
<div>
	Cliente: {{App\Cliente::find($nota->cliente_id)->cl_nombres}}
	{{App\Cliente::find($nota->cliente_id)->cl_apellidos}} 
</div>

<div style="">
	<table  class="table">
		<tbody>
			<tr>
				<td  width=400px>
				Dirección: {{App\Cliente::find($nota->cliente_id)->cl_direccion}} 
				</td>
				<td  width=240px style="text-align: right;">
					Nit: {{App\Cliente::find($nota->cliente_id)->cl_nit}} 
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div style="height: 200px; margin-top: 40px;">
	<table  class="table">
		<tbody>
			@foreach ($detalles as $detalle)
			<tr>
				<td  width=80>
					{{$detalle->cantidad}}
				</td>
				<td  width=320>

					@if ($nota->tipo_id == 1)

					Galones de gasolina por descuento de volumen de compra
					@else

					@if ($detalle->combustible_id != 0)
					{{App\combustible::find($detalle->combustible_id)->combustible}} 
					@endif

					@if ($detalle->producto_id != 0)
					{{App\producto::find($detalle->producto_id)->nombre}} 
					@endif

					@endif
				</td>
				<td  width=75 style="text-align: right;">
					Q.{{{number_format((float) $detalle->subtotal, 2) }}}
				</td>

			</tr>
			@endforeach

			<tr>
				<td  width=80>
			<?php $number = 0; ?>
				</td>
				<td  width=320>
					@if ($nota->tipo_id == 3)

					Por Refacturación de Facturas Cambiariarias:
					@foreach ($facturas as $factura)

					<?php ++$number ?>

					@if ($number == 1)
					{{$factura->id}} 
					@endif

					@if ($number < $count && $number > 1)
					- {{$factura->id}} 
					@endif

					@if ($number == $count)
					y {{$factura->id}}.
					@endif
					@endforeach
					@endif
				</td>

			</tr>
			
		</tbody>
	</table>
</div>

<br>

<div  width=30px style="text-align: left;">
	Total IDP:  Q.{{{number_format((float) $nota->idp_total, 2) }}}
</div>
<div  width=30px style="text-align: left;">
	{{ $word}}
</div>
<div  width=30px style="text-align: right;">
	Total: Q.{{{number_format((float) $nota->monto, 2) }}}
</div>

<div>
</div>

