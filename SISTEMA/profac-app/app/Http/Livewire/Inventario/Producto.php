<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;


use App\Models\ModelUnidadMedida;
use App\Models\ModelCategoriaProducto;
use App\Models\ModelProducto;
use App\Models\ModelPrecio;
use App\Models\ModelImagenProducto;
use App\Models\ModelUnidadMedidaVenta;
use App\Models\ModelMarca;


use DataTables;
use Illuminate\Support\Facades\File;

class Producto extends Component
{
    public function render()
    {
        $categorias = ModelCategoriaProducto::all();
        $unidades = DB::SELECT("select id,nombre,simbolo from unidad_medida order by nombre asc");
       $marcas = DB::SELECT("select id,nombre from marca order by nombre asc"); 
        return view('livewire.inventario.producto',  compact("categorias", "unidades","marcas"));
    }

    public function crearProducto(Request $request)
    {
          //dd($request->all());
        $validator = Validator::make($request->all(), [
            'nombre_producto' => 'required',
            'descripcion_producto' => 'required',
            'isv_producto' => 'required',
           
            'categoria_producto' => 'required',
            'unidad_producto' => 'required',
            

        ], [
            'nombre_producto' => 'Nombre es requerido',
            'descripcion_producto' => 'Descripcion es requerido',
            'isv_producto' => 'ISV es requqerido',
            
            'categoria_producto' => 'Categoria del producto es requerido',
            'unidad_producto' => 'La unidad de medida es requerida',
            'img_pago' => 'Formato de imagen invalido'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error.',
                'errors' => $validator->errors()
            ], 402);
        }




