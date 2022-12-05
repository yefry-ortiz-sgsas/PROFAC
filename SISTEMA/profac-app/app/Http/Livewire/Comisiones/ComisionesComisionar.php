<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\Comisiones\desglose;

use App\Models\Comisiones\comision;


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

        $gananciaTotal = DB::SELECTONE("SELECT SUM(desglose.gananciatotal) AS gananciaTotal FROM desglose where idFactura = ".$idFactura);


        $idVendedor = DB::SELECTONE("SELECT desglose.vendedor_id as id FROM desglose where idFactura = ".$idFactura);

        $mesFactura = DB::SELECTONE("SELECT DATE_FORMAT(fecha_emision,'%m') as mes  from factura where id =".$idFactura);
        //dd();
        $centComisionado = DB::SELECTONE("SELECT factura.comision_estado_pagado as estado FROM factura where id =".$idFactura);
        //dd($idVendedor);

        return view('livewire.comisiones.comisiones-comisionar', compact('idFactura', 'gananciaTotal','idVendedor', 'mesFactura', 'centComisionado'));
        //return view('livewire.comisiones.comisiones-comisionar');
    }



    public function obtenerDesglose($id){
        //dd($id);
        try {
            $listaProd = DB::SELECT("
            SELECT * FROM desglose where idFactura = ".$id."
            ");
            return Datatables::of($listaProd)
            ->addColumn('acciones', function ($listaProd) {
                    return

                    '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            <li>
                                <a class="dropdown-item" href="ir('.$listaProd->idFactura.')" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Ver </a>
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

    public function guardarComision(Request $request){
        try {

            DB::beginTransaction();
                //dd($request);

                $comisionMonto = (($request->porcentaje)/100)*$request->gananciaTotal;


                $idComisionTecho = DB::SELECTONE("select id from comision_techo where comision_techo.vendedor_id = ".$request->idVendedor." and comision_techo.meses_id = ".$request->mesFactura." and comision_techo.estado_id = 1");
                //dd($idComisionTecho);
                //dd($idComisionTecho);
                $comision = new comision;
                $comision->comision_techo_id = $idComisionTecho->id;
                $comision->factura_id = $request->factura;
                $comision->vendedor_id = $request->idVendedor;
                $comision->gananciaTotal = $request->gananciaTotal;
                $comision->porcentaje = $request->porcentaje;
                $comision->monto_comison = $comisionMonto;
                $comision->estado_id = 1;
                $comision->users_registro_id = Auth::user()->id;
                $comision->save();

                DB::update('
                    update
                    factura
                    set comision_estado_pagado = 1, monto_comision = '.$comisionMonto.'
                    where id = '.$request->factura.'
                ');

            DB::commit();
            return response()->json([
                "icon" => "success",
                "text" => "Registro de comisión hecho con éxito!",
                "title"=>"Exito!"
            ],200);

        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                "icon" => "error",
                "text" => "Ha ocurrido un error al registrar la comisión.",
                "title"=>"Error!",
                "error" => $e
            ],402);
        }
    }


    public function guardarComisionMasivo(Request $request){
        try {
            //dd();

            DB::beginTransaction();
                //dd($techo);

                $comisionMonto = (($request->porcentaje)/100)*$request->gananciaTotal;
                $comision = new comision;
                $comision->comision_techo_id =
                $comision->factura_id = $request->factura;
                $comision->vendedor_id = $request->idVendedor;
                $comision->gananciaTotal = $request->gananciaTotal;
                $comision->porcentaje = $request->porcentaje;
                $comision->monto_comison = $comisionMonto;
                $comision->estado_id = 1;
                $comision->users_registro_id = Auth::user()->id;
                $comision->save();

                DB::update('
                update
                factura
                set comision_estado_pagado = 1, monto_comision = '.$comisionMonto.'
                where id = '.$request->factura.'
            ');

            DB::commit();
            return response()->json([
                "icon" => "success",
                "text" => "Registro de comisión hecho con éxito!",
                "title"=>"Exito!"
            ],200);

        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                "icon" => "error",
                "text" => "Ha ocurrido un error al registrar la comisión.",
                "title"=>"Error!",
                "error" => $e
            ],402);
        }
    }
}
