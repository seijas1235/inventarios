@extends('layouts.app')
@section('content')
<div id="page-wrapper">
	<div id="page-inner">
			<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
			{!! Form::open( array( 'id' => 'CDRubroForm') ) !!}
			<div class="row">
				<div class="col-sm-12">
					<h3 class="tittle-custom"> Creación de Rubros para Cortes Diarios </h3>
					<line>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-5">
						{!! Form::label("rubro","Rubro:") !!}
						{!! Form::text( "rubro" , null , ['class' => 'form-control' , 'placeholder' => 'Rubro' ]) !!}
					</div>
				</div>
				<br>
				<div class="text-right m-t-15">
					<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cdrubros') }}">Regresar</a>

					{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCDRubro']) !!}
				</div>
				<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			</br>
			{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/sfi/js/corte_diario_rubro/create.js') !!}
@endsection