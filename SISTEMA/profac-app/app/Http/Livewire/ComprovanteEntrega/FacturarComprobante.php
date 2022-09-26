<?php

namespace App\Http\Livewire\ComprovanteEntrega;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Validator;
use PDF;
use Luecano\NumeroALetras\NumeroALetras;

class FacturarComprobante extends Component
{

    public $idComprobante;

    public function mount($id)
    {

        $this->idComprobante = $id;
    }

    public function render()
    {
        $idComprobante = $this->idComprobante;
        $char = '"';
        $char2 = "'";
        return view('livewire.comprovante-entrega.facturar-comprobante', compact('idComprobante'));
    }

    public function generarHTML(Request $request){
       try {
       
        $productos = DB::SELECT("
        select 
        B.comprovante_id,
        concat(B.producto_id,' - ', C.nombre ) as producto,
        B.producto_id,
        concat(bodega.nombre,' - ',seccion.descripcion ) as nombre_bodega,
        bodega.id as idBodega,
        B.seccion_id as idSeccion,
        B.precio_unidad,
        concat(E.nombre,' - ',D.unidad_venta  ) as unidad,
        B.cantidad,
        B.unidad_medida_venta_id,
        sum(B.sub_total_s) as sub_total,
        sum(B.isv_s) as isv,
        sum(B.total_s) as total
        
        
        from comprovante_entrega A
        inner join comprovante_has_producto B
        on A.id = B.comprovante_id
        inner join producto C
        on B.producto_id = C.id
        inner join seccion 
        on seccion.id = B.seccion_id
        inner join segmento
        on seccion.segmento_id = segmento.id
        inner join bodega 
        on bodega.id = segmento.bodega_id
        inner join unidad_medida_venta D
        on D.id = B.unidad_medida_venta_id
        inner join unidad_medida E
        on E.id = D.unidad_medida_id
        where A.id = ".$request->idComprobante."
        group by comprovante_id, producto, producto_id, nombre_bodega, idBodega, idSeccion, cantidad, unidad_medida_venta_id, precio_unidad
        ");

        return $productos;

       } catch (QueryException $e) {
       return response()->json([
        'icon' => 'error',
        'text' => 'Ha ocurrido un error al obtener los productos de la orden de entrega',
        'title' => 'Error!',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
    }
}
