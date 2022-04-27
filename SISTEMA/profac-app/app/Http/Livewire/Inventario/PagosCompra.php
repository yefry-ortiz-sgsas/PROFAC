<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\ModelPagoCompra;
use App\Models\ModelCompra;
use Auth;
use DataTables;

class PagosCompra extends Component
{
    public $idCompra;
    public function mount($id)
    {

        $this->idCompra = $id;
    }

    public function render()
    {
        $id = $this->idCompra;

        //dd($id);



        $datosCompra = DB::SELECTONE("
        select 
        numero_factura, 
        numero_orden as 'numero_compra' ,
        proveedores.nombre
        from compra 
        inner join proveedores
        on compra.proveedores_id = proveedores.id
        where compra.id = ".$id
        );
 
        return view('livewire.inventario.pagos-compra',compact('id','datosCompra'));
    }

    public function registrarPago(Request $request){
        try {

           

            $totalCompra = DB::SELECTONE("select total from compra where id=".$request->compraId);
            $totalPagos = DB::SELECTONE("select sum(monto) as monto from pago_compra where pago_compra.estado_id = 1 and compra_id = ".$request->compraId);

            $faltantePago = round($totalCompra->total,2) - round($totalPagos->monto,2);

            if($faltantePago <= 0){
                return response()->json([
                    "icon" => "warning",
                    "text"=>"El total de la compra ya ha sido cancelado. no puede realizar mas abonos a la deuda.",
                    "title"=>"Advertencia!"
                    
                ],200);

            }

            DB::beginTransaction();


            $registroPago = new ModelPagoCompra;
            $registroPago->monto = $request->monto;
            $registroPago->fecha = $request->fecha_pago;
            $registroPago->users_id = Auth::user()->id;
            $registroPago->estado_id =1;
            $registroPago->compra_id = $request->compraId;
            $registroPago->save();

            $totalCompra = DB::SELECTONE("select total from compra where id=".$request->compraId);
            $totalPagos = DB::SELECTONE("select sum(monto) as monto from pago_compra where pago_compra.estado_id = 1 and compra_id = ".$request->compraId);

            $faltantePago = round($totalCompra->total,2) - round($totalPagos->monto,2);

            $compra = ModelCompra::find($request->compraId);
            $compra->debito = round($faltantePago,2);
            $compra->save();

            

            

            DB::commit();
            return response()->json([
                "icon" => "success",
                "text" => "Registro de pago realizo con exito!",
                "title"=>"Exito!"

                
            ],200);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                "message" => "Ha ocurrido un error",
                "error" => $e
            ],402);
        }
    }

    public function DatosCompra(Request $request){
       try {

        $compra = DB::SELECTONE("select total, debito, if(monto_retencion is null ,0,monto_retencion) as 'monto_retencion' from compra where id=".$request->idCompra);
        
       return response()->json([
           "compra"=>$compra,
           
       ]);

       } catch (QueryException $e) {
       return response()->json([
           'message' => 'Ha ocurrido un error', 
           'error' => $e
       ]);
       }
    }

    public function listarPagos($id){
        

       try {

        $listaPagos = DB::SELECT("
        select
            @i := @i + 1 as contador,
            pago_compra.id,
            format(pago_compra.monto,2) as monto,
            pago_compra.fecha,
            users.name,
            pago_compra.created_at,
            compra.numero_factura,
            compra.numero_orden,
            compra.id as 'idCompra'        
        FROM compra
        inner join pago_compra
        on pago_compra.compra_id = compra.id
        inner join users
        on pago_compra.users_id = users.id
        CROSS JOIN (select @i := 0) compra
        where pago_compra.estado_id = 1 and compra.id = ".$id
       );

        return Datatables::of($listaPagos)
        ->addColumn('opciones', function ($listaPagos) {

            return
            '
            <div class="text-center">
                <button class="btn btn-danger " onclick="confirmarEliminarPago('.$listaPagos->id.')"><i class="fa-solid fa-trash-can "></i></button>
            </div>
          



        ';
        })

        ->rawColumns(['opciones'])
        ->make(true);

       } catch (QueryException $e) {
       return response()->json([
           'message' => 'Ha ocurrido un error', 
           'error' => $e
       ]);
       }

    }

    public function eliminarPago(Request $request){
        try {


            $pago = ModelPagoCompra::find($request->idPago);
            $pago->estado_id=2;
            $pago->users_id_elimina = Auth::user()->id;
            $pago->fecha_eliminado = now();        
            $pago->save();

            $totalCompra = DB::SELECTONE("select total from compra where id=".$pago->compra_id);
            $totalPagos = DB::SELECTONE("select sum(monto) as monto from pago_compra where pago_compra.estado_id = 1 and compra_id = ".$pago->compra_id);

            $faltantePago = round($totalCompra->total,2) - round($totalPagos->monto,2);

            $compra = ModelCompra::find($pago->compra_id);
            $compra->debito = round($faltantePago,2);
            $compra->save();


    
        return response()->json([
            "message" => "Eliminado con exito!"
        ]);
        } catch (QueryException $e) {
        return response()->json([
            'message' => 'Ha ocurrido un error al eliminar el pago.', 
            'error' => $e
        ]);
        }

    }
    
}
