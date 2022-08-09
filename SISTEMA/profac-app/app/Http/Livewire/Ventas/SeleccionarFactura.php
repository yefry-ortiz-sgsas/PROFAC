<?php

namespace App\Http\Livewire\Ventas;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use DataTables;
use App\Models\ModelFactura;

class SeleccionarFactura extends Component
{
    public function render()
    {

        return view('livewire.ventas.seleccionar-factura');
    }

    public function listadoFacturas(Request $request)
    {
        $facturas2 = [];
        $facturas = DB::SELECT("
        select 
        cai,
        (select  concat(nombre_cliente,' - ', total,' Lps') from factura where estado_factura_id=1 and estado_venta_id = 1  and cai=A.cai) as 'DC',
        (select  concat(nombre_cliente,' - ', total,' Lps') from factura where estado_factura_id=2 and estado_venta_id = 1 and cai=A.cai) as 'ND'

        from factura A
        where  estado_venta_id =1  and estado_editar =1
        group by cai, DC, ND
      
        ");

        foreach ($facturas as $item) {

            if (!is_null($item->DC) and !is_null($item->ND)) {
                array_push($facturas2, ['cai' => $item->cai, 'DC' => $item->DC, 'ND' => $item->ND]);
            }
        }


        return Datatables::of($facturas2)
            ->addColumn('opciones', function ($elemento) {
                $tilde = "'";
                return

                    '<div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                    más</button>
                <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                    <li>
                        <a class="dropdown-item" onclick="modalTranslado(' . $tilde . $elemento['cai'] . $tilde . ')" > <i class="fa-solid fa-arrows-rotate text-warning"></i> Intercambiar Estado </a>
                    </li>
                   

                    
                </ul>
            </div>';
            })

            ->rawColumns(['opciones'])
            ->make(true);
    }

    public function cambioEstado(Request $request)
    {
        try {

            $comprobar = DB::SELECT("
            select 
            id
            from factura
            inner join cliente
            on cliente.id = factura.cliente_id
            inner join tipo_cliente
            on cliente.tipo_cliente_id = tipo_cliente.id
            where  estado_editar =1 and  factura.tipo_venta_id=2 and factura.cai = '" . $request->cai . "' 
            ");

            if (!empty($comprobar)) {
                return response()->json([
                    "text" => "Acción no permitida.",
                    "title" => "Advertencia!.",
                    "icon" => "warning",


                ], 200);
            }

            $facturas = DB::select("select id, estado_factura_id as estado from factura where estado_venta_id = 1 and cai = '" . $request->cai . "'");

            foreach ($facturas  as $item) {
                if ($item->estado == 1) {
                    $factura = ModelFactura::find($item->id);
                    $factura->estado_factura_id = 2;
                    $factura->save();
                } else {
                    $factura = ModelFactura::find($item->id);
                    $factura->estado_factura_id = 1;
                    $factura->save();
                }
            }



            return response()->json([
                "text" => "Editado con exito.",
                "title" => "Exito.",
                "icon" => "success",
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                "text" => "Ha ocurrido un error.",
                "title" => "Error.",
                "icon" => "error",
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ], 402);
        }
    }

    public function guardarEstado(Request $request)
    {
        try {
            $arreglo = $request->arregloCAI;

            $consultaUpdate = "";

            for ($i = 0; $i < count($arreglo); $i++) {
                $consultaUpdate = "UPDATE factura SET estado_editar=2 WHERE estado_editar = 1 and estado_venta_id = 1 and cai = '" . $arreglo[$i] . "';";
                DB::UPDATE($consultaUpdate);
            }

            //dd($consultaUpdate);

            //ModelFactura::UPDATED($consultaUpdate);




            return response()->json([
                'icon' => 'success',
                'text' => 'Exito!',
                'title' => 'Cambios guardados con éxito.',
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Ha ocurrido un error, los cambios no fueron guardados',
                'message' => 'Ha ocurrido un error',
                'error' => $e,
            ], 402);
        }
    }

    public function seleccionarMontoMayor(Request $request)
    {
        try 
        {

            $cai = $request->arregloCAI;

           

            for ($i = 0; $i < COUNT($cai); $i++) 
            {

                $contador = DB::SELECTONE(
                    "
                        select 
                        id
                        from factura 
                        where estado_venta_id = 1 and tipo_venta_id=2 and cai='" . $cai[$i] . "'"
                );

                if (!empty($contador->id)) {
                    continue;
                }

                $total1 = DB::SELECTONE("select id,total,estado_factura_id from factura where estado_venta_id = 1 and estado_factura_id = 1 and cai='" . $cai[$i] . "'");

                $total2 = DB::SELECTONE("select id,total,estado_factura_id from factura where estado_venta_id = 1 and estado_factura_id = 2 and cai='" . $cai[$i] . "'");

                if ($total1->total > $total2->total) {

                 

                        DB::update("update factura set estado_factura_id = 1 where id =" . $total1->id);
                        DB::update("update factura set estado_factura_id = 2 where id =" . $total2->id);

                } else {

                   
                        DB::update("update factura set estado_factura_id = 1 where id =" . $total2->id);
                        DB::update("update factura set estado_factura_id = 2 where id =" . $total1->id);
                }


            }


            return response()->json([
                'icon' => 'success',
                'text' => 'Exito!',
                'title' => 'Cambios realizados con éxito.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Ha ocurrido un error, los cambios no fueron guardados',
                'message' => 'Ha ocurrido un error',
                'error' => $e,
            ], 402);
        }
    }

    public function seleccionarMontoMEnor(Request $request)
    {
        try 
        {

            $cai = $request->arregloCAI;

           

            for ($i = 0; $i < COUNT($cai); $i++) 
            {

                $contador = DB::SELECTONE(
                    "
                        select 
                        id
                        from factura 
                        where estado_venta_id = 1 and tipo_venta_id=2 and cai='" . $cai[$i] . "'"
                );

                if (!empty($contador->id)) {
                    continue;
                }

                $total1 = DB::SELECTONE("select id,total,estado_factura_id from factura where estado_venta_id = 1 and estado_factura_id = 1 and cai='" . $cai[$i] . "'");

                $total2 = DB::SELECTONE("select id,total,estado_factura_id from factura where estado_venta_id = 1 and estado_factura_id = 2 and cai='" . $cai[$i] . "'");

                if ($total1->total < $total2->total) {

                 

                        DB::update("update factura set estado_factura_id = 1 where id =" . $total1->id);
                        DB::update("update factura set estado_factura_id = 2 where id =" . $total2->id);

                } else {

                   
                        DB::update("update factura set estado_factura_id = 1 where id =" . $total2->id);
                        DB::update("update factura set estado_factura_id = 2 where id =" . $total1->id);
                }


            }


            return response()->json([
                'icon' => 'success',
                'text' => 'Exito!',
                'title' => 'Cambios realizados con éxito.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Ha ocurrido un error, los cambios no fueron guardados',
                'message' => 'Ha ocurrido un error',
                'error' => $e,
            ], 402);
        }
    }

 

    
}
