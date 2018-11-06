@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			<div class="user-created-message alert alert-dismissible fade in hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<p></p>
            </div>
            
			@if ( isset( $user_created ) )
			<div class="alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				{{ $user_created  }}
			</div>
            @endif
            
			<div class="panel panel-default">
				<div class="panel panel-heading">
					<div class="row">
						<div class="col-sm-3 title-line-height"></div>
						<div class="col-sm-6 text-center">
							<h4 class="inline-title">Cuentas Por Pagar</h4>
						</div>
						<div class="col-sm-3 title-line-height text-right">
							<div class="btn-group">
								<a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Borrar</a>
								<a class='btn-add-new-record btn btn-success btn-title border-radius tip-top' href="{{ url('cuentas_por_pagar/new/notacredito') }}" title="Solo proveedor con cuenta activa">Nota de Credito</a>
								<a class='btn-add-new-record btn btn-success btn-title border-radius' href="{{ url('cuentas_por_pagar/new/notadebito') }}">Nota de Debito</a>
							</div>
						</div>
					</div>
                </div>
                
				<div class="panel panel-body">
					<table id="cuentas_por_pagar-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
					</table>
                </div>
                
			</div>
		</div>
	</div>
</div>


@endsection
@section('scripts')
{!! HTML::script('/js/cuentas_por_pagar/index.js') !!}
@endsection