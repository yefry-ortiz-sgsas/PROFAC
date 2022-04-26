<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Bodega;
use App\Http\Livewire\BodegaComponent\BodegaEditar;
use App\Http\Livewire\Proveedores;
use App\Http\Livewire\Usuarios\ListarUsuarios;
use App\Http\Livewire\Inventario\Producto;
use App\Http\Livewire\Inventario\Retenciones;
use App\Http\Livewire\Inventario\DetalleProducto;
use App\Http\Livewire\Inventario\CompraProducto;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
   return view('dashboard');
    //return redirect('/bodega');
})->name('dashboard');



//-----------------------Bodega-----------------------//
Route::get('/bodega', Bodega::class);
Route::get('/bodega/editar/screen', BodegaEditar::class);

Route::post('/bodega/crear',  [Bodega::class, 'crearBodega']);
Route::get('/bodega/listar/bodegas', [BodegaEditar::class, 'listarBodegas']);
Route::post('/bodega/desactivar', [BodegaEditar::class, 'desactivarBodega']);
Route::post('/bodega/datos', [BodegaEditar::class, 'obtenerDatos']);
Route::post('/bodega/editar', [BodegaEditar::class, 'editarBodega']);
//----------------------Proveedores------------------------------------------//

Route::get('/proveedores', Proveedores::class);
Route::post('/proveedores/crear',  [Proveedores::class, 'proveerdoresModelInsert']);
Route::post('/proveedores/obeter/departamentos', [Proveedores::class, 'obtenerDepartamentos']);
Route::post('/proveedores/obeter/municipios', [Proveedores::class, 'obtenerMunicipios']);
Route::get('/proveedores/listar/proveedores', [Proveedores::class, 'listarProveedores']);
Route::post('/proveedores/desactivar', [Proveedores::class, 'desactivarProveedor']);
Route::post('/proveedores/editar', [Proveedores::class, 'obtenerProveedor']);
Route::post('/proveedores/editar/guardar', [Proveedores::class, 'editarProveedor']);
Route::get('/inventario/retenciones', Retenciones::class);
Route::get('/inventario/retenciones/listar', [Retenciones::class, 'listarRetenciones']);
Route::post('/proveedores/retencion/crear', [Retenciones::class, 'registrarRetencion']);



//-----------------------------------------------Usuarios--------------------------------------------//
Route::get('/usuarios', ListarUsuarios::class);
Route::get('/usuarios/listar/usuarios', [ListarUsuarios::class, 'listarUsuarios']);




//--------------------------------------------Inventario---------------------------------------------//

Route::get('/producto/registro', Producto::class);
Route::post('/producto/registrar', [Producto::class, 'crearProducto']);
Route::post('/producto/editar', [Producto::class, 'editarProducto']);
Route::get('/producto/datos/{id}', [Producto::class, 'listarModalProductoEdit']);
Route::get('/producto/listar/productos', [Producto::class, 'listarProductos']);
Route::get('/producto/detalle/{id}', DetalleProducto::class);
Route::get('/producto/compra', CompraProducto::class);
Route::get('/producto/lista/proveedores', [CompraProducto::class,'listarProveedores']);
Route::get('/producto/tipo/pagos', [CompraProducto::class,'listarFormasPago']);
Route::get('/producto/listar/producto', [CompraProducto::class,'listarProductos']);
Route::post('/producto/listar/imagenes', [CompraProducto::class,'obtenerImagenes']);
Route::post('/prodcuto/compra/datos',[CompraProducto::class,'obtenerDatosProducto']);
Route::post('/producto/compra/retencion', [CompraProducto::class, 'comprobarRetencion']);






//------------------------------------------establecer links de storage---------------------------//
Route::get('/linkstorage', function () {
    Artisan::call('storage:link'); // this will do the command line job
});





