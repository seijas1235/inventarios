@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'OrdenDeTrabajoForm2') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Accesorios y Componetes </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
                    <input type="checkbox" id="emblemas">
                    {!! Form::label("emblemas","Emblemas") !!}
                </div>
				<div class="col-sm-4">
                    <input type="checkbox" id="encendedor">
                    {!! Form::label("encendedor","Encendedor") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="espejos">
                    {!! Form::label("espejos","Espejos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="antena">
                    {!! Form::label("antena","Antena") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="radio">
                    {!! Form::label("radio","Radio") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="llavero">
                    {!! Form::label("llavero","Llavero") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="placas">
                    {!! Form::label("placas","Placas") !!}
                </div>

                <div class="col-sm-4">
                    <input type="checkbox" id="platos">
                    {!! Form::label("platos","platos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="tapon_combustible">
                    {!! Form::label("tapon_combustible","Tapon de combustible") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="soporte_bateria">
                    {!! Form::label("soporte_bateria","Soporte de Bateria") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="papeles">
                    {!! Form::label("papeles","Papeles") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="alfombras">
                    {!! Form::label("alfombras","Alfombras") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="control_alarma">
                    {!! Form::label("control_alarma","Control de Alarma") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="extinguidor">
                    {!! Form::label("extinguidor","Extinguidor") !!}
                </div>     
            

                <div class="col-sm-4">
                    <input type="checkbox" id="triangulos">
                    {!! Form::label("triangulos","Triangulos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="vidrios_electricos">
                    {!! Form::label("vidrios_electricos","Vidrios Electricos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="conos">
                    {!! Form::label("conos","Conos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="neblineras">
                    {!! Form::label("neblineras","Neblineras") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="luces">
                    {!! Form::label("luces","Luces") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="llanta_repuesto">
                    {!! Form::label("llanta_repuesto","Llanta de Repuesto") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" id="llave_ruedas">
                    {!! Form::label("llave_ruedas","Llave de Ruedas") !!}
                </div>

                <div class="col-sm-4">
                    <input type="checkbox" id="tricket">
                    {!! Form::label("tricket","Tricket") !!}
                </div>
            </div>
			<br>
			<div class="col-sm-4" >
                    {!! Form::label("descripcion","Observaciones:") !!}
					{!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
            </div>
			</div>
			<br>
			<div class="row">
			
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajo2']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/ordenes_de_trabajo/create2.js') !!}
@endsection