@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			<div class="user-created-message alert alert-dismissible fade in hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<p></p>
            </div>
            
            
			<div class="panel panel-default">
				<div class="panel panel-heading">
					<div class="row">
						<div class="col-sm-3 title-line-height"></div>
						<div class="col-sm-6 text-center">
							<h4 class="inline-title">Tipos de clientes</h4>
						</div>
						<div class="col-sm-3 title-line-height text-right">
							<div class="btn-group">
								<a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Borrar</a>
                                <a class='btn-add-new-record btn btn-success btn-title border-radius' href="{{ url('tipos_cliente/new') }}">Nuevo Tipo</a>
							</div>
						</div>
					</div>
                </div>
                
				<div class="panel panel-body">
                    
                    @foreach ($tiposcliente as $tipocliente)
                    {{$tipocliente->nombre}}
                    @endforeach
                    
                </div>
                
			</div>
		</div>
	</div>
</div>

