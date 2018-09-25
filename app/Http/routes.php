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


		Route::get('/proveedores', 'ProveedoresController@index');
		Route::get('/proveedores/getJson/' , 'ProveedoresController@getJson');
		Route::get('/proveedores/new' , 'ProveedoresController@create');
		Route::post('/proveedores/save/' , 'ProveedoresController@store');
		Route::get('/proveedores/edit/{proveedor}' , 'ProveedoresController@edit');
		Route::patch('/proveedores/{proveedor}/update' , 'ProveedoresController@update');
		Route::delete('/proveedores/remove/{proveedor}' , 'ProveedoresController@destroy');



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

			Route::get( '/proveedores' , 'ProveedoresController@index');
			Route::get( '/proveedor/getJson/' , 'ProveedoresController@getJson');
			Route::get( '/proveedores/new' , 'ProveedoresController@create');
			Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit');
			Route::patch( '/proveedores/{proveedor}/update' , 'ProveedoresController@update');
			Route::post( '/proveedores/save/' , 'ProveedoresController@store');
			Route::delete( '/proveedor/remove/{proveedor}' , 'ProveedoresController@destroy');


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
			Route::post( '/clientes/save/' , 'ClientesController@store');
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

			Route::get( '/marcas' , 'MarcasController@index');
			Route::get( '/marca/getJson/' , 'MarcasController@getJson');
			Route::get( '/marcas/new' , 'MarcasController@create');
			Route::get( '/marcas/edit/{marca}' , 'MarcasController@edit');
			Route::patch( '/marcas/{marca}/update' , 'MarcasController@update');
			Route::post( '/marcas/save/' , 'MarcasController@store');
			Route::delete( '/marcas/remove/{marca}' , 'MarcasController@destroy');


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


	Route::get( '/series2' , 'SeriesController@index');
	Route::get( '/serie2/getJson/' , 'SeriesController@getJson');
	Route::get( '/series2/new' , 'SeriesController@create');
	Route::post( '/series2/save/' , 'SeriesController@store');
	Route::get( '/series2/edit/{serie}' , 'SeriesController@edit');
	Route::patch( '/series2/{serie}/update' , 'SeriesController@update');

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

	Route::get( '/factura' , 'FacturaController@index');
	Route::get( '/factura/getJson' , 'FacturaController@getJson');
	Route::get( '/facturas_clientes/{cliente_id}/GetJson' , 'FacturaController@getFacturas');
	Route::get( '/factura/new' , 'FacturaController@create');
	Route::post( '/factura/generar' , 'FacturaController@generar');
	Route::post( '/factura/save/' , 'FacturaController@save');
	Route::delete( '/factura/remove/{factura}' , 'FacturaController@remove');
	Route::get( '/factura/show/{factura}/' , 'FacturaController@showFactura');

	Route::get( '/factura/new2' , 'FacturaController@create2');
	Route::post( '/factura/save2/' , 'FacturaController@save2');

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