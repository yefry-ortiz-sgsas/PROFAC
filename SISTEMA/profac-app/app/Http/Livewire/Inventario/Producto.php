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
use DataTables;
use Illuminate\Support\Facades\File;

class Producto extends Component
{
    public function render()
    {
        $categorias = ModelCategoriaProducto::all();
        $unidades = ModelUnidadMedida::all();

        return view('livewire.inventario.producto',  compact("categorias", "unidades"));
    }

    public function crearProducto(Request $request)
    {
          //dd($request->all());
        $validator = Validator::make($request->all(), [
            'nombre_producto' => 'required',
            'descripcion_producto' => 'required',
            'isv_producto' => 'required',
            'precio' => 'required',
            'categoria_producto' => 'required',
            'unidad_producto' => 'required',

        ], [
            'nombre_producto' => 'Nombre es requerido',
            'descripcion_producto' => 'Descripcion es requerido',
            'isv_producto' => 'ISV es requqerido',
            'precio' => 'Precio 1 es requerido',
            'categoria_producto' => 'Categoria del producto es requerido',
            'unidad_producto' => 'La unidad de medida es requerida',
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
            $producto->nombre = $request['nombre_producto'];
            $producto->descripcion = $request['descripcion_producto'];
            $producto->isv = $request['isv_producto'];
            $producto->codigo_barra = $request['cod_barra_producto'];
            $producto->codigo_estatal = $request['cod_estatal_producto'];
            $producto->categoria_id = $request['categoria_producto'];
            $producto->precio_base = $request['precioBase'];
            $producto->unidad_medida_id = $request['unidad_producto'];
            $producto->users_id = Auth::user()->id;
            $producto->save();

            //------------------------guardar precios------------//
            $arrayPrecios = $request['precio'];

            for ($i = 0; $i < count($arrayPrecios); $i++) {
                $precio = new ModelPrecio;
                $precio->precio = $arrayPrecios[$i];
                $precio->producto_id = $producto->id;
                $precio->users_id = Auth::user()->id;
                $precio->save();
            }


            //----------------------------------guardar imagen-------------------------//
            // if ($request->file('foto_producto') <> null) {
            //     $file = $request->file('foto_producto');
            //     $name = 'IMG_' . time() . '.' . $file->getClientOriginalExtension();
            //     $extencion = $file->getClientOriginalExtension();
            //     $path = public_path() . '/catalogo';
            //     $url = $name;

            //     $imagen = new ModelImagenProducto;
            //     $imagen->producto_id =  $producto->id;
            //     $imagen->url_img = $url;
            //     $imagen->users_id = Auth::user()->id;
            //     $imagen->save();



            //     $file->move($path, $name);
            // }//

             if ($request->file('files') <> null) {

                $URLs = [];
                $archivos = $request->file('files');
                $i = 0;

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
            IFNULL ((select sum(cantidad_disponible) from compra_has_producto where producto_id = A.id group by producto_id), 0)  as 'existencia'


            from producto A
            inner join categoria_producto B
            on A.categoria_id = B.id
            inner join unidad_medida C
            on A.unidad_medida_id = C.id
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
                unidad_medida_id,
                users_id
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

            return response()->json([
            "datosProducto"=> $datosProducto[0],
            "preciosProducto" => $preciosProducto
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
        DB::beginTransaction();

            $producto = ModelProducto::find($request['id_producto_edit']);
            $producto->nombre = $request['nombre_producto_edit'];
            $producto->descripcion = $request['descripcion_producto_edit'];
            $producto->isv = $request['isv_producto_edit'];
            $producto->codigo_barra = $request['cod_barra_producto_edit'];
            $producto->codigo_estatal = $request['cod_estatal_producto_edit'];
            $producto->categoria_id = $request['categoria_producto_edit'];
            $producto->precio_base = $request['precioBase_edit'];
            $producto->unidad_medida_id = $request['unidad_producto_edit'];
            $producto->users_id = Auth::user()->id;
            $producto->save();

        DB::commit();
            return response()->json([
                "message" => "producto editado con exito",
            ], 200);
        } catch (QueryException $e) {
                DB::rollback();

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
