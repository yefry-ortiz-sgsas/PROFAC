<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use App\Models\usuario;

use DataTables;


class ComisionesComisionar extends Component
{
    public $idVenta;
    public function mount($id)
    {

        $this->idVenta = $id;
    }
    public function render()
    {
        $idFactura = $this->idVenta;


        return view('livewire.comisiones.comisiones-comisionar', compact('idFactura'));
        //return view('livewire.comisiones.comisiones-comisionar');
    }



    public function obtenerDesglose($idFactura){
        //dd($mes,$idVendedor);
            try {
                $productos = DB::SELECT("
                select
                A.id,
                A.numero_factura,
                C.id as idProducto,
                C.nombre as producto,
                C.precio_base,
                C.ultimo_costo_compra,
                E.nombre as unidad_venta,
                B.cantidad,
                B.precio_unidad,
                B.total,
                B.sub_total,
                B.isv,
                B.seccion_id,
                F.descripcion as seccion,
                H.nombre
                from factura A
                inner join venta_has_producto B
                on A.id = B.factura_id
                inner join producto C
                on B.producto_id = C.id
                inner join unidad_medida_venta D
                on B.unidad_medida_venta_id = D.id
                inner join unidad_medida E
                on D.unidad_medida_id = E.id
                inner join seccion F
                on B.seccion_id = F.id
                inner join segmento G
                on G.id = F.segmento_id
                inner join bodega H
                on G.bodega_id = H.id
                where A.id = ".$idFactura."
                group by A.id, A.numero_factura, C.id, C.nombre, C.precio_base, C.ultimo_costo_compra, E.nombre,  B.precio_unidad,B.cantidad, B.total, B.sub_total, B.isv, B.seccion_id, F.descripcion,  H.nombre

                ");
                //dd($listaFacturas);
                return Datatables::of($productos)->rawColumns()->make(true);

            } catch (QueryException $e) {
                return response()->json([
                    'message' => 'Ha ocurrido un error al listar el desglose de productos.',
                    'errorTh' => $e,
                ], 402);

            }
    }
}
