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
                        <h3 class="inline-title">Estado de Cuenta por Empleado</h3>
                    </div>
                </div>
            </div>
            <div class="panel panel-body">
                {!! Form::open( array('method' => 'post', 'action' => array('PdfController@rpt_xls_ece')) )  !!}
                <div class="row">
                    <div class="col-md-12">
                        <tr>
                            <div clas="row">
                                <div class="col-sm-12">
                                   {!! Form::label("empleado_id","Empleado:") !!}
                                   <select class="selectpicker" id='empleado_id' name="empleado_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                                    @foreach ($empleados as $emp)
                                    <option value="{{$emp->id}}">{{$emp->emp_nombres}} {{$emp->emp_apellidos}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div clas="row">
                            <div class="col-sm-3">
                                {!! Form::label("fechainicioece","Fecha Inicio:") !!}
                                {!! Form::text( "fechainicioece" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Inicio' ]) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::label("fechafinalece","Fecha Final:") !!}
                                {!! Form::text( "fechafinalece" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Final' ]) !!}
                            </div>
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-3" align="text-center">
                                <br>
                                <a class='btn-add-new-record btn btn-success btn-title border-radius pdf_ece-button'">Generar PDF</a> 

                                <!-- {!! Form::input('submit', 'submit', 'Generar XLS', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'XLS_ECC_Button']) !!} -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <table id="rptece-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
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