@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'FactoresForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Gestión de Costo de IDP </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("factor_calc","Factor de Calculo:") !!}
					{!! Form::text( "factor_calc" , null , ['class' => 'form-control' , 'placeholder' => 'Factor de Calculo' ]) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::label("indice","Indice de Calculo:") !!}
					{!! Form::text( "indice" , null , ['class' => 'form-control' , 'placeholder' => 'Indice de Calculo' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/factores') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonFactores']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/factores/create.js') !!}
@endsection