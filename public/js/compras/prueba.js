$(document).ready(function(){
    $('#btnEnviar').click(function(){
        //alerta();
        agregar();
    });


    function alerta(){
        saludo = $("#txtNombre").val();

        alert("Hola:" +saludo);
    }

    var cont=0;


    function agregar(){
        nombre = $("#txtNombre").val();
        cantidad = $("#txtCantidad").val();

        var fila ='<tr id="fila'+cont+'"><td><input type="text" name="nombre[]" value="'+ nombre+'"></td> <td><input type="number" name="cantidad[]" value="'+ cantidad+'"></td> <tr>';
        cont++;
        $('#detalle').append(fila);
    }


}); 