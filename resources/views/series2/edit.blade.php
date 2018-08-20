@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">

		{!! Form::model($serie, ['method' => 'PATCH', 'action' => ['SeriesController@update', $serie->id], 'id' => 'Series2UpdateForm']) !!}

		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Actualizaci®Æn de Series de Documentos </h3>
				<line>
				</div>
			</div>
			<br>
			
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("serie","Serie:") !!}
					{!! Form::text( "serie" , null , ['class' => 'form-control' , 'placeholder' => 'Serie' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("resolucion","Resoluci®Æn:") !!}
					{!! Form::text( "resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Resoluci√≥n' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("fecha_resolucion","Fecha Resolucion:") !!}
					{!! Form::text( "fecha_resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Resolucion' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("num_inferior","Numero Inferior:") !!}
					{!! Form::number( "num_inferior" , null , ['class' => 'form-control' , 'placeholder' => 'Num Inferior' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("num_superior","Numero Superior:") !!}
					{!! Form::number( "num_superior" , null , ['class' => 'form-control' , 'placeholder' => 'Numero Superior' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("fecha_vencimiento","Fecha Vencimiento:") !!}
					{!! Form::text( "fecha_vencimiento" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Vencimiento' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("num_actual","Num Actual:") !!}
					{!! Form::number( "num_actual" , null , ['class' => 'form-control' , 'placeholder' => 'Num Actual' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("documento_id","Documento:") !!}
					<select class="selectpicker" id='documento_id' name="documento_id" value="" data-live-search="true" data-live-search-placeholder="B®≤squeda" title="Seleccione">
						@foreach ($doctos as $docto)
						@if ( $docto->id == $serie->documento_id)
						<option value="{{$docto->id}}" selected>{{ $docto->documento}}</option>
						@else
						<option value="{{$docto->id}}">{{ $docto->documento}}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>
			<br>
		</br>

	</br>
	<div class="text-right m-t-15">
		<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/series2') }}">Regresar</a>

		{!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateSeries2']) !!}
	</div>
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</div>
</br>
{!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/series2/edit.js') !!}
@endsection