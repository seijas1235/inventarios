@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($producto, ['method' => 'PATCH', 'action' => ['ProductosController@update', $producto->id], 'id' => 'ProductoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Productos </h3>
            </div>
        </div>
        <br>
        <div class="row">
			<div class="col-sm-4">
				{!! Form::label("codigo_barra","Codigo de barra:") !!}
				{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo de barra']) !!}
			</div>
			<div class="col-sm-4">					{!! Form::label("nombre","Nombre:") !!}
				{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre']) !!}
			</div>
			<div class="col-sm-4">
				{!! Form::label("minimo","Stock Minimo:") !!}
					{!! Form::number( "minimo" , null , ['class' => 'form-control' , 'placeholder' => 'Stock minimo']) !!}
			</div>
		</div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/productos') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateProducto']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/productos/edit.js') !!}
@endsection