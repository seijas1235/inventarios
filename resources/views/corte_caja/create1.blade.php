@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">
    {!! Form::open( array( 'id' => 'CodCorteForm') ) !!}
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
                        <h3 class="inline-title">Creación de Corte Diario</h3>
                    </div>
                </div>
            </div>

            <div class="panel panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <tr>
                            <div clas="row">
                                <div class="col-sm-3">
                                    {!! Form::label("codigo_corte","Código de Corte:") !!}
                                    {!! Form::text( "codigo_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Código de Corte' ]) !!}
                                </div>

                                <div class="col-sm-3" align="text-center">
                                    <br>
                                    <a class='btn-add-new-record btn btn-success btn-title border-radius corte-button'">Iniciar Corte Diario</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="corte-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/corte_caja/create1.js') !!}
@endsection