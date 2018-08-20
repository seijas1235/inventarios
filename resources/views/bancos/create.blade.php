@extends('layouts.app')
@section('content')
<div id="page-wrapper">
	<div id="page-inner">
			<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
			{!! Form::open( array( 'id' => 'BancoForm') ) !!}
			<div class="row">
				<div class="col-sm-12">
					<h3 class="tittle-custom"> Creación de Bancos </h3>
					<line>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-5">
						{!! Form::label("nombre","Banco:") !!}
						{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Banco' ]) !!}
					</div>
				</div>
				<br>
				<div class="text-right m-t-15">
					<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/bancos') }}">Regresar</a>

					{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonBanco']) !!}
				</div>
				<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			</br>
			{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/bancos/create.js') !!}
@endsection