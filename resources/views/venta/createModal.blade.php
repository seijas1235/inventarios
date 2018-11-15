<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'ClienteForm', 'route' => 'clientes.store2') ) !!}
            {{csrf_field()}}
      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agrega</h4>
            </div>
            <div class="modal-body"> 
                
              <div class="row">
                <div class="col-sm-3">
                  {!! Form::label("nit","NIT:") !!}
                  {!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label("email","e-mail:") !!}
                  {!! Form::text( "email" , null , ['class' => 'form-control' , 'placeholder' => 'e-mail']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label("tipo_cliente_id","Tipo de Cliente:") !!}
                  <select class="selectpicker" id='tipo_cliente_id' name="tipo_cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_clientes as $tipo_cliente)
                    <option value="{{$tipo_cliente->id}}">{{$tipo_cliente->nombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-3">
                  {!! Form::label("clasificacion_cliente_id","Clasificacion:") !!}
                  <select class="selectpicker" id='clasificacion_cliente_id' name="clasificacion_cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clasificaciones as $clasificacion)
                    <option value="{{$clasificacion->id}}">{{$clasificacion->nombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-4">
                  {!! Form::label("dpi","DPI/CUI:") !!}
                  {!! Form::text( "dpi" , null , ['class' => 'form-control' , 'placeholder' => 'DPI/CUI' ]) !!}
                </div>
                <div class="col-sm-4">
                  {!! Form::label("nombres","Nombres:") !!}
                  {!! Form::text( "nombres" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
                </div>
                <div class="col-sm-4">
                  {!! Form::label("apellidos","Apellidos:") !!}
                  {!! Form::text( "apellidos" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3">
                  {!! Form::label("fecha_nacimiento","Fecha Nacimiento:") !!}
                  {!! Form::date( "fecha_nacimiento" , null , ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-4">
                  {!! Form::label("telefonos","Telefonos:") !!}
                  {!! Form::text( "telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Telefonos' ]) !!}
                </div>
        
                <div class="col-sm-5">
                  {!! Form::label("direccion","Dirección:") !!}
                  {!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
                </div>
              
              </div>
                    <br>
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                  <br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button class="btn btn-primary">Agregar</button>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      