        try {

            DB::beginTransaction();
            $url = "";

            $producto = new ModelProducto;
            $producto->nombre = trim($request['nombre_producto']);
            $producto->descripcion = trim($request['descripcion_producto']);
            $producto->isv = $request['isv_producto']; 
            $producto->codigo_barra = trim($request['cod_barra_producto']);
            $producto->costo_promedio = trim($request['costo_promedio']);
            $producto->codigo_estatal = trim($request['cod_estatal_producto']);
            $producto->categoria_id = $request['categoria_producto'];
            $producto->precio_base = trim($request['precioBase']); 
            $producto->marca_id = $request->marca_producto;           
            $producto->users_id = Auth::user()->id;
            $producto->estado_producto_id = 1; 
            $producto->unidad_medida_compra_id = $request->unidad_producto;
            $producto->unidadad_compra = $request->unidades;
            $producto->save();

            //------------------------guardar precios------------//
            // $arrayPrecios = $request['precio'];

           

            
            //     for ($i = 0; $i < count($arrayPrecios); $i++) {
            //         if($arrayPrecios[$i] == null){
            //             continue;
            //         }
            //         $precio = new ModelPrecio;
            //         $precio->precio = trim($arrayPrecios[$i]);
            //         $precio->producto_id = $producto->id;
            //         $precio->users_id = Auth::user()->id;
            //         $precio->save();
            //     }

            //---------------------------guardar unidades de medida para venta de producto-------
            
            $unidadVenta = new ModelUnidadMedidaVenta;
            $unidadVenta->unidad_venta = $request->unidades_venta;
            $unidadVenta->unidad_medida_id = $request->unidad_producto_venta;
            $unidadVenta->producto_id = $producto->id;
            $unidadVenta->estado_id = 1;
            $unidadVenta->unidad_venta_defecto = 1;
            $unidadVenta->save();


            if($request->unidad_producto != $request->unidad_producto_venta){

                $unidadVenta2 = new ModelUnidadMedidaVenta;
                $unidadVenta2->unidad_venta = $request->unidades;
                $unidadVenta2->unidad_medida_id = $request->unidad_producto;
                $unidadVenta2->producto_id = $producto->id;
                $unidadVenta2->estado_id = 1;
                $unidadVenta2->unidad_venta_defecto = 0;               
                $unidadVenta2->save();

            }
   


            




            //----------------------------------guardar imagen-------------------------//


             if ($request->file('files') <> null) {

                $URLs = [];
                $archivos = $request->file('files');
                $i = 1;

                foreach ($archivos as $file) {
                      
                        $name = 'IMG_'. time()."-".$i. '.' . $file->getClientOriginalExtension();
                        $path = public_path() . '/catalogo';
                        $url =  $name;
                        array_push($URLs, ['producto_id' => $producto->id, 'url_img' =>  $url, 'users_id' =>  Auth::user()->id, 'created_at' => now()]);
                        $file->move($path, $name);
                        $i++;
                }
                //  $flight = URLfile::create($URLs);

                DB::table('img_producto')->insert($URLs);
            }


            DB::commit();
            return response()->json([
                "message" => "producto guardato con exito",
            ], 200);
        } catch (QueryException $e) {
            DB::rollback();
              
            // $carpetaPublic = public_path();
            // $path = $carpetaPublic.'/catalogo/'.$name;
            
            // File::delete($path);

            return response()->json([
                'message' => 'Ha ocurrido un error al crear el producto.',
                'errorTh' => $e,
            ], 402);
        }
    }


    public function listarProductos()
    {
        try {
            $listaProductos = DB::SELECT("

            select
            A.id as 'codigo',
            A.nombre,
            A.descripcion,
            A.isv as 'ISV',
            B.descripcion as 'categoria',
            C.nombre as 'unidad_medida',
            
            IFNULL ((select
            sum(cantidad_disponible) 
            from recibido_bodega 
            inner join compra
            on recibido_bodega.compra_id = compra.id
            where compra.estado_compra_id=1 and  producto_id = A.id), 0)  as 'existencia'


            from producto A
            inner join categoria_producto B
            on A.categoria_id = B.id
            inner join unidad_medida C
            on A.unidad_medida_compra_id = C.id
            order by A.created_at DESC
                        ");

            return Datatables::of($listaProductos)
                ->addColumn('disponibilidad', function ($listaProductos) {

                    return

                        '
                <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                    más</button>
                <ul class="dropdown-menu" x-placement="bottom-start"
                    style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                    <li><a class="dropdown-item" href="/producto/detalle/' . $listaProductos->codigo . '" target="_blank"  > <i class="fa-solid fa-arrows-to-eye text-info"></i>
                            Ver detalles </a></li>

                </ul>
            </div>
                ';
                })

                ->rawColumns(['disponibilidad'])
                ->make(true);
        } catch (QueryException $e) {


            return response()->json([
                'message' => 'Ha ocurrido un error al listar los productos.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function guardarFoto(Request $request){

        //dd($request->all());
        $url = '';
        try{
                if ($request->file('files') <> null) {

                    $URLs = [];
                    $archivos = $request->file('files');
                    $i = 0;

                    foreach ($archivos as $file) {

                            $name = 'IMG_'. time()."-".$i. '.' . $file->getClientOriginalExtension();
                            $path = public_path() . '/catalogo';
                            $url =  $name;
                            array_push($URLs, ['producto_id' => $request->id_producto_edit_foto, 'url_img' =>  $url, 'users_id' =>  Auth::user()->id, 'created_at' => now()]);
                            $file->move($path, $name);
                            $i++;
                    }
                    //  $flight = URLfile::create($URLs);

                    DB::table('img_producto')->insert($URLs);
                }


                DB::commit();
                return response()->json([
                    "message" => "producto guardato con exito",
                ], 200);
            } catch (QueryException $e) {
                DB::rollback();

                return response()->json([
                    'message' => 'Ha ocurrido un error al crear el producto.',
                    'errorTh' => $e,
                ], 402);
            }
    }

    public function listarModalProductoEdit($id){

        try {

            $datosProducto = DB::SELECT("
            select
                id,
                nombre,
                descripcion,
                isv,
                precio_base,
                codigo_barra,
                codigo_estatal,
                categoria_id,
                unidad_medida_compra_id,
                users_id,
                costo_promedio,
                marca_id,
                unidad_medida_compra_id,
                unidadad_compra
                

            from producto where id =".$id);

            $preciosProducto = DB::SELECT("

            select
                id,
                precio,
                producto_id,
                users_id
            from precios_venta
            where producto_id = ".$id

            );

            $categorias = ModelCategoriaProducto::all();
            $unidades = DB::SELECT("select id,nombre from unidad_medida order by nombre asc");
            $marcas =  DB::SELECT("select id,nombre from marca order by nombre asc");

            return response()->json([
            "datosProducto"=> $datosProducto[0],
            "preciosProducto" => $preciosProducto,
            "categorias"=>$categorias,
            "unidades" => $unidades,
            "marcas" => $marcas

            ],200);

        } catch (QueryException $e) {

            return response()->json([
                "message" => "Ha ocurrido un error al traer datos de producto.",
                "error" => $e
            ],402);

        }
    }

    public function editarProducto(Request $request){
        try {
       

            $producto = ModelProducto::find($request['id_producto_edit']);
            $producto->nombre = trim($request['nombre_producto_edit']);
            $producto->descripcion = trim($request['descripcion_producto_edit']);
            $producto->isv = trim($request['isv_producto_edit']);
            $producto->codigo_barra = trim($request['cod_barra_producto_edit']);
            $producto->codigo_estatal = trim($request['cod_estatal_producto_edit']);
            $producto->categoria_id = $request['categoria_producto_edit'];
            $producto->precio_base = trim($request['precioBase_edit']);
            $producto->costo_promedio = $request['costo_promedio_editar'];
            $producto->unidadad_compra = trim($request['unidades_editar']);
            $producto->unidad_medida_compra_id = $request['unidad_producto_editar'];
            $producto->marca_id= $request->marca_producto_editar;
            $producto->users_id = Auth::user()->id;
            $producto->save();

       
            return response()->json([
                "message" => "producto editado con exito",
            ], 200);
        } catch (QueryException $e) {
               

                return response()->json([
                    'message' => 'Ha ocurrido un error al editar el producto.',
                    'errorTh' => $e,
                ], 402);
        }
    }

    public function eliminarImagen(Request $request){



                //dd($request->urlImagen);
                try{
                    $user = ModelImagenProducto::where('url_img','=',$request->urlImagen);
                    $user->delete();

                    $carpetaPublic = public_path();
                    $path = $carpetaPublic.'/catalogo/'.$request->urlImagen;

                    File::delete($path);

                return 'exito';
                } catch (QueryException $e) {
                    return response()->json([
                        'message' => 'Ha ocurrido un error al eliminar la imagen.',
                        'errorTh' => $e,
                    ], 402);
                }
    }


}
