<?php

namespace App\Http\Livewire\FacturaDia;

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

class FacturaDia extends Component
{
    public function render()
    {
        return view('livewire.factura-dia.factura-dia');
    }

    public function consulta($fecha_inicio, $fecha_final){
        try {



            $consulta = DB::SELECT("
            select
            A.created_at as 'fecha',
            (CASE DATE_FORMAT(A.created_at, '%m') WHEN '01' THEN 'ENERO' WHEN '02' THEN 'FEBRERO' WHEN '03' THEN 'MARZO' WHEN '04' THEN 'ABRIL' WHEN '05' THEN 'MAYO' WHEN '06' THEN 'JUNIO' WHEN '07' THEN 'JULIO' WHEN '08' THEN 'AGOSTO' WHEN '09' THEN 'SEPTIEMBRE' WHEN '10' THEN 'OCTUBRE' WHEN '11' THEN 'NOVIEMBRE' WHEN '12' THEN 'DICIEMBRE' END) AS 'mes',
            A.cai as 'factura',
            A.nombre_cliente as 'cliente',
            (select name from users where id = A.vendedor) as 'vendedor',
            format(A.sub_total,2) as 'subtotal',
            format(A.isv,2) as 'imp_venta',
            format(A.total,2) as 'total',
            CASE A.estado_factura_id WHEN 1 THEN 'GOBIERNO' WHEN 2 THEN 'CORPORATIVO' END AS 'tipo'


            from factura A
            inner join estado_venta B
            on A.estado_venta_id = B.id
            inner join tipo_pago_venta C
            on A.tipo_pago_id = C.id
            where B.id = 1 and
            DATE(A.created_at) >= DATE_FORMAT('".$fecha_inicio."', '%Y-%m-%d') and  DATE(A.created_at) <= DATE_FORMAT('".$fecha_final."', '%Y-%m-%d');
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
