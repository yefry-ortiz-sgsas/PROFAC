<?php

namespace App\Http\Livewire\Inventario;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\ModelPagoCompra;
use App\Models\ModelCompra;
use App\Models\modelBodega; 
use App\Models\ModelRecibirBodega; 
use Auth;
use DataTables;

use Livewire\Component;

class RecibirProducto extends Component
{
    public $idCompra;
    public function mount($id)
    {

        $this->idCompra = $id;

    }

    public function render()
    {
        $idCompra = $this->idCompra;

        $datosCompra = DB::SELECTONE("
     select
        A.numero_factura,
        A.numero_orden,
        B.nombre
      from
      compra A
      inner join proveedores B
      on A.proveedores_id = B.id
      where A.id = ".$idCompra);



        return view('livewire.inventario.recibir-producto', compact('idCompra','datosCompra'));
    }

    public function listarProductos($id)
    {
        try {

            $listaCompra = DB::SELECT("

        select
            @i := @i + 1 as 'contador',      
            A.compra_id,            
            A.producto_id as 'producto_id',
            producto.nombre as nombre,            
            A.precio_unidad,
            A.cantidad_ingresada as cantidad_comprada,
            A.cantidad_sin_asignar,
            A.sub_total_producto,
            A.isv,
            A.precio_total,
            if(A.fecha_expiracion is null, 'No definido',A.fecha_expiracion) as fecha_expiracion,
            (select sum(cantidad_inicial_seccion) from recibido_bodega where producto_id = A.producto_id and compra_id = A.compra_id ) as 'cantidad_ingresada_bodega'
          
        from 
            compra_has_producto A
            inner join producto
            on producto.id = A.producto_id    
            cross join (select @i := 0) r
            where A.compra_id = ".$id."

 
        ");

            return Datatables::of($listaCompra)
                ->addColumn('opciones', function ($listaCompra) {

                    if($listaCompra->cantidad_sin_asignar > 0){
                       
                        return
                        '<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                                más</button>
                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                                <li>
                                    <a class="dropdown-item" onclick="mostratModal(' . $listaCompra->compra_id . ',' . $listaCompra->producto_id . ')" > <i class="fa-solid fa-circle-exclamation text-success"></i> Recibir producto </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" onclick="mostrarModalExcedente(' . $listaCompra->compra_id . ',' . $listaCompra->producto_id . ')"> <i class="fa-solid fa-circle-plus text-info"></i> Registrar Producto Excedente </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="mostrarModalIncidencias(' . $listaCompra->compra_id . ',' . $listaCompra->producto_id . ')" > <i class="fa-solid fa-circle-exclamation text-warning"></i> Registrar Incidencia </a>
                                </li>

    
                           
        
                            </ul>
                        </div>';

                    }else{
                        return
                        '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            

                            <li>
                                <a class="dropdown-item" onclick="mostrarModalExcedente(' . $listaCompra->compra_id . ',' . $listaCompra->producto_id . ')"> <i class="fa-solid fa-circle-plus text-info"></i> Registrar Producto Excedente </a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="mostrarModalIncidencias(' . $listaCompra->compra_id . ',' . $listaCompra->producto_id . ')" > <i class="fa-solid fa-circle-exclamation text-warning"></i> Registrar Incidencia </a>
                            </li>


                       
    
                        </ul>
                    </div>';
                    }


                })
                ->addColumn('estado_recibido', function ($listaCompra){
                    if($listaCompra->cantidad_comprada == $listaCompra->cantidad_ingresada_bodega){
                        return
                        '

                        <p class="text-center" ><span class="badge badge-primary p-2" style="font-size:0.95rem">Recibido</span></p>
                        ';

                    }else if($listaCompra->cantidad_ingresada_bodega < $listaCompra->cantidad_comprada  ){
                        return
                        '
                        <p class="text-center"><span class="badge badge-danger p-2" style="font-size:0.95rem">Incompleto</span></p>
                        ';
                    }else if($listaCompra->cantidad_ingresada_bodega > $listaCompra->cantidad_comprada){
                        return
                        '
                        <p class="text-center"><span class="badge badge-warning p-2" style="font-size:0.95rem">Excedente</span></p>
                        ';

                    }else if($listaCompra->cantidad_ingresada_bodega >= 0){
                        return
                        '
                        <p class="text-center"><span class="badge p-2" style="font-size:0.95rem">No recibido</span></p>
                        ';
                    }
                   
                })

                ->rawColumns(['opciones','estado_recibido'])
                ->make(true);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ],402);
        }
    }

