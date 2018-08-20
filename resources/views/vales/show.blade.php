<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Vale Automático</title>
	<link rel="stylesheet" type="text/css" href="/public/style.css">
	<style>
		.table {
			width: 350px;
			height: auto;
		}
		th {
			background-color: gray;
			color: white;
			border: 1px solid black;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			@foreach ($valem as $val)
			<div>
				<table>
					<tr>
						<td><font color="white">--</font></td>
						<td><font color="white">--</font></td>
						<td><font color="white">--</font></td>
					</tr>
					<tr>
						<td width="20%"></td>
						<td width="60%"><h3>{{$val->no_vale}} </h3></td>
						<td width="20%"></td>
					</tr>
				</table>
			</div>

			<div style="height: 142px; margin-top:10px;">
				<table>
					<tr>
						<td style="font-size:13px;" width="100%"><strong>FECHA:</strong> {{Carbon\Carbon::parse($val->created_at)->format('d-m-Y H:i')}} </td>
					</tr>
					<tr>
						<td style="font-size:13px;" width="100%"><strong>CLIENTE: </strong> {{$val->cliente}}</td>
					</tr>
					<tr>
						<td style="font-size:13px;" width="100%"><strong>EMPLEADO:</strong> {{$val->empleado}} </td>
					</tr>
					<tr>
						<td style="font-size:13px;" width="100%"><strong>PILOTO:</strong> {{$val->piloto}} </td>
					</tr>
					<tr>
						<td style="font-size:13px;" width="100%"><strong>{{$val->bomba}}</strong></td>
					</tr>
					<tr>
						<td style="font-size:13px;" width="100%"><strong>TIPO VEHICULO:</strong> {{$val->vehiculo}} </td>
					</tr>
					<tr>
						<td style="font-size:13px;" width="100%"><strong>PLACA VEHÍCULO:</strong> {{$val->placa}}</td>
					</tr>
				</table>
			</div>
			<br>
			<div style="height: 100px; margin-top: 1px;">
				<table border="1" cellspacing=0 cellpadding=2 width=300 class="table table-striped table-bordered" border-collapse: collapse; border: 1px solid black; >
					<thead>
						<tr>
							<td style="font-size:12px;" width=20% >CANT</td>
							<td style="font-size:12px;" width=45% >DESCRIPCION</td>
							<td style="font-size:12px;" width=25% >VALOR</td>
						</tr>
					</thead>
					<tbody>
						@foreach ($detalles as $vald)
						<tr>
							<td style="font-size:11px;" style="text-align:center;" width=20% border: 1px solid black;>{{{number_format((float) $vald->cant, 2) }}}</td>
							<td style="font-size:11px;" style="text-align:left;" width=45% border: 1px solid black;>{{ $vald->descripcion }}</td>
							<td style="font-size:11px;" style="text-align:right;" width=25% border: 1px solid black;>Q. {{{number_format((float) $vald->valor, 2) }}}</td>
						</tr>
						<tr>
							<td style="font-size:11px;" style="text-align:left;" width=75% colspan=2 border: 1px solid black;> <strong>TOTAL</strong></td>
							<td style="font-size:11px;" style="text-align:right;" width=25% border: 1px solid black;> <strong>Q. {{{number_format((float) $val->total, 2) }}} </strong></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<br>
			<div style="height: 10px; margin-top:3px;">
				<table width= 300>
					<tr>
						<td style="font-size:13px;" style="text-align:center;" width=100% colspan=3>Firma Cliente:______________________________________</td>
					</tr>
				</table>
			</div>

			@endforeach
		</div>
	</div>
</body>
</html>
