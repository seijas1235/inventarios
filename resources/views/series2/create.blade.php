@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'Series2Form') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creaci®Æn de Series de Documentos </h3>
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
					<select class="selectpicker" id='documento_id' name="documento_id" value="" data-live-search="true" data-live-search-placeholder="B√∫squeda" title="Seleccione">
						@foreach ($doctos as $docto)
						<option value="{{$docto->id}}">{{$docto->documento}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
		</br>
		<div class="text-right m-t-15">
			<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/series2') }}">Regresar</a>

			{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonSerie2']) !!}
		</div>
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	</br>
	{!! Form::close() !!}
</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/series2/create.js') !!}
@endsection