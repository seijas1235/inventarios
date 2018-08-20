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
                        <h3 class="inline-title">Listado de Notas de Crédito</h3>
                    </div>
                </div>
            </div>

            <div class="panel panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <tr>
                            {!! Form::open( array( 'action' => array('PdfController@pdf_ncs')  , 'id' => 'submit-vales') ) !!}
                            <div clas="row">

                                <div class="col-sm-3">
                                    {!! Form::label("cliente","Clientes:") !!}
                                    <select class="form-control" id='clientes' name="userslst" value="{{ old('role')}}">
                                        @foreach ($lst_clientes as $data)
                                        <option value="{{$data->id}}">{{ $data->cliente}}</option>;
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                {!! Form::label("fecha_nc","Fecha:") !!}
                                    {!! Form::text( "fecha_nc" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha' ]) !!}
                                </div>

                                <div class="col-sm-3" align="text-center">
                                    <br>
                                    {!! Form::submit('Generar Excel' , ['class' => 'btn btn-success btn-submit-valexls' , 'data-loading-text' => 'Processing...' ]) !!}
                                    {!! Form::close() !!}
                                </div>

                                <div class="col-sm-3" align="text-center">
                                    <br>
                                    <!-- {!! Form::submit('Generar PDF' , ['class' => 'btn btn-success btn-submit-valepdf' , 'data-loading-text' => 'Processing...' ]) !!}
                                    {!! Form::close() !!} -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <table id="rptnc-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/reportes/rpt_nc.js') !!}
@endsection