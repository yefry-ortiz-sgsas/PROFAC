<?php

namespace App\Http\Livewire\Inventario;

use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DetalleProducto extends Component
{

    public $idProducto;
    public function mount($id)
    {

        $this->idProducto = $id;
    }

    public function render()
    {

        $id = $this->idProducto;

        $producto = DB::SELECTONE("
            select
                A.id,
                A.nombre,
                A.descripcion,
                A.codigo_estatal,
                A.codigo_barra,
                B.descripcion as 'categoria',
                A.precio_base,
                A.isv,
                concat(C.nombre,' ',C.simbolo) as 'unidad_medida',
                A.created_at as 'fecha_registro',
                D.name as 'registrado_por'
            from  producto A
            inner join categoria_producto B
            on A.categoria_id = B.id
            inner join unidad_medida C
            on A.unidad_medida_id = C.id
            inner join users D
            on A.users_id = D.id
            where A.id = " . $id . "
        ");



        $precios = DB::SELECT("
        
        select 
            @i := @i + 1 as contador,
            A.precio,
            B.name

        from precios_venta A
        inner join users B
        on A.users_id = B.id
        cross join (select @i := 0) r
        where A.producto_id = " . $id . "
        order by A.id ASC
        
        ");

        $imagenes = DB::SELECT("
      select 
        @i := @i + 1 as contador,
        A.url_img
      from 
        img_producto A
        cross join (select @i := 0) r
        where producto_id =  " . $id . "
        
        ");

        //dd($imagenes);

        $lotes = DB::SELECT("
        select
            @i := @i + 1 as contador,
            B.id,
            B.nombre,
            G.nombre as 'departamento',
            F.nombre as 'municipio',
            E.nombre as 'bodega',
            E.direccion,
            D.descripcion as 'seccion',
            C.numeracion,
            A.cantidad_disponible,
            A.created_at
        from compra_has_producto A
        inner join producto B
        on A.producto_id = B.id
        inner join seccion C
        on A.seccion_id = C.id
        inner join segmento D
        on C.segmento_id = D.id
        inner join bodega E
        on D.bodega_id = E.id
        inner join municipio F
        on E.municipio_id = F.id
        inner join departamento G
        on F.departamento_id = G.id
        cross join (select @i := 0) r
        where A.producto_id = " . $id . " and A.cantidad_disponible <> 0
        order by A.created_at ASC
        ");





        return view('livewire.inventario.detalle-producto',  compact('producto', "precios", "imagenes", "lotes"));
    }
}
