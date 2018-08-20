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
                        <h3 class="inline-title">Compras de Compustible en Galones por Mes </h3>
                    </div>
                </div>
            </div>

            <div class="panel panel-body">
                {!! Form::open( array('method' => 'post', 'action' => array('PdfController@rpt_xls_rcm')) )  !!}
                <div class="row">
                    <div class="col-md-12">
                        <tr>
                        <div clas="row">
                            <div class="col-sm-4">
                                {!! Form::label("mes_id","Mes:") !!}
                                   <select class="selectpicker" id='mes_id' name="mes_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                                    @foreach ($meses as $mes)
                                    <option value="{{$mes->id}}">{{$mes->mes}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                            {!! Form::label("anio_id","Año:") !!}
                                   <select class="selectpicker" id='anio_id' name="anio_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>
                            </div>
                            <div class="col-sm-4" align="text-center">
                                <br>
                                <a class='btn-add-new-record btn btn-success btn-title border-radius pdf_rcm-button'">Generar PDF</a> 

                                <!-- {!! Form::input('submit', 'submit', 'Generar XLS', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'XLS_ECC_Button']) !!} -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <table id="rptrcm-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
            </table>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/reportes/reportes.js') !!}
@endsection