<?php

namespace App\Http\Livewire\CvDolar;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use DataTables;
use App\Models\cDolar;

class CvDolar extends Component
{
    public function render()
    {
        return view('livewire.cv-dolar.cv-dolar');
    }

    public function guardarpDolar(Request $request){
            //dd($request);

            /*         CREATE TABLE `cvDolar` (
            `id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `valor` double NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1; */

        try {
            $validator = Validator::make($request->all(), [
                'valor_dolar' => 'required'

            ], [
                'valor_dolar' => 'Valor del Dólar en Lempiras es requerido'

            ]);


            if ($validator->fails()) {
                return response()->json([
                    'icon'=>'error',
                    'title'=>'Error',
                    'text'=>'Ha ocurrido un error, todos los campos son obligatorios.',
                    'errors' => $validator->errors()
                ], 402);
            }



            $cvDolar = new cDolar;

            $cvDolar->user_id = Auth::user()->id;
            $cvDolar->valor = floatval($request->valor_dolar) ;

            $cvDolar->save();




            return response()->json([
                 'icon'=>'success',
                 'title'=>'Exito!',
                 'text'=>'Valor guardado con exito.'
            ],200);

        } catch (QueryException $e) {

        return response()->json([
         'icon'=>'error',
         'title'=>'Error!',
         'text'=>'Ha ocurrido un error, intente de nuevo.',
         'message' => 'Ha ocurrido un error',
         'error' => $e
        ],402);
        }

    }

    public function listarValorDolares(){

        try{

            $cvDolar = DB::SELECT("select
            cvDolar.id as 'id',
            users.name as 'user',
            cvDolar.valor as 'valor',
            cvDolar.created_at as 'fechaRegistro'
            from cvDolar
            inner join users
            on cvDolar.user_id = users.id");

            return Datatables::of($cvDolar)
                    ->make(true);
            } catch (QueryException $e) {


                return response()->json([
                    'message' => 'Ha ocurrido un error al listar los valores.',
                    'errorTh' => $e,
                ], 402);
            }
    }

}