    public function bodegasLista()
    {
        

        try {

            $listaBodegasRecibir = DB::SELECT("
            select 
            id,
                nombre 
            From 
                bodega
            ");

            //$listaBodegasRecibir = modelBodega::all();

            return response()->json([
                "listaBodegas" => $listaBodegasRecibir
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ], 402);
        }
    }

    public function listarSegmentos(Request $request)
    {
        try {

            $listaSegmentos = DB::select("
         select id, descripcion from segmento where bodega_id = " . $request->idBodega);



            return response()->json([
                "listaSegmentos" => $listaSegmentos
            ],200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ],402);
        }
    }

    public function listarSecciones(Request $request)
    {
        try {

            $listaSecciones = DB::select("
         select id, descripcion from seccion where segmento_id = " . $request->idSegmento);

            return response()->json([
                "listaSecciones" => $listaSecciones
            ],200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ],402);
        }
    }

    public function guardarEnBodega(Request $request){
        try {

            //dd($request->all());
            $datosCompra = DB::SELECTONE("
            select
            cantidad_ingresada,
            fecha_expiracion,
            cantidad_sin_asignar
            from compra_has_producto
            where compra_id = ".$request->idCompra."  and producto_id=".$request->idProducto
        );

        if($datosCompra->cantidad_sin_asignar <= 0){
            return response()->json([
                "text" => "El producto ya fue ingresado en su totalidad. No se puede realizar más registros de recepcion en bodega para este producto.",
                "icon" => "warning",
                "title"=>"Advertencia!"
            ],402);
        }

        $restaCantidad = $datosCompra->cantidad_sin_asignar - $request->cantidad;

        if($restaCantidad < 0){
            return response()->json([
                "text" => "Esta intentando ingresar una cantidad mayor de producto con respecto a la cantidad faltante de ingresar.",
                "icon" => "warning",
                "title"=>"Advertencia!"
            ], 402);
            
        }

        
        

            

        //     DB::table('compra_has_producto')
        //     ->where('compra_id','=', $request->idCompra)
        //     ->where('producto_id','=', $request->idProducto)
        //     ->update([
        //         'seccion_id' => $request->idSeccion,
        //         'estado_recibido' => 4,
        //         'recibido_por' => Auth::user()->id,
        //         'fecha_recibido' => now(),
        // ]);



        $recibir = new ModelRecibirBodega();
        $recibir->compra_id = $request->idCompra;
        $recibir->producto_id = $request->idProducto;
        $recibir->seccion_id = $request->seccion;
        $recibir->cantidad_compra_lote = $datosCompra->cantidad_ingresada;
        $recibir->cantidad_inicial_seccion = $request->cantidad;
        $recibir->cantidad_disponible = $request->cantidad;
        $recibir->fecha_recibido = now();
        $recibir->fecha_expiracion = $datosCompra->fecha_expiracion;
        $recibir->estado_recibido = 4;
        $recibir->recibido_por = Auth::user()->id;
        $recibir->save();

        


            DB::table('compra_has_producto')
            ->where('compra_id','=', $request->idCompra)
            ->where('producto_id','=', $request->idProducto)
            ->update([
                'cantidad_sin_asignar' => $restaCantidad,
                
        ]);

           

        return response()->json([
            "text" => "Producto registrado en bodega con éxito.",
            "icon" => "success",
            "title"=>"Exito!"
        ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ], 402);
        }

    }

    public function productoBodega($id){
       try {

            $listaBodega =     DB::SELECT("
            select
            
            B.id,
            B.nombre as 'producto',
            A.cantidad_compra_lote,
            departamento.nombre as 'departamento',
            municipio.nombre as 'municipio',
            bodega.direccion ,
            bodega.nombre as 'bodega',
            seccion.numeracion as 'seccion',
            A.cantidad_disponible,
            A.cantidad_inicial_seccion,
            name,
            A.created_at,
            A.id as 'idRecibido',
            A.compra_id,
            A.producto_id
        from recibido_bodega A
        inner join producto B
        on A.producto_id = B.id
        inner join seccion
        on A.seccion_id = seccion.id
        inner join segmento
        on seccion.segmento_id = segmento.id
        inner join bodega
        on segmento.bodega_id = bodega.id
        inner join municipio
        on bodega.municipio_id = municipio.id
        inner join departamento
        on municipio.departamento_id = departamento.id
        inner join users
        on A.recibido_por = users.id
        where A.compra_id =".$id
            );

        return Datatables::of($listaBodega)
        ->addColumn('opciones', function ($listaBodega) {

         
                return
                '<div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                        más</button>
                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                        <li>
                            <a class="dropdown-item" onclick="mostrarModalIncidencias('.$listaBodega->idRecibido.')" > <i class="fa-solid fa-circle-exclamation text-warning"></i> Registrar Incidencia </a>
                        </li>

                        <li>
                            <a class="dropdown-item" onclick="mostrarModalExcedente('.$listaBodega->compra_id.','.$listaBodega->producto_id.')"> <i class="fa-solid fa-circle-plus text-info"></i> Registrar Producto Excedente </a>
                        </li>
                   

                    </ul>
                </div>';

            


        })
        ->rawColumns(['opciones'])
        ->make(true);



       } catch (QueryException $e) {
       return response()->json([
           'message' => 'Ha ocurrido un error', 
           'error' => $e
       ], 402);
       }
    }

    public function datosGeneralesCompra(Request $request){
       try {

        $datosCompra = DB::SELECTONE("
        select
        cantidad_ingresada,
        fecha_expiracion,
        cantidad_sin_asignar
        from compra_has_producto
        where compra_id = ".$request->compraId."  and producto_id=".$request->productoId
     );



       return response()->json([
           'datosCompra' => $datosCompra,
       ],200);

       } catch (QueryException $e) {
       return response()->json([
           'message' => 'Ha ocurrido un error', 
           'error' => $e
       ],402);
       }
    }
}
