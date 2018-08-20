@extends('layouts.app')
@section('content')
<div id="page-wrapper">
	<div id="page-inner">
			<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
			{!! Form::open( array( 'id' => 'CDForm') ) !!}
			<div class="row">
				<div class="col-sm-12">
					<h3 class="tittle-custom"> Registro de Corte Diario </h3>
					<line>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-5">
					{!! Form::label("corte_diario_rubro_id","Rubro:") !!}
					<select class="selectpicker" id='corte_diario_rubro_id' name="corte_diario_rubro_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($rubros as $rubro)
						<option value="{{$rubro->id}}">{{$rubro->rubro}}</option>
						@endforeach
					</select>
					</div>
					<div class="col-sm-5">
						{!! Form::label("monto","Monto:") !!}
						{!! Form::text( "monto" , null , ['class' => 'form-control' , 'placeholder' => 'Monto' ]) !!}
					</div>
				</div>
				<br>
				<div class="text-right m-t-15">
					<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/corte_diario') }}">Regresar</a>

					{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCD']) !!}
				</div>
				<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			</br>
			{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/sfi/js/corte_diario/create.js') !!}
@endsection