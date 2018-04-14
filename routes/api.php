<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'AuthenticateController@login');

Route::middleware('auth')->group(function() {
  Route::get('/home', 'HomeController@index')->name('home');
  Route::post('logout', 'AuthenticateController@logout');  
  Route::resource('users','UsersController', ['except' => ['edit']]); 
  Route::resource('afiliados','AfiliadosController', ['except' => ['edit']]);  
  Route::get('/buscaAfiliado', 'AfiliadosController@buscaAfiliado')->name('buscaAfiliado');  
  Route::get('/compras', 'AfiliadosController@compras')->name('compras'); 

  Route::resource('hijos','HijosController', ['except' => ['edit']]);  
  Route::resource('asociaciones','AsociacionesController', ['except' => ['edit']]);    
  Route::resource('ubicaciones','UbicacionesController', ['except' => ['edit']]);
  Route::resource('lotizaciones','LotizacionesController', ['except' => ['edit']]);
  Route::resource('ventas','VentasController', ['except' => ['edit']]); 
  Route::resource('empleados','EmpleadosController', ['except' => ['edit']]);  
  Route::resource('perfiles','PerfilesController', ['except' => ['edit']]);  
  Route::resource('modulos','ModulosController', ['except' => ['edit']]); 
  Route::resource('pagos','PagosController', ['except' => ['edit']]); 
  Route::resource('tipos-pagosextraordinarios','TiposPagosExtraordinariosController', ['except' => ['edit']]);     
  Route::get('/pagosventa', 'PagosController@pagos')->name('pagos');       
  Route::put('/empleados/updateattribute/{id}','EmpleadosController@updateAttribute');                               
});

