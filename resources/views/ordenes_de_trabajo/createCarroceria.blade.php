@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<form method="POST" action="{{route('orden_de_trabajo', $orden_de_trabajo)}}">
			{{csrf_field()}} {{ method_field('PUT') }}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Carroceria (golpes) y combustible</h3>
				</div>
			</div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <input type="checkbox" style="position:absolute; left:142px; top:50px">
                        <img src="/img/carroceria.png" alt="">
                </div>
                <div class="col-sm-6">
                    <label for="observaciones">Observaciones</label><br>
                    <textarea name="observaciones" id="observaciones" rows="10" class="form-control"></textarea>
                </div>  
            </div>
			<div class="row">
				<div class="col-sm-6">
					
				</div>

				<div class="col-sm-6">
					
				</div>
			</div>
			<br>
			<div class="row">
		
			</div>
			<br>
			<div class="text-right m-t-15">
				{!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajo']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		</form>
	</div>
</div>
@endsection


@stack('scripts')

@section('scripts')
{!! HTML::script('/js/ordenes_de_trabajo/create.js') !!}

@endsection