<div style="margin-top: 95px;"> Chiquimula, {{ Carbon\Carbon::parse($factura->created_at)->format('d-m-Y') }} </div>
<div>
	Cliente: {{App\cliente::find($factura->cliente_id)->cl_nombres}}
	{{App\Cliente::find($factura->cliente_id)->cl_apellidos}} 
</div>
<div>
	Direccion: {{App\cliente::find($factura->cliente_id)->cl_direccion}} 
</div>
<div style="text-align: right;">
	NIT: {{App\cliente::find($factura->cliente_id)->cl_nit}} 
</div>

<div style="height: 100px; margin-top: 20px;">
	<table  class="table">
           <thead>
                <tr>
                    <th width=15%>Cantidad</th>
                    <th width=65%>Descripcion</th>
                    <th width=20%>Valor</th>
                </tr>
            </thead>
		<tbody>
			@foreach ($detalles as $detalle)
			<tr>
				<td style="text-align: left;" width=80>
					{{$detalle->cant}}
				</td>
				<td style="text-align: left;" width=165>
					{{$detalle->producto}}
				</td>
				<td style="text-align: right;" width=75>
					Q.{{$detalle->total}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div>
	<div style="text-align: left;">
	@foreach ($idp_super as $idps)
	@foreach ($idp_diesel as $idpd)
	@foreach ($idp_regular as $idpr)

		Total IDP:	Q.{{{number_format((float) $idpd->Total+$idps->Total+$idpr->Total, 2) }}}

		@endforeach
		@endforeach
		@endforeach
	</div>

	<div style="text-align: left;">
		{{{$word}}}
	</div>

	<div style="text-align: right;">
		Total:	Q.{{{number_format((float) $Totales, 2) }}}
	</div>
</div>
<br>
<div style="text-align: center;">
Firma:_____________________     DPI:_______________________
</div>

</br>

