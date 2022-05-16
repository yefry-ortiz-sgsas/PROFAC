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
use App\Http\Livewire\Inventario\ListarCompras;
use App\Http\Livewire\Inventario\DetalleCompra;
use App\Http\Livewire\Inventario\PagosCompra;
use App\Http\Livewire\Inventario\RecibirProducto;
use App\Http\Livewire\Inventario\Incidencias;
use App\Http\Livewire\Inventario\AnularCompra;
use App\Http\Livewire\Inventario\Translados;
use App\Http\Livewire\Clientes\Cliente;
use App\Http\Livewire\Clientes\PerfilCliente;
use App\Http\Livewire\Facturaciones\Facturacion;

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

//-------------------------------------------------CLIENTES---------------------------------------------//
Route::get('/clientes', Cliente::class);
Route::get('/perfilCliente', PerfilCliente::class);


//----------------------------------------------FACTURACIONES---------------------------------------------------//
Route::get('/facturas', Facturacion::class);

//-----------------------------------------------Usuarios--------------------------------------------//
Route::get('/usuarios', ListarUsuarios::class);
Route::get('/usuarios/listar/usuarios', [ListarUsuarios::class, 'listarUsuarios']);




//--------------------------------------------Inventario---------------------------------------------//

Route::get('/producto/registro', Producto::class);
Route::post('/producto/registrar', [Producto::class, 'crearProducto']);
Route::post('/producto/editar', [Producto::class, 'editarProducto']);
Route::post('/producto/eliminar', [Producto::class, 'eliminarImagen']);




Route::post('/ruta/imagen/edit', [Producto::class, 'guardarFoto']);
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
Route::post('/producto/compra/guardar', [CompraProducto::class, 'guardarCompra']);
Route::get('/producto/listar/compras', ListarCompras::class);
Route::get('/producto/compras/listar', [ListarCompras::class, 'listarCompras']);
Route::get('/producto/compras/detalle/{id}', DetalleCompra::class);
Route::get('/producto/compra/pagos/{id}', PagosCompra::class);
Route::post('/producto/compra/pagos/registro', [ PagosCompra::class, 'registrarPago']);
Route::get('/producto/compra/pagos/lista/{id}', [ PagosCompra::class, 'listarPagos']);
Route::post('/producto/compra/pagos/datos', [PagosCompra::class,'DatosCompra']);
Route::post('/producto/compra/pagos/eliminar', [PagosCompra::class,'eliminarPago']);
Route::post('/producto/compra/pagos/comprobar', [PagosCompra::class,'comprobarRetencion']);
Route::get('/producto/compra/recibir/{id}', RecibirProducto::class);
Route::get('/producto/compra/recibir/listar/{id}', [RecibirProducto::class, 'listarProductos']);
Route::get('/producto/recibir/bodega', [RecibirProducto::class, 'bodegasLista']);
Route::post('/producto/recibir/segmento', [RecibirProducto::class, 'listarSegmentos']);
Route::post('/producto/recibir/seccion', [RecibirProducto::class, 'listarSecciones']);
Route::post('/producto/recibir/guardar', [RecibirProducto::class, 'guardarEnBodega']);
Route::get('/producto/lista/bodega/{id}', [RecibirProducto::class, 'productoBodega']);
Route::post('/producto/recibir/datos',[RecibirProducto::class, 'datosGeneralesCompra']);
Route::post('/producto/recibir/excedente',[RecibirProducto::class, 'guardarEnBodegaExcedente']);
Route::post('/producto/incidencia/bodega',[RecibirProducto::class, 'incidenciaBodega']);
Route::post('/producto/incidencia/compra',[RecibirProducto::class, 'incidenciaCompra']);
Route::get('/inventario/compras/incidencias/{id}', Incidencias::class);
Route::get('/inventario/incidencia/bodega/{id}',[Incidencias::class, 'incidenciasBodega']);
Route::get('/inventario/incidencia/compra/{id}',[Incidencias::class, 'incidenciaCompra']);
Route::post('/producto/compra/anular',[AnularCompra::class, 'anularCompraRegistro']);
Route::get('/inventario/translado', Translados::class);
Route::get('/translado/lista/productos',[Translados::class, 'listarProductos']);
Route::get('/translado/lista/bodegas',[Translados::class, 'listarBodegas']);
Route::get('/translado/producto/lista/{idBodega}/{idProducto}',[Translados::class, 'productoBodega']);
Route::get('/translado/destino/lista/{idSeccion}/{idProducto}',[Translados::class, 'productoGeneralBodega']);
Route::post('/translado/producto/bodega',[Translados::class, 'ejectarTranslado']);
Route::post('/producto/compra/pagos/eliminar', [PagosCompra::class,'eliminarPago']); 
Route::post('/producto/compra/pagos/comprobar', [PagosCompra::class,'comprobarRetencion']); 
Route::get('/compra/retencion/documento', [PagosCompra::class,'retencionDocumentoPDF']);  
 









//------------------------------------------establecer links de storage---------------------------//
Route::get('/linkstorage', function () {
    Artisan::call('storage:link'); // this will do the command line job
});





