<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <script
			  src="https://code.jquery.com/jquery-3.3.1.js"
			  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
			  crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <label for="txtNombre">Nombre</label>
                <input type="text" id="txtNombre">

                <label for="txtCantidad">Nombre</label>
                <input type="text" id="txtCantidad">
                <button type="button" id="btnEnviar">Enviar</button>
                <br>
                <table id="detalle">
                    <thead>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </thead>

                    <tfoot>
                        <th></th>
                        <th>Total</th>
                    </tfoot>

                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    <br>
    </body>


<script src="/js/compras/prueba.js"></script>
</html>
