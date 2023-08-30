<?php

namespace App\Http\Livewire\Reportes;

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

use App\Models\ModelFactura;
use App\Models\ModelCAI;
use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;
use App\Models\ModelParametro;
use App\Models\ModelLista;
use App\Models\ModelCliente;
use App\Models\logCredito;
use App\Models\User;

class Prodmes extends Component
{
    public function render()
    {
        return view('livewire.reportes.prodmes');
    }

    public function consultaComision($fecha_inicio, $fecha_final){
        try {



            $consulta = DB::SELECT("

                select
                date_format(A.created_at, '%d-%m-%Y') as 'FECHA',
                date_format(A.fecha_vencimiento, '%d-%m-%Y') as 'FECHA VENCIMIENTO',
                UPPER(tpv.descripcion) as 'CRÉDITO/CONTADO',
                (
                    CASE A.estado_factura_id WHEN '1' THEN 'CLIENTE A' WHEN '2' THEN 'CLIENTE B' END
                ) AS 'TIPO CLIENTE (AoB)',
                UPPER(us.name) as 'VENDEDOR',
                (
                    RIGHT(A.cai, 5)
                ) as 'FACTURA',
                cli.nombre as 'CLIENTE',
                C.id as 'CÓDIGO',
                C.nombre as 'PRODUCTO',
                B.precio_unidad as 'PRECIO PRODUCTO',
                B.numero_unidades_resta_inventario as 'CANTIDAD',
                FORMAT(B.sub_total_s, 2) as 'SUB TOTAL PRODUCTO',
                FORMAT(B.isv_s, 2) as 'ISV',
                B.total_s as 'TOTAL PRODUCTO',
                FORMAT(
                    (A.total / 1.15),
                    2
                ) as 'SUB TOTAL FACTURA',
                FORMAT(A.total, 2) as 'TOTAL FACTURA',
                FORMAT(
                    (
                    (A.total / 1.15)- B.sub_total_s
                    ),
                    2
                ) as 'SUB TOTAL DIFERENCIA',
                (
                    CASE tpv.descripcion WHEN 'CREDITO' THEN 'N/A' WHEN 'CONTADO' THEN FORMAT(
                    (B.sub_total_s * 0.0175),
                    2
                    ) END
                ) AS 'CONTADO 1.75%',
                (
                    CASE tpv.descripcion WHEN 'CREDITO' THEN FORMAT(
                    (B.sub_total_s * 0.0150),
                    2
                    ) WHEN 'CONTADO' THEN 'N/A' END
                ) AS 'CREDITO 1.5%',
                (
                    IF(
                    (
                        select
                        count(*)
                        from
                        venta_has_producto
                        where
                        factura_id = A.id
                        and producto_id not in (
                            1006, 1035, 1940, 1942, 1943, 1944, 1945,
                            1946, 1947, 1948, 1949, 1950, 1951,
                            1952, 1953, 1954, 1955, 1956, 1957,
                            1958, 1959, 1960, 1961, 1962, 1963,
                            1964, 1965, 2029, 2030, 2223, 2244,
                            2300, 2301, 2396, 2397, 2404, 2474,
                            2527, 2547, 2699, 2723, 2884, 2901
                        )
                    ) = 0,
                    'N/A',
                    FORMAT(
                        (
                        (A.total - B.sub_total_s)* 0.02
                        ),
                        2
                    )
                    )
                ) AS 'COMISION OTROS PRUEBA'
                from
                factura A
                inner join venta_has_producto B on A.id = B.factura_id
                inner join producto C on B.producto_id = C.id
                inner join unidad_medida_venta D on B.unidad_medida_venta_id = D.id
                inner join unidad_medida E on E.id = D.unidad_medida_id
                inner join sub_categoria sc on sc.id = C.sub_categoria_id
                inner join categoria_producto cp on cp.id = sc.categoria_producto_id
                inner join cliente cli on cli.id = A.cliente_id
                inner join tipo_pago_venta tpv on tpv.id = A.tipo_pago_id
                inner join users us on us.id = A.vendedor
                where
                A.estado_venta_id = 1
                and C.id in (
                    1006, 1035, 1940, 1942, 1943, 1944, 1945,
                    1946, 1947, 1948, 1949, 1950, 1951,
                    1952, 1953, 1954, 1955, 1956, 1957,
                    1958, 1959, 1960, 1961, 1962, 1963,
                    1964, 1965, 2029, 2030, 2223, 2244,
                    2300, 2301, 2396, 2397, 2404, 2474,
                    2527, 2547, 2699, 2723, 2884, 2901
                )
                and DATE(A.created_at) >= DATE_FORMAT('".$fecha_inicio."', '%Y-%m-%d')
                and DATE(A.created_at) <= DATE_FORMAT('".$fecha_final."', '%Y-%m-%d')
                order by
                A.created_at DESC
            ");





            return Datatables::of($consulta)
            ->rawColumns([])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar el reporte solicitado.',
                'errorTh' => $e,
            ], 402);

        }

    }
}
