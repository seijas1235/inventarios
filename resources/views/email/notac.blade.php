<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	
</head>
<body>
	<h2>Anulación de Nota de Crédito </h2>
	Le informamos que el usuario {{$user->name }} ha eliminado un vale con la siguiente información:

	<h2> Gasolinera Puma  </h2>
	<h3> Teculután, Zacapa </h3>
	<h4> Nota de Crédito No. {{$nota->id}}</h4> 
	<div>
		Cliente: {{App\Cliente::find($nota->cliente_id)->cl_nombres}}
		{{App\Cliente::find($nota->cliente_id)->cl_apellidos}} 
	</div>
	<div> Fecha: {{$nota->created_at}} </div>
	<table  class="table">
		<thead>
			<tr>
				<th width=100>Cant</th>
				<th style="text-align: left;" width=230>Producto</th>
				<th width=0.000008%>Total</th>
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
				<td>
					Q.{{{number_format((float) $detalle->subtotal, 2) }}}
				</td>

			</tr>
			@endforeach
		</tbody>
	</table>
	<div>
		Total: Q.{{{number_format((float) $nota->monto, 2) }}}
	</div>

	<div>
		{{ $word}}
	</div>
</br>

</body>
</html>