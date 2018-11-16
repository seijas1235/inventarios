<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () 
{

	if (Auth::check())
	{
		return view('home');
	}
	else 
	{
		return view('welcome');
	}
});


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () 
{

	Route::auth();

	Route::group(array('middleware' => 'auth'), function()
	{
		/* ========== RUTAS PARA LA GESTIÓN DE VENTAS =========== */
		Route::get( '/ventas' , 'VentasController@index');
		Route::get( '/venta/getJson' , 'VentasController@getJson');
		Route::get( '/venta/new' , 'VentasController@create');	
		Route::get('/venta/get/', 'ProductosController@getInfo');
		Route::get( '/servicio/precio/{servicio}' , 'ServiciosController@getPrecio');
		Route::get( '/cliente/datos/{cliente}' , 'ClientesController@getDatos');
		Route::get('/venta/getpartida/', 'ProductosController@getInfoPartida');
		Route::get( '/venta/save/' , 'VentasController@save');
		Route::get( '/venta/savecpc/' , 'VentasController@ccobrar');
		Route::post( '/venta-detalle/{venta_maestro}' , 'VentasController@saveDetalle');
		Route::delete( '/venta/destroy/{venta_maestro}' , 'VentasController@destroy');
		Route::get('/existencia/getJson', 'ProductosController@getJsonExistencia');
		Route::get('/pdf_ccdetalle', 'PdfController@pdf_ccdetalle');
		Route::get('/pdf_ccresumen', 'PdfController@pdf_ccresumen');
		Route::post('/cortecaja', 'VentasController@makeCorte');
		Route::get('/tipoventa/{venta_maestro}', 'VentasController@getTipoPago');
		Route::get('/ventadetalle/{venta_maestro}', 'VentasController@show');
		Route::patch('/venta/{venta_maestro}/update' , 'VentasController@update');
		Route::patch('/venta/update-total/{venta_maestro}/' , 'VentasController@updateTotal');
		Route::get('/ventadetalle/{venta_maestro}/getJson' , 'VentasController@getJsonDetalle');
		Route::delete('/ventadetalle/destroy/{venta_detalle}', 'VentasController@destroyDetalle');
		Route::delete('/ventadetalle2/destroy/{venta_detalle}/{movimiento_producto}', 'VentasController@destroyDetalle2');
		Route::delete('/ventadetalle3/destroy/{venta_detalle}', 'VentasController@destroyDetalle3');


		/*Route::get( '/salidaproducto' , 'SalidaProductoController@index' );
        Route::get( '/salidaproducto/getJson' , 'SalidaProductoController@getJson' );
        Route::get( '/salidaproducto/new' , 'SalidaProductoController@create' );
        Route::post( '/salidaproducto' , 'SalidaProductoController@store' );
        Route::get('/tiposalida/{salida_producto}', 'SalidaProductoController@getTipoSalida');
        Route::patch( '/salidaproducto/{salidaproducto}/update' , 'SalidaProductoController@update' );
        Route::resource("salidaproducto", "SalidaProductoController");
        Route::get('/salidaproducto/name/{salidaproducto}', 'SalidaProductoController@getName' );
        Route::delete( '/salidaproducto/destroy/{salidaproducto}' , 'SalidaProductoController@destroy' );*/


		Route::get('/tipos_cliente', 'TiposClienteController@index');
		Route::get('/tipos_cliente/getJson/' , 'TiposClienteController@getJson');
		Route::get('/tipos_cliente/new' , 'TiposClienteController@create');
		Route::post('/tipos_cliente/save/' , 'TiposClienteController@store');
		Route::get('/tipos_cliente/edit/{tipo_cliente}' , 'TiposClienteController@edit');
		Route::patch('/tipos_cliente/{tipo_cliente}/update' , 'TiposClienteController@update');
		Route::delete('/tipos_cliente/remove/{tipo_cliente}' , 'TiposClienteController@destroy');

		Route::get('/clientes', 'ClientesController@index');
		Route::get('/clientes/getJson/' , 'ClientesController@getJson');
		Route::get('/clientes/new' , 'ClientesController@create');
		Route::post('/clientes/save/' , 'ClientesController@store');
		Route::get('/clientes/edit/{cliente}' , 'ClientesController@edit');
		Route::patch('/clientes/{cliente}/update' , 'ClientesController@update');
		Route::delete('/clientes/remove/{cliente}' , 'ClientesController@destroy');
		Route::get('/clientes/nitDisponible/', 'ClientesController@nitDisponible');
		Route::get( '/clientes/dpiDisponible/', 'ClientesController@dpiDisponible');

		Route::get('/tipos_vehiculo', 'TiposVehiculoController@index');
		Route::get('/tipos_vehiculo/getJson/' , 'TiposVehiculoController@getJson');
		Route::get('/tipos_vehiculo/new' , 'TiposVehiculoController@create');
		Route::post('/tipos_vehiculo/save/' , 'TiposVehiculoController@store');
		Route::get('/tipos_vehiculo/edit/{tipo_vehiculo}' , 'TiposVehiculoController@edit');
		Route::patch('/tipos_vehiculo/{tipo_vehiculo}/update' , 'TiposVehiculoController@update');
		Route::delete('/tipos_vehiculo/remove/{tipo_vehiculo}' , 'TiposVehiculoController@destroy');

		//rutas puestos
		Route::get('/puestos', 'PuestosController@index');
		Route::get('/puestos/getJson/' , 'PuestosController@getJson');
		Route::get('/puestos/new' , 'PuestosController@create');
		Route::post('/puestos/save/' , 'PuestosController@store');
		Route::get('/puestos/edit/{puesto}' , 'PuestosController@edit');
		Route::patch('/puestos/{puesto}/update' , 'PuestosController@update');
		Route::delete('/puestos/remove/{puesto}' , 'PuestosController@destroy');
		
		// rutas empleados
		Route::get( '/empleados' , 'EmpleadosController@index');
		Route::get( '/empleados/getJson/' , 'EmpleadosController@getJson');
		Route::get( '/empleados/new/' , 'EmpleadosController@create');
		Route::get( '/empleados/edit/{empleado}' , 'EmpleadosController@edit');
		Route::patch( '/empleados/{empleado}/update' , 'EmpleadosController@update');
		Route::post( '/empleados/save/' , 'EmpleadosController@store');
		Route::delete( '/empleados/remove/{empleado}' , 'EmpleadosController@destroy');
		Route::get('/empleados/nitDisponible/', 'EmpleadosController@nitDisponible');
		Route::get( 'cui-disponible/', 'EmpleadosController@dpiDisponible');
		
		//Rutas Maquinarias y equipo
		Route::get('/maquinarias_equipo', 'MaquinariasEquipoController@index');
		Route::get('/maquinarias_equipo/getJson/' , 'MaquinariasEquipoController@getJson');
		Route::get('/maquinarias_equipo/new' , 'MaquinariasEquipoController@create');
		Route::post('/maquinarias_equipo/save/' , 'MaquinariasEquipoController@store');
		Route::get('/maquinarias_equipo/edit/{maquinariaequipo}' , 'MaquinariasEquipoController@edit');
		Route::patch('/maquinarias_equipo/{maquinariaequipo}/update' , 'MaquinariasEquipoController@update');
		Route::delete('/maquinarias_equipo/remove/{maquinariaequipo}' , 'MaquinariasEquipoController@destroy');
		Route::get('/maquinarias_equipo/get/', 'MaquinariasEquipoController@getInfo');
		Route::get( 'codigo-disponible-maquina/', 'MaquinariasEquipoController@codigoDisponible');
		Route::get('/existencias/maquinaria', 'MaquinariasEquipoController@existenciasIndex');
		Route::get('/existencias/maquinaria/getJson/', 'MaquinariasEquipoController@existencias');
		
		//rutas mantenimienotos de maquinarias y equipos
		Route::get('/mantto_equipo', 'MantenimientoEquiposController@index');
		Route::get('/mantto_equipo/getJson/' , 'MantenimientoEquiposController@getJson');
		Route::get('/mantto_equipo/new' , 'MantenimientoEquiposController@create');
		Route::post('/mantto_equipo/save/' , 'MantenimientoEquiposController@store');
		Route::get('/mantto_equipo/edit/{manttoequipo}' , 'MantenimientoEquiposController@edit');
		Route::patch('/mantto_equipo/{manttoequipo}/update' , 'MantenimientoEquiposController@update');
		Route::delete('/mantto_equipo/remove/{manttoequipo}' , 'MantenimientoEquiposController@destroy');
		
		//rutas Inventario de maquinarias y equipos
		Route::get('/inventario_equipo', 'InventarioEquiposController@index');
		Route::get('/inventario_equipo/getJson/' , 'InventarioEquiposController@getJson');
		Route::get('/inventario_equipo/new' , 'InventarioEquiposController@create');
		Route::post('/inventario_equipo/save/' , 'InventarioEquiposController@store');
		Route::get('/inventario_equipo/edit/{inventarioequipo}' , 'InventarioEquiposController@edit');
		Route::patch('/inventario_equipo/{inventarioequipo}/update' , 'InventarioEquiposController@update');
		Route::delete('/inventario_equipo/remove/{inventarioequipo}' , 'InventarioEquiposController@destroy');
		


		//rutas Proveedores
		Route::get( '/proveedores' , 'ProveedoresController@index');
		Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson');
		Route::get( '/proveedores/new' , 'ProveedoresController@create');
		Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit');
		Route::patch( '/proveedores/{proveedor}/update' , 'ProveedoresController@update');
		Route::post( '/proveedores/save/' , 'ProveedoresController@store');
		Route::delete( '/proveedores/remove/{proveedor}' , 'ProveedoresController@destroy');
		Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible');

		Route::get('/vehiculos', 'VehiculosController@index');
		Route::get('/vehiculos/getJson/' , 'VehiculosController@getJson');
		Route::get('/vehiculos/new' , 'VehiculosController@create');
		Route::post('/vehiculos/save/' , 'VehiculosController@store');
		Route::post( '/vehiculos/save/modal' , 'VehiculosController@store2')->name('vehiculos.store2');
		Route::get('/vehiculos/edit/{vehiculo}' , 'VehiculosController@edit');
		Route::patch('/vehiculos/{vehiculo}/update' , 'VehiculosController@update');
		Route::delete('/vehiculos/remove/{vehiculo}' , 'VehiculosController@destroy');
		Route::get( 'placa-disponible/', 'VehiculosController@placaDisponible');
		Route::get( 'vin-disponible/', 'VehiculosController@vinDisponible');
		Route::get( '/linea/obtener/{marca}' , 'LineasController@getDatos');

		Route::get('/unidades_de_medida', 'UnidadesDeMedidaController@index');
		Route::get('/unidades_de_medida/getJson/' , 'UnidadesDeMedidaController@getJson');
		Route::get('/unidades_de_medida/new' , 'UnidadesDeMedidaController@create');
		Route::post('/unidades_de_medida/save/' , 'UnidadesDeMedidaController@store');
		Route::get('/unidades_de_medida/edit/{unidad_de_medida}' , 'UnidadesDeMedidaController@edit');
		Route::patch('/unidades_de_medida/{unidad_de_medida}/update' , 'UnidadesDeMedidaController@update');
		Route::delete('/unidades_de_medida/remove/{unidad_de_medida}' , 'UnidadesDeMedidaController@destroy');
		Route::get( '/unidad_de_medida/cantidad/{unidad_de_medida}' , 'UnidadesDeMedidaController@getCantidad');

		Route::get('/tipos_proveedor', 'TiposProveedorController@index');
		Route::get('/tipos_proveedor/getJson/' , 'TiposProveedorController@getJson');
		Route::get('/tipos_proveedor/new' , 'TiposProveedorController@create');
		Route::post('/tipos_proveedor/save/' , 'TiposProveedorController@store');
		Route::get('/tipos_proveedor/edit/{tipo_proveedor}' , 'TiposProveedorController@edit');
		Route::patch('/tipos_proveedor/{tipo_proveedor}/update' , 'TiposProveedorController@update');
		Route::delete('/tipos_proveedor/remove/{tipo_proveedor}' , 'TiposProveedorController@destroy');

		Route::get('/marcas', 'MarcasController@index');
		Route::get('/marcas/getJson/' , 'MarcasController@getJson');
		Route::get('/marcas/new' , 'MarcasController@create');
		Route::post('/marcas/save/' , 'MarcasController@store');
		Route::get('/marcas/edit/{marca}' , 'MarcasController@edit');
		Route::patch('/marcas/{marca}/update' , 'MarcasController@update');
		Route::delete('/marcas/remove/{marca}' , 'MarcasController@destroy');
		Route::get( '/marcas/marcaDisponible/', 'MarcasController@marcaDisponible');


		// Rutas de lineas
		Route::get('/lineas', 'LineasController@index');
		Route::get('/lineas/getJson/' , 'LineasController@getJson');
		Route::get('/lineas/new' , 'LineasController@create');
		Route::post('/lineas/save/' , 'LineasController@store');
		Route::get('/lineas/edit/{linea}' , 'LineasController@edit');
		Route::patch('/lineas/{linea}/update' , 'LineasController@update');
		Route::delete('/lineas/remove/{linea}' , 'LineasController@destroy');
		Route::get( '/lineas/lineaDisponible/', 'LineasController@lineaDisponible');


		Route::get('/productos', 'ProductosController@index');
		Route::get('/productos/getJson/' , 'ProductosController@getJson');
		Route::get('/productos/new' , 'ProductosController@create');
		Route::post('/productos/save/' , 'ProductosController@store');
		Route::get('/productos/edit/{producto}' , 'ProductosController@edit');
		Route::patch('/productos/{producto}/update' , 'ProductosController@update');
		Route::delete('/productos/remove/{producto}' , 'ProductosController@destroy');
		Route::get( '/producto/precio/{producto}' , 'ProductosController@getPrecio');
		Route::get('/existencias/producto', 'ProductosController@existenciasIndex');
		Route::get('/existencias/getJson/', 'ProductosController@existencias');
		Route::get( 'codigo-disponible/', 'ProductosController@codigoDisponible');

		Route::get('/precios_producto', 'PreciosProductoController@index');
		Route::get('/precios_producto/getJson/' , 'PreciosProductoController@getJson');
		Route::get('/precios_producto/new' , 'PreciosProductoController@create');
		Route::post('/precios_producto/save/' , 'PreciosProductoController@store');
		Route::get('/precios_producto/edit/{precio_producto}' , 'PreciosProductoController@edit');
		Route::patch('/precios_producto/{precio_producto}/update' , 'PreciosProductoController@update');
		Route::delete('/precios_producto/remove/{precio_producto}' , 'PreciosProductoController@destroy');

		Route::get('/documentos', 'DocumentosController@index');
		Route::get('/documentos/getJson/' , 'DocumentosController@getJson');
		Route::get('/documentos/new' , 'DocumentosController@create');
		Route::post('/documentos/save/' , 'DocumentosController@store');
		Route::get('/documentos/edit/{documento}' , 'DocumentosController@edit');
		Route::patch('/documentos/{documento}/update' , 'DocumentosController@update');
		Route::delete('/documentos/remove/{documento}' , 'DocumentosController@destroy');

		Route::get('/tipos_servicio', 'TiposServicioController@index');
		Route::get('/tipos_servicio/getJson/' , 'TiposServicioController@getJson');
		Route::get('/tipos_servicio/new' , 'TiposServicioController@create');
		Route::post('/tipos_servicio/save/' , 'TiposServicioController@store');
		Route::get('/tipos_servicio/edit/{tipo_servicio}' , 'TiposServicioController@edit');
		Route::patch('/tipos_servicio/{tipo_servicio}/update' , 'TiposServicioController@update');
		Route::delete('/tipos_servicio/remove/{tipo_servicio}' , 'TiposServicioController@destroy');

		Route::get('/servicios', 'ServiciosController@index');
		Route::get('/servicios/getJson/' , 'ServiciosController@getJson');
		Route::get('/servicios/new' , 'ServiciosController@create');
		Route::post('/servicios/save/' , 'ServiciosController@store');
		Route::get('/servicios/edit/{servicio}' , 'ServiciosController@edit');
		Route::patch('/servicios/{servicio}/update' , 'ServiciosController@update');
		Route::delete('/servicios/remove/{servicio}' , 'ServiciosController@destroy');
		Route::get( '/servicios/save/' , 'ServiciosController@save');
		Route::post( '/servicios-detalle/{servicio}' , 'ServiciosController@saveDetalle');
		Route::get('/servicios/show/{servicio}' , 'ServiciosController@show');
		Route::get( '/servicios/{servicio}/getJson' , 'ServiciosController@getJsonDetalle' );
		Route::get( '/codigo-disponible-servicio/', 'ServiciosController@codigoDisponible');

		Route::get( '/compras' , 'ComprasController@index' );
        Route::get( '/compras/getJson' , 'ComprasController@getJson' );
        Route::get( '/compras/new' , 'ComprasController@create' );
        Route::get( '/compras/save/' , 'ComprasController@save');
        Route::post( '/compras-detalle/{compra}' , 'ComprasController@saveDetalle');
        Route::patch( '/compras/{compra}/update' , 'ComprasController@update' );
        Route::resource("compras", "ComprasController");
        Route::get('/compras/name/{compra}', 'ComprasController@getName' );
		Route::delete('/compras/destroy/{compra}' , 'ComprasController@destroy' );
		Route::get('/productos/get/', 'ProductosController@getInfo');
		
        Route::get('/detallescompras/{compra}', 'ComprasController@show');
        Route::get( '/detallescompras/{compra}/getJson' , 'ComprasController@getJsonDetalle' );
		Route::patch( '/detallescompras/{compra}/update' , 'ComprasController@update' );
		Route::delete( '/detallescompras/destroy/{detallecompra}' , 'ComprasController@destroyDetalle' );
		Route::get('/detallescompras/name/{detallecompra}', 'ComprasController@getDetalle');		
		Route::get('/compras/edit/{compra}', 'ComprasController@edit');

		//Rutas Planillas
		Route::get( '/planillas' , 'PlanillasController@index' );
        Route::get( '/planillas/getJson' , 'PlanillasController@getJson' );
        Route::get( '/planillas/new' , 'PlanillasController@create' );
        Route::get( '/planillas/save/' , 'PlanillasController@save');
        Route::post( '/planillas-detalle/{planilla}' , 'PlanillasController@saveDetalle');
        Route::patch( '/planillas/{planilla}/update' , 'PlanillasController@update' );
        Route::resource("planillas", "PlanillasController");
        Route::get('/planillas/name/{planilla}', 'PlanillasController@getName' );
		Route::delete('/planillas/destroy/{planilla}' , 'PlanillasController@destroy' );
		Route::get('/empleados/get/', 'EmpleadosController@getInfo');
		
        Route::get('/detallesplanillas/{planilla}', 'PlanillasController@show');
        Route::get( '/detallesplanillas/{planilla}/getJson' , 'PlanillasController@getJsonDetalle' );
		Route::patch( '/detallesplanillas/{planilla}/update' , 'PlanillasController@update' );
		Route::delete( '/detallesplanillas/destroy/{detalleplanilla}' , 'PlanillasController@destroyDetalle' );
		Route::get('/planillas/edit/{planilla}', 'PlanillasController@edit');

		Route::get('/cuentas_por_pagar', 'CuentasPorPagarController@index');
		Route::get('/cuentas_por_pagar/getJson/' , 'CuentasPorPagarController@getJson');
		Route::get('/cuentas_por_pagar/show/{cuenta_por_pagar}' , 'CuentasPorPagarController@show');
		Route::get( '/cuentas_por_pagar/{cuenta_por_pagar}/getJson' , 'CuentasPorPagarController@getJsonDetalle' );
		Route::get('/cuentas_por_pagar/new/notacredito' , 'CuentasPorPagarController@notacredito');
		Route::get('/cuentas_por_pagar/new/notadebito' , 'CuentasPorPagarController@notadebito');
		Route::post('/cuentas_por_pagar/save/notacredito' , 'CuentasPorPagarController@savenotacredito');
		Route::post('/cuentas_por_pagar/save/notadebito' , 'CuentasPorPagarController@savenotadebito');
		

		Route::get('/cuentas_por_cobrar', 'CuentasPorCobrarController@index');
		Route::get('/cuentas_por_cobrar/getJson/' , 'CuentasPorCobrarController@getJson');
		Route::get('/cuentas_por_cobrar/show/{cuenta_por_cobrar}' , 'CuentasPorCobrarController@show');
		Route::get( '/cuentas_por_cobrar/{cuenta_por_cobrar}/getJson' , 'CuentasPorCobrarController@getJsonDetalle' );
		Route::get('/cuentas_por_cobrar/new/notacredito' , 'CuentasPorCobrarController@notacredito');
		Route::get('/cuentas_por_cobrar/new/notadebito' , 'CuentasPorCobrarController@notadebito');
		Route::post('/cuentas_por_cobrar/save/notacredito' , 'CuentasPorCobrarController@savenotacredito');
		Route::post('/cuentas_por_cobrar/save/notadebito' , 'CuentasPorCobrarController@savenotadebito');


		Route::get('/ordenes_de_trabajo' , 'OrdenesDeTrabajoController@index');
		Route::get('/ordenes_de_trabajo/getJson/' , 'OrdenesDeTrabajoController@getJson');
		Route::get('/ordenes_de_trabajo/new' , 'OrdenesDeTrabajoController@new');
		Route::get('/ordenes_de_trabajo/create2/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@create2')->name('ordenes_de_trabajo.create2');
		Route::post('/ordenes_de_trabajo/save' , 'OrdenesDeTrabajoController@save')->name('ordenes_de_trabajo.save');
		Route::get('/ordenes_de_trabajo/createServicios/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@createServicios')->name('ordenes_de_trabajo.create3');
		Route::post('/ordenes_de_trabajo/saveServicios/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@saveServicios')->name('ordenes_de_trabajo.save3');
		Route::patch('/ordenes_de_trabajo/total/{orden_de_trabajo}/' , 'OrdenesDeTrabajoController@updateTotal');
		Route::get('/ordenes_de_trabajo/edit/{orden}' , 'OrdenesDeTrabajoController@edit');


		Route::get('/ordenes_de_trabajo/create3/{orden_de_trabajo}' , 'OrdenesDeTrabajoController@create3')->name('ordenes_de_trabajo.create3');
		Route::post('/ordenes_de_trabajo/save2' , 'OrdenesDeTrabajoController@save2');
		Route::post('/ordenes_de_trabajo/{orden}/golpes/' , 'OrdenesDeTrabajoController@golpes')->name('ordenes_de_trabajo.golpe');
		Route::post('/ordenes_de_trabajo/{orden}/rayones/' , 'OrdenesDeTrabajoController@rayones')->name('ordenes_de_trabajo.rayon');


		//Reporte Ordenes
		Route::get( '/rpt_orden_trabajo/{orden_de_trabajo}' , 'PdfController@rpt_orden_trabajo');
		
		Route::get( '/rpt_estado_cuenta_por_pagar/generar' , 'CuentasPorPagarController@rpt_generar');	
		Route::post( '/rpt_estado_cuenta_por_pagar/' , 'CuentasPorPagarController@rpt_estado_cuenta_por_pagar');

		Route::get( '/rpt_estado_cuenta_por_cobrar/generar' , 'CuentasPorCobrarController@rpt_generar');
		Route::post( '/rpt_estado_cuenta_por_cobrar/' , 'CuentasPorCobrarController@rpt_estado_cuenta_por_cobrar');

		Route::get( '/rpt_ventas/generar' , 'VentasController@rpt_generar');
		Route::post( '/rpt_ventas/' , 'VentasController@rpt_ventas');

		Route::get('/rpt_factura/{venta}' , 'PdfController@rpt_factura');


		Route::get('/cajas_chicas', 'CajasChicasController@index');
		Route::get('/cajas_chicas/getJson/' , 'CajasChicasController@getJson');
		Route::get('/cajas_chicas/new/egreso' , 'CajasChicasController@newegreso');
		Route::get('/cajas_chicas/new/ingreso' , 'CajasChicasController@newingreso');
		Route::post('/cajas_chicas/save/egreso' , 'CajasChicasController@saveegreso');
		Route::post('/cajas_chicas/save/ingreso' , 'CajasChicasController@saveingreso');
		Route::get( '/caja_chica/saldo' , 'CajasChicasController@getSaldo');

		Route::get( '/ingresos_productos' , 'IngresosProductoController@index' );
        Route::get( '/ingresos_productos/getJson' , 'IngresosProductoController@getJson' );
        Route::get( '/ingresos_productos/new' , 'IngresosProductoController@create' );
        Route::post( '/ingresos_productos/save/' , 'IngresosProductoController@save');
		Route::patch( '/ingresos_productos/{ingreso_producto}/update' , 'IngresosProductoController@update' );
		Route::get('/ingresos_productos/edit/{ingreso_producto}', 'IngresosProductoController@edit');
		Route::delete('/ingresos_productos/destroy/{ingreso_producto}' , 'IngresosProductoController@destroy' );

		Route::get( '/salidas_productos' , 'SalidaProductoController@index' );
        Route::get( '/salidas_productos/getJson' , 'SalidaProductoController@getJson' );
        Route::get( '/salidas_productos/new' , 'SalidaProductoController@create' );
        Route::post( '/salidas_productos/save/' , 'SalidaProductoController@save');
		Route::patch( '/salidas_productos/{salida_producto}/update' , 'SalidaProductoController@update' );
		Route::get('/salidas_productos/edit/{salida_producto}', 'SalidaProductoController@edit');
		Route::delete('/salidas_productos/destroy/{salida_producto}' , 'SalidaProductoController@destroy' );

		Route::get( '/conversiones_productos' , 'ConversionesProductoController@index' );
        Route::get( '/conversiones_productos/getJson' , 'ConversionesProductoController@getJson' );
        Route::get( '/conversiones_productos/new' , 'ConversionesProductoController@create' );
		Route::post( '/conversiones_productos/save/' , 'ConversionesProductoController@save');
		Route::get('/conversiones_productos/show/{conversion_producto}' , 'ConversionesProductoController@show');
		Route::get( '/conversiones_productos/{conversion_producto}/getJson' , 'ConversionesProductoController@getJsonDetalle');
		
		//Route::patch( '/conversiones_productos/{conversion_producto}/update' , 'ConversionesProductoController@update' );
		//Route::get('/conversiones_productos/edit/{conversion_producto}', 'ConversionesProductoController@edit');
		//Route::delete('/conversiones_productos/destroy/{conversion_producto}' , 'ConversionesProductoController@destroy' );


		//rutas Cortes de caja
		Route::get( '/cortes_caja' , 'CortesCajaController@index');
		Route::get( '/cortes_caja/getJson/' , 'CortesCajaController@getJson');
		Route::get( '/cortes_caja/new' , 'CortesCajaController@create');
		Route::get( '/cortes_caja/edit/{corte_caja}' , 'CortesCajaController@edit');
		Route::patch( '/cortes_caja/{corte_caja}/update' , 'CortesCajaController@update');
		Route::post( '/cortes_caja/save/' , 'CortesCajaController@store');
		Route::delete( '/cortes_caja/remove/{corte_caja}' , 'CortesCajaController@destroy');
		Route::get('/cortes_caja/getEfectivo/', 'CortesCajaController@getEfectivo');
		Route::get('/cortes_caja/getCredito/', 'CortesCajaController@getCredito');
		Route::get('/cortes_caja/getTarjeta/', 'CortesCajaController@getTarjeta');
		Route::get('/cortes_caja/getTotal/', 'CortesCajaController@getTotal');
		Route::get('/cortes_caja/getEfectivoSF/', 'CortesCajaController@getEfectivoSF');
		Route::get('/cortes_caja/getCreditoSF/', 'CortesCajaController@getCreditoSF');
		Route::get('/cortes_caja/getTarjetaSF/', 'CortesCajaController@getTarjetaSF');
		Route::get('/cortes_caja/getTotalSF/', 'CortesCajaController@getTotalSF');
		Route::get('/cortes_caja/getTotalVenta/', 'CortesCajaController@getTotalVenta');
		Route::get( '/cortes_caja/corteUnico/', 'CortesCajaController@corteUnico');
		Route::get( '/cortes_caja/getFacturas/', 'CortesCajaController@getFacturas');

		
		Route::get( '/vales2/get/' , 'ValesController@getJson');

		Route::get('/home', 'HomeController@index');
		Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

		Route::patch( '/user/{user}/change' , 'UserController@changePassword' );
		Route::patch( '/user/{user}/changeInfo' , 'UserController@changeInformation' );

		Route::group(array('middleware' => 'acl' , 'is' => 'superadmin' ), function()
		{
			Route::get( '/factores' , 'FactoresController@index');
			Route::get( '/factores/getJson/' , 'FactoresController@getJson');
			Route::get( '/factores/new' , 'FactoresController@create');
			Route::post( '/factores/save/' , 'FactoresController@store');
			Route::get( '/factores/edit/{factor}' , 'FactoresController@edit');
			Route::patch( '/factores/{factor}/update' , 'FactoresController@update');
			Route::delete( '/factores/remove/{factor}' , 'FactoresController@destroy');
		});

			Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|administrator' ), function()
		{

			Route::get( '/requisiciones' , 'RequisicionesController@index');
			Route::get( '/requisiciones/getJson/' , 'RequisicionesController@getJson');
			Route::get( '/requisiciones/new' , 'RequisicionesController@create');
			Route::post( '/requisiciones/save/' , 'RequisicionesController@store');
			Route::get( '/requisiciones/edit/{requisicion}' , 'RequisicionesController@edit');
			Route::patch( '/requisiciones/{requisicion}/update' , 'RequisicionesController@update');
			Route::delete( '/requisiciones/remove/{requisicion}' , 'RequisicionesController@destroy');
			Route::post( '/requisiciones/rechaza/{requisicion}' , 'RequisicionesController@rechaza');
			Route::get( '/requisiciones/autoriza/{requisicion}' , 'RequisicionesController@autoriza');
			Route::get( '/requisicion/getInfo/{requisicion}' , 'RequisicionesController@getInfo');


			Route::get( '/cheques' , 'ChequesController@index');
			Route::get( '/cheques/getJson/' , 'ChequesController@getJson');
			Route::get( '/cheques/new' , 'ChequesController@create');
			Route::post( '/cheques/save/' , 'ChequesController@store');
			Route::get( '/cheques/edit/{cheque}' , 'ChequesController@edit');
			Route::patch( '/cheques/{cheque}/update' , 'ChequesController@update');
			Route::delete( '/cheques/remove/{cheque}' , 'ChequesController@destroy');
			Route::get( '/cheques/reg_cobro/{cheque}' , 'ChequesController@reg_cobro');
			Route::get( '/cheques/show/{cheque}/' , 'ChequesController@showCheque');


			Route::get( '/cuentas' , 'CuentasController@index');
			Route::get( '/cuentas/getJson/' , 'CuentasController@getJson');
			Route::get( '/cuentas/new' , 'CuentasController@create');
			Route::post( '/cuentas/save/' , 'CuentasController@store');
			Route::get( '/cuentas/edit/{cuenta}' , 'CuentasController@edit');
			Route::patch( '/cuentas/{cuenta}/update' , 'CuentasController@update');
			Route::delete( '/cuentas/remove/{cuenta}' , 'CuentasController@destroy');

			Route::get( '/cuentas_contables' , 'CuentaContableController@index');
			Route::get( '/cuentas_contables/getJson/' , 'CuentaContableController@getJson');
			Route::get( '/cuentas_contables/new' , 'CuentaContableController@create');
			Route::post( '/cuentas_contables/save/' , 'CuentaContableController@store');
			Route::get( '/cuentas_contables/edit/{cuentac}' , 'CuentaContableController@edit');
			Route::patch( '/cuentas_contables/{cuentac}/update' , 'CuentaContableController@update');
			Route::delete( '/cuentas_contables/remove/{cuentac}' , 'CuentaContableController@destroy');

			Route::get( '/corte_caja' , 'CorteCajaController@index');
			Route::get( '/corte_caja/getJson/' , 'CorteCajaController@getJson');
			Route::get( '/corte_caja/new' , 'CorteCajaController@create');
			Route::post( '/corte_caja/save/' , 'CorteCajaController@store');
			Route::get( '/corte_caja/edit/{cortec}' , 'CorteCajaController@edit');
			Route::patch( '/corte_caja/{cortec}/update' , 'CorteCajaController@update');
			Route::get( '/corte_caja_get' , 'CorteCajaController@create1');
			Route::get( '/corte_caja/show/{cortec}/' , 'CorteCajaController@showCorte');
			Route::get( '/corte_caja/show2/{cortec}/' , 'CorteCajaController@showCorte2');
			Route::get('corte-disponible/', 'CorteCajaController@Corte_Disponible');


			Route::get( '/cdrubros' , 'CorteDiarioRubroController@index');
			Route::get( '/cdrubros/getJson/' , 'CorteDiarioRubroController@getJson');
			Route::get( '/cdrubros/new' , 'CorteDiarioRubroController@create');
			Route::post( '/cdrubros/save/' , 'CorteDiarioRubroController@store');
			Route::get( '/cdrubros/edit/{rubro}' , 'CorteDiarioRubroController@edit');
			Route::patch( '/cdrubros/{rubro}/update' , 'CorteDiarioRubroController@update');
			Route::delete( '/cdrubros/remove/{rubro}' , 'CorteDiarioRubroController@destroy');

			Route::get( '/corte_diario' , 'CorteDiarioController@index');
			Route::get( '/corte_diario/getJson/' , 'CorteDiarioController@getJson');
			Route::get( '/corte_diario/new' , 'CorteDiarioController@create');
			Route::post( '/corte_diario/save/' , 'CorteDiarioController@store');
			Route::get( '/corte_diario/edit/{corte}' , 'CorteDiarioController@edit');
			Route::patch( '/corte_diario/{corte}/update' , 'CorteDiarioController@update');
			Route::delete( '/corte_diario/remove/{corte}' , 'CorteDiarioController@destroy');
			

			Route::get( '/gastos' , 'GastosController@index');
			Route::get( '/gastos/getJson/' , 'GastosController@getJson');
			Route::get( '/gastos/new' , 'GastosController@create');
			Route::post( '/gastos/save/' , 'GastosController@store');
			Route::get( '/gastos/edit/{gasto}' , 'GastosController@edit');
			Route::patch( '/gastos/{gasto}/update' , 'GastosController@update');
			Route::delete( '/gastos/remove/{gasto}' , 'GastosController@destroy');


			Route::get( '/camiones' , 'CamionesController@index');
			Route::get( '/camiones/getJson/' , 'CamionesController@getJson');
			Route::get( '/camiones/new' , 'CamionesController@create');
			Route::get( '/camiones/edit/{camion}' , 'CamionesController@edit');
			Route::patch( '/camiones/{camion}/update' , 'CamionesController@update');
			Route::post( '/camiones/save/' , 'CamionesController@store');
			Route::delete( '/camiones/remove/{camion}' , 'CamionesController@destroy');


			Route::get( '/destinos' , 'DestinoController@index');
			Route::get( '/destinos/getJson/' , 'DestinoController@getJson');
			Route::get( '/destinos/new' , 'DestinoController@create');
			Route::get( '/destinos/edit/{destino}' , 'DestinoController@edit');
			Route::patch( '/destinos/{destino}/update' , 'DestinoController@update');
			Route::post( '/destinos/save/' , 'DestinoController@store');
			Route::delete( '/destinos/remove/{destino}' , 'DestinoController@destroy');


			Route::get( '/user' , 'UserController@index' );
			Route::get( '/user/getJson' , 'UserController@getJson' );
			Route::post( '/user/names' , 'UserController@getNames' );
			Route::post( '/user/store' , 'UserController@store' );
			Route::delete( '/user/destroy/{user}' , 'UserController@destroy' );
			Route::delete( '/user/multiple/destroy' , 'UserController@multipleDestroy' );
			Route::patch( '/user/{user}/update' , 'UserController@update' );
			Route::get( '/user/show/' , 'UserController@getInformationByUser');
			Route::get('/user/name/{user}', 'UserController@getName' );

			//clientes routes
			Route::get( '/clientes' , 'ClientesController@index');
			Route::get( '/cliente/getJson/' , 'ClientesController@getJson');
			Route::get( '/clientes/new/' , 'ClientesController@create');
			Route::get( '/clientes/edit/{cliente}' , 'ClientesController@edit');
			Route::patch( '/clientes/{cliente}/update' , 'ClientesController@update');
			Route::post( '/clientes/save/' , 'ClientesController@store')->name('clientes.store');
			Route::post( '/clientes/save/modal' , 'ClientesController@store2')->name('clientes.store2');
			Route::delete( '/clientes/active/{cliente}' , 'ClientesController@active');
			Route::delete( '/clientes/remove/{cliente}' , 'ClientesController@destroy');
			Route::delete( '/clientes/bloquear/{cliente}' , 'ClientesController@bloquear');

			Route::get( '/empleados' , 'EmpleadosController@index');
			Route::get( '/empleado/getJson/' , 'EmpleadosController@getJson');
			Route::get( '/empleados/new' , 'EmpleadosController@create');
			Route::get( '/empleados/edit/{empleado}' , 'EmpleadosController@edit');
			Route::patch( '/empleados/{empleado}/update' , 'EmpleadosController@update');
			Route::post( '/empleados/save/' , 'EmpleadosController@store');
			Route::delete( '/empleado/remove/{empleado}' , 'EmpleadosController@destroy');
			Route::post( '/empleado/active/{empleado}' , 'EmpleadosController@active');
			Route::get('cui-disponible/', 'EmpleadosController@dpiDisponible');
			Route::get('cui-disponible-edit/', 'EmpleadosController@dpiDisponibleEdit');

			Route::get( '/bombas' , 'BombaController@index');
			Route::get( '/bombas/getJson/' , 'BombaController@getJson');
			Route::get( '/bombas/new' , 'BombaController@create');
			Route::post( '/bombas/save/' , 'BombaController@store');
			Route::get( '/bombas/edit/{bomba}' , 'BombaController@edit');
			Route::patch( '/bomba/{bomba}/update' , 'BombaController@update');
			Route::delete( '/bombas/remove/{bomba}' , 'BombaController@destroy');

			Route::get( '/bombas_combustibles' , 'Bomba_CombustibleController@index');
			Route::get( '/bombas_combustibles/getJson/' , 'Bomba_CombustibleController@getJson');
			Route::get( '/bombas_combustibles/new' , 'Bomba_CombustibleController@create');
			Route::post( '/bombas_combustibles/save/' , 'Bomba_CombustibleController@store');
			Route::get( '/bombas_combustibles/edit/{bomba_combustible}' , 'Bomba_CombustibleController@edit');
			Route::patch( '/bombas_combustibles/{bomba_combustible}/update' , 'Bomba_CombustibleController@update');
			Route::delete( '/bombas_combustibles/remove/{bomba_combustible}' , 'Bomba_CombustibleController@destroy');

			Route::get( '/cargos' , 'CargoEmpleadoController@index');
			Route::get( '/cargos/getJson/' , 'CargoEmpleadoController@getJson');
			Route::get( '/cargos/new' , 'CargoEmpleadoController@create');
			Route::post( '/cargos/save/' , 'CargoEmpleadoController@store');
			Route::get( '/cargos/edit/{cargo}' , 'CargoEmpleadoController@edit');
			Route::patch( '/cargos/{cargo}/update' , 'CargoEmpleadoController@update');
			Route::delete( '/cargos/remove/{cargo}' , 'CargoEmpleadoController@destroy');


			Route::get( '/productos' , 'ProductosController@index');
			Route::get( '/producto/getJson/' , 'ProductosController@getJson');
			Route::get( '/productos/new' , 'ProductosController@create');
			Route::get( '/productos/edit/{producto}' , 'ProductosController@edit');
			Route::patch( '/productos/{producto}/update' , 'ProductosController@update');
			Route::post( '/productos/save/' , 'ProductosController@store');
			Route::post( '/productos/save_precios/{producto}' , 'ProductosController@store_precios');
			Route::delete( '/productos/remove/{producto}' , 'ProductosController@destroy');
			Route::get('producto-disponible/', 'ProductosController@Producto_Disponible');
			Route::get('producto-disponible-edit/', 'ProductosController@Producto_Disponible_Edit');
			Route::get('/detalleproductos/{detalle}/GetJson' , 'ProductosController@getJsonDetalle');
			Route::get( '/productos/detalle/{producto}' , 'ProductosController@getDetalle');

			Route::get( '/precio_combustible' , 'PrecioCombustibleController@index');
			Route::get( '/precio_combustible/getJson/' , 'PrecioCombustibleController@getJson');
			Route::get( '/precio_combustible/new' , 'PrecioCombustibleController@create');
			Route::post( '/precio_combustible/save/' , 'PrecioCombustibleController@store');
			Route::get( '/precio_combustible/edit/{precio_combustible}' , 'PrecioCombustibleController@edit');
			Route::patch( '/precio_combustible/{precio_combustible}/update' , 'PrecioCombustibleController@update');	
		});


Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|administrator|operador' ), function()
{

	Route::get( '/vales' , 'ValesController@index');
	Route::get( '/vales_blanco' , 'ValesController@valeBlanco');
	Route::get( '/vales/new' , 'ValesController@create');

	Route::get( '/combustible/{bomba}' , 'ValesController@getTipo');
	Route::get( '/producto/precio/{producto}' , 'ProductosController@getPrecio');
	Route::get( '/combustible/precio/{combustible}' , 'PrecioCombustibleController@getPrecio');
	Route::post( '/vales/save/' , 'ValesController@store');
	Route::post( '/vales/saveBlanco/' , 'ValesController@storeBlanco');
	Route::get( '/vales/saveedit/{vale_maestro}/' , 'ValesController@storeEdit2');
	Route::get( '/vales/getEdit/{vale}/' , 'ValesController@getEdit');
	Route::get( '/vale/detalle/{vale}' , 'ValesController@getDetalle');
	Route::get('/valedetalle/{vale}/GetJson' , 'ValesController@getJsonDetalle');
	Route::get('/vales/edit/{vale}/' , 'ValesController@editVale');
	Route::get('/vale-disponible', 'ValesController@Vale_Disponible');

	Route::get( '/vales/new2' , 'ValesController@create2');
	Route::get( '/vale/show/{vale_maestro}' , 'ValesController@getVale');
	Route::delete( '/vales/remove/{vale_maestro}' , 'ValesController@destroy');
	Route::get( '/vale/show_blanco/{vale_maestro}' , 'ValesController@showValeBlanco');

	Route::get( '/vales/newauto' , 'ValesController@createauto');
	Route::post( '/vales/saveauto/' , 'ValesController@storeauto');

			//Reporte Vales Generados por fecha y cliente
	Route::get( '/rpt_vales/' , 'ValesController@rpt_vales');
	Route::get( '/rpt_vales/getJson' , 'ValesController@getJson_rptvales');
	Route::post( '/pdf_vales', 'PdfController@pdf_vales');

			//Reporte Total de Vales por rango de fechas
	Route::get( '/rpt_valestotal/' , 'ValesController@rpt_valestotal');
	Route::get( '/rpt_valestotal/getJson' , 'ValesController@getJson_rptvalestotal');
	Route::post( '/pdf_vales_fechas', 'PdfController@pdf_vales_fechas');

			//Reporte Notas de Crédito
	Route::get( '/rpt_ncs/' , 'NotaCreditoController@rpt_nc');
	Route::get( '/rpt_ncs/getJson' , 'NotaCreditoController@getJson_rptnc');
	Route::post( '/pdf_ncs', 'PdfController@pdf_ncs');

});


Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|administrator|finanzas' ), function()
{




	//Rutas para Series
	Route::get( '/series' , 'SeriesController@index');
	Route::get( '/series/getJson/' , 'SeriesController@getJson');
	Route::get( '/series/new' , 'SeriesController@create');
	Route::post( '/series/save/' , 'SeriesController@store');
	Route::get( '/series/edit/{serie}' , 'SeriesController@edit');
	Route::patch( '/series/{serie}/update' , 'SeriesController@update');
	
	//Rutas para Facturas
	Route::get('/factura', 'FacturasController@index');
	Route::get('/factura/getJson/' , 'FacturasController@getJson');
	Route::get('/factura/new' , 'FacturasController@create');
	Route::post('/factura/save/' , 'FacturasController@store');
	Route::get('/factura/edit/{factura}' , 'FacturasController@edit');
	Route::patch('/factura/{factura}/update' , 'FacturasController@update');
	Route::delete('/factura/remove/{factura}' , 'FacturasController@destroy');
	Route::get( '/serie/datos/{serie}' , 'SeriesController@getDatos');
	Route::get( '/facturas/noDisponible/', 'FacturasController@noDisponible');

	Route::get( '/bancos' , 'BancosController@index');
	Route::get( '/bancos/getJson/' , 'BancosController@getJson');
	Route::get( '/bancos/new' , 'BancosController@create');
	Route::post( '/bancos/save/' , 'BancosController@store');
	Route::get( '/bancos/edit/{banco}' , 'BancosController@edit');
	Route::patch( '/bancos/{banco}/update' , 'BancosController@update');
	Route::delete( '/bancos/remove/{banco}' , 'BancosController@destroy');

	Route::get( '/factura_cambiaria' , 'FacturaCambiariaController@index');
	Route::get( '/factura_cambiaria/getJson/' , 'FacturaCambiariaController@getJson');
	Route::get( '/factura_cambiaria/new' , 'FacturaCambiariaController@create');
	Route::get( '/factura_cambiaria/new2' , 'FacturaCambiariaController@create2');
	Route::get( '/vales_clientes/{cliente_id}/GetJson' , 'FacturaCambiariaController@getVales');
	Route::post( '/factura_cambiaria/generar' , 'FacturaCambiariaController@generar');
	Route::post( '/factura_cambiaria/generar2' , 'FacturaCambiariaController@generar2');
	Route::post( '/factura_cambiaria/save/' , 'FacturaCambiariaController@save');
	Route::post( '/factura_cambiaria/save2' , 'FacturaCambiariaController@save2');
	Route::get( '/factura_cambiaria/show/{factura}/' , 'FacturaCambiariaController@showFactura');
	Route::delete( '/factura_cambiaria/remove/{factura}' , 'FacturaCambiariaController@remove');
	Route::get('factura-validation/', 'FacturaCambiariaController@unicaFactura');

	/*Route::get( '/factura' , 'FacturasController@index');
	Route::get( '/factura/getJson' , 'FacturasController@getJson');
	Route::get( '/facturas_clientes/{cliente_id}/GetJson' , 'FacturasController@getFacturas');
	Route::get( '/factura/new' , 'FacturasController@create');
	Route::post( '/factura/generar' , 'FacturasController@generar');
	Route::post( '/factura/save/' , 'FacturasController@save');
	Route::delete( '/factura/remove/{factura}' , 'FacturasController@remove');
	Route::get( '/factura/show/{factura}/' , 'FacturasController@showFactura');
	Route::get( '/factura/new2' , 'FacturasController@create2');
	Route::get( '/factura/edit/{factura}' , 'FacturasController@edit');
	Route::post( '/factura/save2/' , 'FacturasController@save2');*/
	

	Route::get( '/nota_credito' , 'NotaCreditoController@index');
	Route::get( '/nota_credito/getJson/' , 'NotaCreditoController@getJson');
	Route::get( '/nota_credito/new' , 'NotaCreditoController@create');
	Route::get( '/nota_credito/descuento/{tipo}/{cliente}' , 'NotaCreditoController@crearNotaDescuento');
	Route::get( '/nota_credito/prontopago/{tipo}/{cliente}' , 'NotaCreditoController@crearNotaDescuentoPP');
	Route::get( '/nota_credito/refacturacion/{tipo}/{cliente}' 
		, 'NotaCreditoController@crearNotaDescuentoRef');
	Route::get( '/nota_credito/descuento/save/' , 'NotaCreditoController@storeDescuento');
	Route::get( '/nota_credito/pronto/save/' , 'NotaCreditoController@storePronto');
	Route::get( '/nota_credito/refacturacion/save/' , 'NotaCreditoController@storeRef');
	Route::get( '/nota_credito/show/{nota}/' , 'NotaCreditoController@showNotaCredito');
	Route::post( '/nota_credito/generarRef' , 'NotaCreditoController@generarRef');
	Route::delete( '/nota_credito/remove/{nota}/' , 'NotaCreditoController@remove');


	Route::get( '/recibo_caja' , 'ReciboCajaController@index');
	Route::get( '/recibo_caja/getJson/' , 'ReciboCajaController@getJson');
	Route::get( '/recibo_caja/new' , 'ReciboCajaController@create');
	Route::get( '/facturas_clientes/{cliente_id}/GetJson' , 'ReciboCajaController@getFacturas');
	Route::post( '/recibo_caja/notas' , 'ReciboCajaController@selectNota');
	Route::post( '/recibo_caja/generar' , 'ReciboCajaController@generar');
	Route::post( '/recibo_caja/save/' , 'ReciboCajaController@save');
	Route::get( '/recibo_caja/show/{recibo}/' , 'ReciboCajaController@showRecibo');
	Route::delete( '/recibo_caja/remove/{recibo}' , 'ReciboCajaController@destroy');
Route::get('/recibo-disponible', 'ReciboCajaController@Recibo_Disponible');

	Route::get( '/idp' , 'IdpController@index');
	Route::get( '/idp/getJson/' , 'IdpController@getJson');
	Route::get( '/idp/new' , 'IdpController@create');
	Route::post( '/idp/save/' , 'IdpController@store');
	Route::get( '/idp/edit/{idp}' , 'IdpController@edit');
	Route::patch( '/idp/{idp}/update' , 'IdpController@update');
	Route::delete( '/idp/remove/{idp}' , 'IdpController@destroy');

Route::get( '/nota_credito2' , 'NotasCreditosController@index');
	Route::get( '/nota_credito2/getJson/' , 'NotasCreditosController@getJson');
	Route::get( '/nota_credito2/new' , 'NotasCreditosController@create');
	Route::post( '/nota_credito2/save/' , 'NotasCreditosController@store');
	Route::get( '/nota_credito2/edit/{nota_credito}' , 'NotasCreditosController@edit');
	Route::patch( '/nota_credito2/{nota_credito}/update' , 'NotasCreditosController@update');
	Route::delete( '/nota_credito2/remove/{nota_credito}' , 'NotasCreditosController@destroy');

	Route::get( '/nota_debito2' , 'NotasDebitosController@index');
	Route::get( '/nota_debito2/getJson/' , 'NotasDebitosController@getJson');
	Route::get( '/nota_debito2/new' , 'NotasDebitosController@create');
	Route::post( '/nota_debito2/save/' , 'NotasDebitosController@store');
	Route::get( '/nota_debito2/edit/{nota_debito}' , 'NotasDebitosController@edit');
	Route::patch( '/nota_debito2/{nota_debito}/update' , 'NotasDebitosController@update');
	Route::delete( '/nota_debito2/remove/{nota_debito}' , 'NotasDebitosController@destroy');

	Route::get( '/saldos_clientes' , 'SaldosClientesController@index');
	Route::get( '/saldos_clientes/getJson/' , 'SaldosClientesController@getJson');
	Route::get( '/saldos_clientes/new' , 'SaldosClientesController@create');
	Route::post( '/saldos_clientes/save/' , 'SaldosClientesController@store');
	Route::get( '/saldos_clientes/edit/{saldo_cliente}' , 'SaldosClientesController@edit');
	Route::patch( '/saldos_clientes/{saldo_cliente}/update' , 'SaldosClientesController@update');
	Route::delete( '/saldos_clientes/remove/{saldo_cliente}' , 'SaldosClientesController@destroy');

	Route::get( '/vouchers' , 'VoucherTarjetaController@index');
	Route::get( '/vouchers/getJson/' , 'VoucherTarjetaController@getJson');
	Route::get( '/vouchers/new' , 'VoucherTarjetaController@create');
	Route::post( '/vouchers/save/' , 'VoucherTarjetaController@store');
	Route::get( '/vouchers/edit/{voucher}' , 'VoucherTarjetaController@edit');
	Route::patch( '/vouchers/{voucher}/update' , 'VoucherTarjetaController@update');
	Route::delete( '/vouchers/remove/{voucher}' , 'VoucherTarjetaController@destroy');

	Route::get( '/faltantes' , 'FaltantesController@index');
	Route::get( '/faltantes/getJson/' , 'FaltantesController@getJson');
	Route::get( '/faltantes/new' , 'FaltantesController@create');
	Route::post( '/faltantes/save/' , 'FaltantesController@store');
	Route::get( '/faltantes/edit/{faltante}' , 'FaltantesController@edit');
	Route::patch( '/faltantes/{faltante}/update' , 'FaltantesController@update');
	Route::delete( '/faltantes/remove/{faltante}' , 'FaltantesController@destroy');

	Route::get( '/cupones' , 'CuponesController@index');
	Route::get( '/cupones/getJson/' , 'CuponesController@getJson');
	Route::get( '/cupones/new' , 'CuponesController@create');
	Route::post( '/cupones/save/' , 'CuponesController@store');
	Route::get( '/cupones/edit/{cupon}' , 'CuponesController@edit');
	Route::patch( '/cupones/{cupon}/update' , 'CuponesController@update');
	Route::delete( '/cupones/remove/{cupon}' , 'CuponesController@destroy');

	Route::get( '/anticipos' , 'AnticiposEmpleadosController@index');
	Route::get( '/anticipos/getJson/' , 'AnticiposEmpleadosController@getJson');
	Route::get( '/anticipos/new' , 'AnticiposEmpleadosController@create');
	Route::post( '/anticipos/save/' , 'AnticiposEmpleadosController@store');
	Route::get( '/anticipos/edit/{anticipo}' , 'AnticiposEmpleadosController@edit');
	Route::patch( '/anticipos/{anticipo}/update' , 'AnticiposEmpleadosController@update');
	Route::delete( '/anticipos/remove/{anticipo}' , 'AnticiposEmpleadosController@destroy');
	Route::get( '/abonos_empleados' , 'AnticiposEmpleadosController@index_abonos');
	Route::get( '/abonos_empleados/getJson/' , 'AnticiposEmpleadosController@getJson_abonos');
	Route::get( '/abonos_empleados/new' , 'AnticiposEmpleadosController@create_abonos');
	Route::post( '/abonos_empleados/save/' , 'AnticiposEmpleadosController@store_abonos');

	Route::get( '/bg_repuestos' , 'BGRepuestosController@index');
	Route::get( '/bg_repuestos/getJson/' , 'BGRepuestosController@getJson');
	Route::get( '/bg_repuestos/new' , 'BGRepuestosController@create');
	Route::post( '/bg_repuestos/save/' , 'BGRepuestosController@store');
	Route::get( '/bg_repuestos/edit/{bg_repuesto}' , 'BGRepuestosController@edit');
	Route::patch( '/bg_repuestos/{bg_repuesto}/update' , 'BGRepuestosController@update');
	Route::delete( '/bg_repuestos/remove/{bg_repuesto}' , 'BGRepuestosController@destroy');

	Route::get( '/bg_viaticos' , 'BGViaticosController@index');
	Route::get( '/bg_viaticos/getJson/' , 'BGViaticosController@getJson');
	Route::get( '/bg_viaticos/new' , 'BGViaticosController@create');
	Route::post( '/bg_viaticos/save/' , 'BGViaticosController@store');
	Route::get( '/bg_viaticos/edit/{bg_viatico}' , 'BGViaticosController@edit');
	Route::patch( '/bg_viaticos/{bg_viatico}/update' , 'BGViaticosController@update');
	Route::delete( '/bg_viaticos/remove/{bg_viatico}' , 'BGViaticosController@destroy');

	Route::get( '/bg_salarios' , 'BGSalariosController@index');
	Route::get( '/bg_salarios/getJson/' , 'BGSalariosController@getJson');
	Route::get( '/bg_salarios/new' , 'BGSalariosController@create');
	Route::post( '/bg_salarios/save/' , 'BGSalariosController@store');
	Route::get( '/bg_salarios/edit/{bg_salario}' , 'BGSalariosController@edit');
	Route::patch( '/bg_salarios/{bg_salario}/update' , 'BGSalariosController@update');
	Route::delete( '/bg_salarios/remove/{bg_salario}' , 'BGSalariosController@destroy');

	Route::get( '/bg_combustibles' , 'BGCombustibleController@index');
	Route::get( '/bg_combustibles/getJson/' , 'BGCombustibleController@getJson');
	Route::get( '/bg_combustibles/new' , 'BGCombustibleController@create');
	Route::post( '/bg_combustibles/save/' , 'BGCombustibleController@store');
	Route::get( '/bg_combustibles/edit/{bg_combustible}' , 'BGCombustibleController@edit');
	Route::patch( '/bg_combustibles/{bg_combustible}/update' , 'BGCombustibleController@update');
	Route::delete( '/bg_combustibles/remove/{bg_combustible}' , 'BGCombustibleController@destroy');

	Route::get( '/bg_mantenimientos' , 'BGMantenimientoController@index');
	Route::get( '/bg_mantenimientos/getJson/' , 'BGMantenimientoController@getJson');
	Route::get( '/bg_mantenimientos/new' , 'BGMantenimientoController@create');
	Route::post( '/bg_mantenimientos/save/' , 'BGMantenimientoController@store');
	Route::get( '/bg_mantenimientos/edit/{bg_mantenimiento}' , 'BGMantenimientoController@edit');
	Route::patch( '/bg_mantenimientos/{bg_mantenimiento}/update' , 'BGMantenimientoController@update');
	Route::delete( '/bg_mantenimientos/remove/{bg_mantenimiento}' , 'BGMantenimientoController@destroy');

	Route::get( '/bg_fletes' , 'BGFletesController@index');
	Route::get( '/bg_fletes/getJson/' , 'BGFletesController@getJson');
	Route::get( '/bg_fletes/new' , 'BGFletesController@create');
	Route::post( '/bg_fletes/save/' , 'BGFletesController@store');
	Route::get( '/bg_fletes/edit/{bg_flete}' , 'BGFletesController@edit');
	Route::patch( '/bg_fletes/{bg_flete}/update' , 'BGFletesController@update');
	Route::delete( '/bg_fletes/remove/{bg_flete}' , 'BGFletesController@destroy');

	Route::get( '/bg_cortes' , 'BGCorteController@index');
	Route::get( '/bg_cortes/getJson/' , 'BGCorteController@getJson');
	Route::get( '/bg_cortes/new' , 'BGCorteController@create1');
	Route::post( '/bg_cortes/save/' , 'BGCorteController@store');
	Route::get( '/bg_cortes/edit/{bg_corte}' , 'BGCorteController@edit');
	Route::patch( '/bg_cortes/{bg_corte}/update' , 'BGCorteController@update');
	Route::delete( '/bg_cortes/remove/{bg_corte}' , 'BGCorteController@destroy');
	Route::get( '/bg_cortes_get' , 'BGCorteController@create');

	Route::get( '/operaciones' , 'OperacionBancariaController@index');
	Route::get( '/operaciones/getJson/' , 'OperacionBancariaController@getJson');
	Route::get( '/operaciones/new' , 'OperacionBancariaController@create');
	Route::post( '/operaciones/save/' , 'OperacionBancariaController@store');
	Route::get( '/operaciones/edit/{operacion}' , 'OperacionBancariaController@edit');
	Route::patch( '/operaciones/{operacion}/update' , 'OperacionBancariaController@update');
	Route::delete( '/operaciones/remove/{operacion}' , 'OperacionBancariaController@destroy');

	Route::get( '/medidas' , 'MedidasTanquesController@index');
	Route::get( '/medidas/getJson/' , 'MedidasTanquesController@getJson');
	Route::get( '/medidas/new' , 'MedidasTanquesController@create');
	Route::post( '/medidas/save/' , 'MedidasTanquesController@store');
	Route::get( '/medidas/edit/{medida}' , 'MedidasTanquesController@edit');
	Route::patch( '/medidas/{medida}/update' , 'MedidasTanquesController@update');
	Route::delete( '/medidas/remove/{medida}' , 'MedidasTanquesController@destroy');
Route::get('/medida-disponible', 'MedidasTanquesController@Medida_Disponible');

	Route::get( '/diferencias' , 'DiferenciasController@index');
	Route::get( '/diferencias/getJson/' , 'DiferenciasController@getJson');
	Route::get( '/diferencias/new' , 'DiferenciasController@create');
	Route::post( '/diferencias/save/' , 'DiferenciasController@store');
	Route::get( '/diferencias/edit/{diferencia}' , 'DiferenciasController@edit');
	Route::patch( '/diferencias/{diferencia}/update' , 'DiferenciasController@update');
	Route::delete( '/diferencias/remove/{diferencia}' , 'DiferenciasController@destroy');
	Route::get( '/diferencias/inventarioayer/{combustible}' , 'DiferenciasController@getInventario');
Route::get('/diferencia-disponible', 'DiferenciasController@Diferencia_Disponible');

	Route::get( '/pagosfletes' , 'BGPagoFletesController@index');
	Route::get( '/pagosfletes/getJson/' , 'BGPagoFletesController@getJson');
	Route::get( '/pagosfletes/new' , 'BGPagoFletesController@create');
	Route::post( '/pagosfletes/save/' , 'BGPagoFletesController@store');
	Route::get( '/pagosfletes/edit/{pagoflete}' , 'BGPagoFletesController@edit');
	Route::patch( '/pagosfletes/{pagoflete}/update' , 'BGPagoFletesController@update');
	Route::delete( '/pagosfletes/remove/{pagoflete}' , 'BGPagoFletesController@destroy');



//Reportes
	Route::get( '/rpt_listado_abono_diario' , 'PdfController@rpt_lad');
	Route::get( '/pdf_lad' , 'PdfController@rpt_pdf_lad');
	Route::post( '/xls_lad' , 'PdfController@rpt_xls_lad');

	Route::get( '/rpt_listado_vale_diario' , 'PdfController@rpt_lvd');
	Route::get( '/pdf_lvd' , 'PdfController@rpt_pdf_lvd');
	Route::post( '/xls_lvd' , 'PdfController@rpt_xls_lvd');

	Route::get( '/rpt_listado_vale_cliente' , 'PdfController@rpt_lvc');
	Route::get( '/pdf_lvc' , 'PdfController@rpt_pdf_lvc');
	Route::post( '/xls_lvc' , 'PdfController@rpt_xls_lvc');

	Route::get( '/rpt_estado_cuenta_cliente' , 'PdfController@rpt_ecc');
	Route::get( '/pdf_ecc' , 'PdfController@rpt_pdf_ecc');
	Route::post( '/xls_ecc' , 'PdfController@rpt_xls_ecc');

	Route::get( '/saldos_consolidado_cliente' , 'PdfController@rpt_scc');
	Route::get( '/pdf_scc' , 'PdfController@rpt_pdf_scc');
	Route::post( '/xls_scc' , 'PdfController@rpt_xls_scc');

	Route::get( '/rpt_listado_gasto_diario' , 'PdfController@rpt_lgd');
	Route::get( '/pdf_lgd' , 'PdfController@rpt_pdf_lgd');
	Route::post( '/xls_lgd' , 'PdfController@rpt_xls_lgd');

	Route::get( '/rpt_listado_vouchers_diario' , 'PdfController@rpt_lvsd');
	Route::get( '/pdf_lvsd' , 'PdfController@rpt_pdf_lvsd');
	Route::post( '/xls_lvsd' , 'PdfController@rpt_xls_lvsd');

	Route::get( '/rpt_listado_faltantes_efectivo' , 'PdfController@rpt_lfed');
	Route::get( '/pdf_lfed' , 'PdfController@rpt_pdf_lfed');
	Route::post( '/xls_lfed' , 'PdfController@rpt_xls_lfed');

	Route::get( '/rpt_listado_anticipos_diario' , 'PdfController@rpt_lasd');
	Route::get( '/pdf_lasd' , 'PdfController@rpt_pdf_lasd');
	Route::post( '/xls_lasd' , 'PdfController@rpt_xls_lasd');

	Route::get( '/rpt_bg_repuestos_fechas' , 'PdfController@rpt_lbgrf');
	Route::get( '/pdf_lbgrf' , 'PdfController@rpt_pdf_lbgrf');
	Route::post( '/xls_lbgrf' , 'PdfController@rpt_xls_lbgrf');

	Route::get( '/rpt_bg_viaticos_fechas' , 'PdfController@rpt_lbgvf');
	Route::get( '/pdf_lbgvf' , 'PdfController@rpt_pdf_lbgvf');
	Route::post( '/xls_lbgvf' , 'PdfController@rpt_xls_lbgvf');

	Route::get( '/rpt_bg_combustibles_fechas' , 'PdfController@rpt_lbgcf');
	Route::get( '/pdf_lbgcf' , 'PdfController@rpt_pdf_lbgcf');
	Route::post( '/xls_lbgcf' , 'PdfController@rpt_xls_lbgcf');

	Route::get( '/rpt_bg_salarios_fechas' , 'PdfController@rpt_lbgsf');
	Route::get( '/pdf_lbgsf' , 'PdfController@rpt_pdf_lbgsf');
	Route::post( '/xls_lbgsf' , 'PdfController@rpt_xls_lbgsf');

	Route::get( '/listado_clientes' , 'PdfController@rpt_pdf_lcg');
	Route::get( '/saldos_consolidado_cliente' , 'PdfController@rpt_pdf_scc');
	Route::get( '/rpt_movs_combustible' , 'PdfController@rpt_pdf_rmc');
	Route::get( '/rpt_bg_seguros_fechas' , 'PdfController@rpt_pdf_bgsf');
	Route::get( '/rpt_edo_cuenta_fletes' , 'PdfController@rpt_pdf_ecf');

	Route::get( '/rpt_bg_gastos_gral' , 'PdfController@rpt_bgg');
	Route::get( '/pdf_bgg' , 'PdfController@rpt_pdf_bgg');
	Route::post( '/xls_bgg' , 'PdfController@rpt_xls_bgg');

	Route::get( '/estado_cuenta_bancaria' , 'PdfController@rpt_ecb');
	Route::get( '/pdf_ecb' , 'PdfController@rpt_pdf_ecb');
	Route::post( '/xls_ecb' , 'PdfController@rpt_xls_ecb');

	Route::get( '/rpt_estado_cuenta_empleado' , 'PdfController@rpt_ece');
	Route::get( '/pdf_ece' , 'PdfController@rpt_pdf_ece');
	Route::post( '/xls_ece' , 'PdfController@rpt_xls_ece');

	Route::get( '/rpt_diferencias_fechas' , 'PdfController@rpt_rdf');
	Route::get( '/pdf_rdf' , 'PdfController@rpt_pdf_rdf');
	Route::post( '/xls_rdf' , 'PdfController@rpt_xls_rdf');

	Route::get( '/rpt_listado_cupones' , 'PdfController@rpt_lcp');
	Route::get( '/pdf_lcp' , 'PdfController@rpt_pdf_lcp');
	Route::post( '/xls_lcp' , 'PdfController@rpt_xls_lcp');

        Route::get( '/rpt_combustible_mes' , 'PdfController@rpt_rcm');
	Route::get( '/pdf_rcm' , 'PdfController@rpt_pdf_rcm');
	Route::post( '/xls_rcm' , 'PdfController@rpt_xls_rcm');

Route::get( '/saldos_consolidado_cliente' , 'PdfController@rpt_sccf');
	Route::get( '/pdf_sccf' , 'PdfController@rpt_pdf_sccf');
	Route::post( '/xls_sccf' , 'PdfController@rpt_xls_sccf');

Route::get( '/rpt_cierre_mes' , 'PdfController@rpt_pdf_cmes2');
	Route::get( '/rpt_cierre_mes2' , 'PdfController@rpt_cmes');
	Route::get( '/pdf_cmes' , 'PdfController@rpt_pdf_cmes');
	Route::post( '/xls_cmes' , 'PdfController@rpt_xls_cmes');
});
});
});