@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<br>
		<div class="row">
			<div class="col-lg-12">

				<h4> 
					Informaci¨®n del cliente 
				</h4>

			</div>
			<div class="col-lg-4"> <h5>
				<strong> Cliente: </strong> {{$cliente->cl_nombres}} {{$cliente->cl_apellidos}} </h5>
			</div>
			<div class="col-lg-4"> <h5>
				<strong>  Tipo Cliente:</strong> {{App\Tipo_Cliente::find($cliente->tipo_cliente_id)->tipo_cliente}} </h5>
			</div>
			
		</div>

		<h3 class="text-center"> Seleccione uno o m¨¢s notas de credito:
		</h3>
		</br>
		
		<table id="example" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No. Nota</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($notas as $nota)
            <tr>
             <td> {{ $nota->id }}</td>
             <td> Q.{{{number_format((float) $nota->monto, 2) }}}</td>


           </tr>
           @endforeach
         </tbody>
       </table>


		</table>
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

		<div class="text-right">
			<div id="siguientePaso" class="btn btn-primary">
				Siguiente Paso
			</div>

		</div>


	</div>
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

	<input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">


	<input type="hidden" name="selected" id="selected" value="{{ $valores }}">

	@endsection
	@section('scripts')
	{!! HTML::script('/../../sfi/sfi/js/recibo_caja/selectNota.js') !!}
	@endsection