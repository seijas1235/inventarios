<!-- Modal -->
<div class="modal fade" id="ModalVehiculo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        {!! Form::open( array( 'id' => 'VehiculoForm', 'route' => 'vehiculos.store2') ) !!}
                {{csrf_field()}}
        
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Agrega</h4>
                </div>
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="tittle-custom"> Creación de Vehiculos </h3>
                            <line>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                {!! Form::label("placa","No Placa:") !!}
                                {!! Form::text( "placa" , null , ['class' => 'form-control' , 'placeholder' => 'No Placa' ]) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! Form::label("aceite_caja","Aceite Caja:") !!}
                                {!! Form::text( "aceite_caja" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite Recomendado' ]) !!}
                                
                            </div>
                            <div class="col-sm-4">
                                {!! Form::label("aceite_motor","Aceite Motor:") !!}
                                {!! Form::text( "aceite_motor" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite Recomendado' ]) !!}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                {!! Form::label("tipo_vehiculo_id","Tipo de Vehiculo:") !!}
                                <select class="selectpicker" id='tipo_vehiculo_id' name="tipo_vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                                    @foreach ($tipos_vehiculos as $tipo_vehiculo)
                                    <option value="{{$tipo_vehiculo->id}}">{{$tipo_vehiculo->nombre}}</option>							
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! Form::label("marca_id","Marca:") !!}
                                <select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                                    @foreach ($marcas as $marca)
                                    <option value="{{$marca->id}}">{{$marca->nombre}}</option>							
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! Form::label("fecha_ultimo_servicio","Fecha Ultimo Servicio:") !!}
                                {!! Form::date( "fecha_ultimo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Ultimo Servicio' ]) !!}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                {!! Form::label("año","Año Vehiculo:") !!}
                                {!! Form::text( "año" , null , ['class' => 'form-control' , 'placeholder' => 'Año Vehiculo' ]) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::label("color","Color:") !!}
                                {!! Form::text( "color" , null , ['class' => 'form-control' , 'placeholder' => 'Color' ]) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::label("kilometraje","Kilometraje:") !!}
                                {!! Form::number( "kilometraje" , null , ['class' => 'form-control' , 'placeholder' => 'Kilometraje' ]) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::label("linea","linea:") !!}
                                {!! Form::text( "linea" , null , ['class' => 'form-control' , 'placeholder' => 'Linea' ]) !!}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                {!! Form::label("tipo_transmision_id","Tipo de Transmision:") !!}
                                <select class="selectpicker" id='tipo_transmision_id' name="tipo_transmision_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                                    @foreach ($tipos_transmision as $tipo_transmision)
                                    <option value="{{$tipo_transmision->id}}">{{$tipo_transmision->nombre}}</option>							
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                {!! Form::label("cliente_id","Dueño:") !!}
                                <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                                    @foreach ($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->nombres.' '.$cliente->apellidos}}</option>							
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                {!! Form::label("chasis","Chasis:") !!}
                                {!! Form::text( "chasis" , null , ['class' => 'form-control' , 'placeholder' => 'Chasis' ]) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::label("vin","VIN:") !!}
                                {!! Form::text( "vin" , null , ['class' => 'form-control' , 'placeholder' => 'VIN' ]) !!}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                {!! Form::label("observaciones","Observacciones de inspeccion:") !!}
                                {!! Form::textarea( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones de inspeccion', 'rows'=> '5' ]) !!}
                            </div>
                        </div>
                        <br>
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    </br>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button class="btn btn-primary">Agregar</button>
                </div>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
    