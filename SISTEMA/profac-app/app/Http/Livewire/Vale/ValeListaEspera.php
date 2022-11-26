<?php

namespace App\Http\Livewire\Vale;

use Livewire\Component;

use App\Http\Livewire\Ventas\FacturacionCorporativa;

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

use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;
use App\Models\ModelCliente;
use App\Models\logCredito;
use App\Models\User;

use App\Models\ModelVale;
use App\Models\ModelValeHasProducto; 
use App\Models\ModelEsperaProducto;


class ValeListaEspera extends Component
{


    public $idFactura;
    public function mount($id)
    {

        $this->idFactura = $id;
    }
    public function render()
    {
       $idFactura = $this->idFactura;

       $numeroFactura = DB::SELECTONE("select numero_factura from factura where id =".$idFactura);


        return view('livewire.vale.vale-lista-espera',compact("idFactura","numeroFactura"));
    }

    public function obtenerProductosVale(Request $request){
       try {

      
        $productos = DB::SELECT("
        select 
        id,
        concat('cod ',id,' - ',nombre) as text
        from producto
        where nombre like '%". $request->search ."%' or id like '% . $request->search .%' 
        limit 15
        ");

        return response()->json([
            "results" => $productos
        ], 200);
     
       } catch (QueryException $e) {
       return response()->json([
        'icon' => 'error',
        'text' => 'Ha ocurrido un error al listar los productos',
        'title' => 'Error!',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
    }
    
    public function guardarVentaVale(Request $request){
       try{
     //    dd($request->all());
        DB::beginTransaction();

        ////Verficar si es factura de credito, para umentar credito y disminuir credito disponible 

        $this->guardarVale($request);


        $factura = ModelFactura::find($request->idFactura);        
        $factura->total = ROUND($factura->total + $request->totalGeneralVP,2);
        $factura->isv = Round($factura->isv +  $request->isvGeneralVP,2);
        $factura->sub_total = ROUND($factura->sub_total + $request->subTotalGeneralVP,2);
        $factura->save();

        $numeroVenta = DB::selectOne("select concat(YEAR(NOW()),'-',count(id)+1)  as 'numero' from factura");
        DB::commit();

        return response()->json([
            'icon' => "success",
            'text' => '
            <div class="d-flex justify-content-between">
                <a href="/factura/cooporativo/' . $request->idFactura . '" target="_blank" class="btn btn-sm btn-success"><i class="fa-solid fa-file-invoice"></i> Imprimir Factura</a>
                <a href="/venta/cobro/' . $request->idFactura . '" target="_blank" class="btn btn-sm btn-warning"><i class="fa-solid fa-coins"></i> Realizar Pago</a>
                <a href="/detalle/venta/' . $request->idFactura . '" target="_blank" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Detalle de Factura</a>
            </div>',
            'title' => 'Exito!',
            'idFactura' => $request->idFactura,
            'numeroVenta' => $numeroVenta->numero

        ], 200);


       }catch(QueryException $e){
        DB::rollback();

        return response()->json([
            'error' => 'Ha ocurrido un error al realizar la factura.',
            'icon' => "error",
            'text' => 'Ha ocurrido un error.',
            'title' => 'Error!',
            'idFactura' => $request->idFactura,
            'mensajeError'=>$e
        ], 402);
       }
    }

    public function guardarVale($request){       
    
        $arrayInputs = $request->arregloIdInputsVP;
        $arrayProductosVale =[];
        $idVale = DB::selectOne("  select id  from vale order by id desc");
        $anio = DB::SELECTONE("select year(now()) as anio");
        $numero_vale = "";

        if (empty($idVale->id)) {
            $numero_vale = $anio->anio . '-' . '1';
        } else {
            $numero_vale = $anio->anio . '-' .($idVale->id + 1) ;
        }


        $vale = new ModelVale;
        $vale->numero_vale = $numero_vale;
        $vale->sub_total = $request->subTotalGeneralVP;
        $vale->isv = $request->isvGeneralVP;
        $vale->total = $request->totalGeneralVP;
        $vale->factura_id = $request->idFactura;
        $vale->users_id = Auth::user()->id;
        $vale->notas = $request->comentario;
        $vale->estado_id = 1;
        $vale->save();


        for ($i = 0; $i < count($arrayInputs); $i++) {


            $keyIdProducto = "idProductoVP" . $arrayInputs[$i];
            $keyCantidad = "cantidadVP" . $arrayInputs[$i];
            $keyPrecio = "precioVP" . $arrayInputs[$i];
            $keySubTotal = "subTotalVP" . $arrayInputs[$i];
            $keyIsv = "isvProductoVP" . $arrayInputs[$i];//valor
            $keyTotal = "totalVP" . $arrayInputs[$i];
            $keyRestaInventario = "restaInventarioVP" . $arrayInputs[$i];
            $keyunidad = 'idUnidadVentaVP' . $arrayInputs[$i];
            
       
      

            array_push($arrayProductosVale,[
                'vale_id'=> $vale->id,
                'producto_id'=>$request->$keyIdProducto,
                'cantidad'=>$request->$keyCantidad,
                'cantidad_pendiente'=>$request->$keyCantidad,
                'precio'=>$request->$keyPrecio,
                'unidad_medida_venta_id'=>$request->$keyunidad,
                'sub_total'=>$request->$keySubTotal,
                'isv'=>$request->$keyIsv,
                'total'=>$request->$keyTotal,
                'resta_inventario_total'=>$request->$keyRestaInventario,
                'created_at'=>now(),
                'updated_at'=>now()

            ]);
        };

        ModelEsperaProducto::insert($arrayProductosVale);


       return ;

    }
}
