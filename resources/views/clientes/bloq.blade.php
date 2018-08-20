extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ClienteBloqForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Bloqueo y Desbloqueo de Clientes </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("estado_cliente_id","Estado del Cliente:") !!}
					{!! Form::text( "estado_cliente_id" , null , ['class' => 'form-control' , 'placeholder' => 'Estado' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					{!! Form::label("razon","Raz®Æn:") !!}
					{!! Form::text( "razon" , null , ['class' => 'form-control' , 'placeholder' => 'Raz√≥n' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/home') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Bloquear', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonClienteBloq']) !!}

				{!! Form::input('submit', 'submit', 'Desbloquear', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonClienteDes']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/clientes/bloq.js') !!}
@endsection