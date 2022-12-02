<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;


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



    public function obtenerDesglose($id){
        try {
            $listaProd = DB::SELECT("
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
            (B.precio_unidad - C.precio_base) as ganancia,
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
            where A.id = ".$id."
            group by A.id, A.numero_factura, C.id, C.nombre, C.precio_base, C.ultimo_costo_compra, E.nombre,  B.precio_unidad,B.cantidad, B.total, B.sub_total, B.isv, B.seccion_id, F.descripcion,  H.nombre

            ");

            $idVendedores = DB::table('users')
                                    ->where('rol_id', 2)
                                    ->pluck('id');

                foreach ($idVendedores as $value) {

                    $techoComision = new comision_techo;
                    $techoComision->monto_techo = $techo;
                    $techoComision->vendedor_id =$value;
                    $techoComision->meses_id = $mes;
                    $techoComision->userRegistro = Auth::user()->id;
                    $techoComision->estado_id = 1;
                    $techoComision->save();
                }
           // dd($listaVendedores);
            return Datatables::of($listaProd)
            ->addColumn('acciones', function ($listaProd) {
                    return

                    '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            <li>
                                <a class="dropdown-item" href="ir('.$listaProd->id.')" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Ver </a>
                            </li>

                        </ul>
                    </div>';
            })
            ->rawColumns(['acciones'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar los productos.',
                'errorTh' => $e,
            ], 402);

        }
    }
}
