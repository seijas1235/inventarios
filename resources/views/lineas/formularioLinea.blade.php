<div class="row">
    <div class="col-sm-12">
        <h3 class="tittle-custom"> Creación de Lineas de Vehiculo</h3>
        <line>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-4">
            {!! Form::label("linea","Linea:") !!}
            {!! Form::text( "linea" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre Linea' ]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label("marca_id","Marca:") !!}
            <select class="form-control"  name="marca_id" value="" id="marca_id_linea" data-live-search-placeholder="Búsqueda" title="Seleccione">
            </select>
        </div>
    </div>
    <br>