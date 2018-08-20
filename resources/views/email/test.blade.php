<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	
</head>
<body>
	<h2>Anulación de Vales </h2>
	<div>
		Le informamos que el usuario {{$user->name }} ha eliminado un vale con la siguiente información:


		<h2 > Gasolinera Puma </h2>
	<h3> Teculután, Zacapa </h3>
		<h4> Vale No. {{$vale_maestro->id}}</h4> 
		<h5>{{$vale_maestro->created_at}} </h5>
			<table  class="table">
				<thead>
					<tr>
						<th width=40>Cant</th>
						<th style="text-align: left;" width=130>Producto</th>
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
			Total del Vale: Q.{{{number_format((float) $vale_maestro->total_vale, 2) }}}

	</div>
</body>
</html>