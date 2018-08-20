@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">
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
                        <h3 class="inline-title">Listado de Vales Diarios</h3>
                    </div>
                </div>
            </div>

            <div class="panel panel-body">
            {!! Form::open( array('method' => 'post', 'action' => array('PdfController@rpt_xls_lvd')) )  !!}

                <div class="row">
                    <div class="col-md-12">
                        <tr>
                            <div clas="row">
                                <div class="col-sm-3">
                                    {!! Form::label("fechav","Fecha de Corte:") !!}
                                    {!! Form::text( "fechav" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Corte' ]) !!}
                                </div>

                                <div class="col-sm-3" align="text-center">
                                    <br>
                                    <a class='btn-add-new-record btn btn-success btn-title border-radius pdf_lvd-button'">Generar PDF</a> 

                                    <!-- {!! Form::input('submit', 'submit', 'Generar XLS', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'XLS_LVD_Button']) !!} -->
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

                <table id="rptlvd-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/reportes/rpt_ncs.js') !!}
{!! HTML::script('/../../sfi/sfi/js/reportes/reportes.js') !!}
@endsection