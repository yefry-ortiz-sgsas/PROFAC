<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;

class ComisionesGestiones extends Component
{
    public function render()
    {
        return view('livewire.comisiones.comisiones-gestiones');
    }

    public function obtenerFacturas($mes,$idVendedor){
        //dd($mes,$idVendedor);
            try {
                $listaFacturas = DB::SELECT("
                    select
                        factura.id as 'id',
                        factura.numero_factura as 'numero_factura',
                        factura.fecha_emision as 'fecha_emision',
                        factura.fecha_vencimiento as 'fecha_vencimiento',
                        cliente.nombre as 'nombre',
                        factura.total as 'total'
                    from factura
                        inner join cliente
                        on factura.cliente_id = cliente.id
                        inner join tipo_pago_venta
                        on factura.tipo_pago_id = tipo_pago_venta.id
                        inner join users
                        on factura.vendedor = users.id
                        cross join (select @i := 0) r
                    where ( YEAR(factura.created_at) >= (YEAR(NOW())-2) )
                    and (DATE_FORMAT(factura.created_at,'%m') = ".$mes.")
                    and factura.pendiente_cobro = 0
                    and factura.estado_venta_id<>2
                    and (factura.tipo_venta_id = 1)
                    and factura.vendedor = ".$idVendedor."
                    order by factura.created_at desc;
                ");
                //dd($listaFacturas);
                return Datatables::of($listaFacturas)
                ->addColumn('estadoPago', function ($listaFacturas) {
                    return

                    '<span class="badge badge-success">CERRADA</span>';
                })
                ->addColumn('acciones', function ($listaFacturas) {
                        return

                        '<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                                más</button>
                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                                <li>
                                    <a class="dropdown-item" href="/detalle/venta/'.$listaFacturas->id.'" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Detalle de Factura </a>
                                </li>

                            </ul>
                        </div>';
                })
                ->rawColumns(['estadoPago','acciones'])
                ->make(true);

            } catch (QueryException $e) {
                return response()->json([
                    'message' => 'Ha ocurrido un error al listar las facturas.',
                    'errorTh' => $e,
                ], 402);

            }
    }
}
