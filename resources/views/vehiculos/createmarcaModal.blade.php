<!-- Modal -->
<div class="modal fade" id="marcaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {{--{!! Form::open( array( 'id' => 'ClienteForm' ,'method' => 'GET') ) !!} --}}
    {!! Form::open( array( 'id' => 'MarcaForm') ) !!}
        {{csrf_field()}}
    
      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agrega Marca</h4>
            </div>
            <div class="modal-body">
              
              @include('marcas.formularioMarca')

              <input type="hidden" name="_token" id="tokenCliente" value="{{ csrf_token() }}">
    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button class="btn btn-primary">Agregar</button>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
