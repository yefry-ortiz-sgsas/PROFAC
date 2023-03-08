<!DOCTYPE html>
<html>

<head>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .color-red {
            color: red;
        }

        p {
            font-size: 12px;
        }

        body {

            background-size: 100% 100%;
            margin: -45px;
            padding: 0px;
            /* ##background-image: url('img/membrete/Logo1.png'); */


            width: 45rem;
            height: 3rem;


        }


        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: left;
            padding: 2px;

        }

        thead {
            background-color: #f2f2f2
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        .letra {
            font-weight: 800;


        }
    </style>
    <title>FACTURA</title>
</head>

<body>

    @php
        $altura = 200;
        $altura2 = 320;
        $contadorFilas = 0;
        $contPe = 0;
        $p1 = 24;
        $p2 = 30;
        $vueltasTabla = 0;
    @endphp


    <div class="pruebaFondo">
        <img src="img/membrete/Logo3.png" width="800rem" style="margin-left:3%; margin-top:25px; position:absolute;"alt="">
        <div class="card border border-dark" style="margin-left:44px;  margin-top:105px; width:45rem; height:5.5rem;">
            <div class="card-header">
                <b>Factura No. {{ $cai->numero_factura }} </b>
                <b style="position:absolute;right: 270px"> *Original* </b>
                <b style="position:absolute;right: 10px">Factura de: {{ $cai->descripcion }}</b>
            </div>

            <div class="card-body">
                <p class="card-text" style="position:absolute;left:20px;  top:50px;"><b>Reistro tributario:
                        08011986138652</b></p>
                <p class="card-text" style="position:absolute;left:420px;  top:50px;"><b>CAI:
                        {{ $cai->cai }}</b></p>
                <p class="card-text" style="position:absolute;left:20px;  top:65px;"><b>Fecha límite de emisión:
                        {{ $cai->fecha_limite_emision }}</b></p>
                <p class="card-text" style="position:absolute;left:340px;  top:65px;"><b>Rango autorizado:
                        {{ $cai->numero_inicial }} - {{ $cai->numero_final }}</b></p>
            </div>
        </div>

        <div class="card border border-dark" style="margin-left:44px; margin-top:10px; width:45rem; height:10.5rem;">
            <div class="card-body">
                <p class="card-text" style="position:absolute;left:20px;  top:10px;"><b>Cliente:
                    </b>{{ $cliente->nombre }}</p>
                <p class="card-text" style="position:absolute;left:20px;  top:29px;font-size: 10px; max-width:500px">
                    <b>Dirección:</b> {{ $cliente->direccion }}
                </p>

                <p class="card-text" style="position:absolute;left:20px;  top:47px;"><b>Correo:</b>
                    {{ $cliente->correo }}
                </p>
                <p class="card-text" style="position:absolute;left:20px;  top:70px;"><b>Notas:</b> </p>


                <p class="card-text " style="position:absolute;left:20px;  top:120px;"><b>Correlativo de Ord.
                        excenta</b>
                </p>
                <p class="card-text" style="position:absolute;left:250px;  top:120px;"><b>Constancia de registro
                        exonerado</b></p>
                <p class="card-text" style="position:absolute;left:500px;  top:120px;"><b>Identificativo del registro de
                        la SAG</b></p>


                <p class="card-text" style="position:absolute;left:520px;  top:10px;"><b>Fecha:</b>
                    {{ $cai->fecha_emision }}</p>
                <p class="card-text" style="position:absolute;left:520px;  top:25px;"><b>Hora:</b> {{ $cai->hora }}
                </p>
                <p class="card-text" style="position:absolute;left:520px;  top:40px;"><b>Vence:</b>
                    {{ $cai->fecha_vencimiento }}</p>
                <p class="card-text" style="position:absolute;left:520px;  top:57px;"><b>RTN:</b> {{ $cliente->rtn }}
                </p>
                <p class="card-text" style="position:absolute;left:520px;  top:72px;"><b>Orden N°:</b>
                    {{ $ordenCompra['numero_orden'] }}
                </p>



                <p class="card-text" style="position:absolute;left:270px;  top:45px;"><b>Teléfono:</b>
                    {{ $cliente->telefono_empresa }}
                </p>
            </div>
        </div>

                 @php
                    $cant = count($productos);
                @endphp
        @if (count($productos) < 15)
            <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:10px; width:45rem">

                <div>

                    <table class="" style="font-size: 10px; ">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Bodega</th>
                                <th>Seccion</th>
                                <th>Medida</th>
                                <th>Precio </th>
                                <th>Cantidad</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->codigo }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>{{ $producto->bodega }}</td>
                                    <td>{{ $producto->seccion }}</td>
                                    <td>{{ $producto->medida }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>{{ $producto->cantidad }}</td>
                                    <td>{{ $producto->importe }}</td>
                                </tr>
                            @endforeach


                            @php

                                $altura = 50;
                                $altura2 = 450;
                            @endphp

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div style="page-break-after: always"></div> --}}
        @elseif(count($productos) > 15)
            <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:10px; width:45rem">


                <div>

                    @php
                        $contadorFilas = 0;
                    @endphp

                    <table class="" style="font-size: 10px; ">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Bodega</th>
                                <th>Seccion</th>
                                <th>Medida</th>
                                <th>Precio </th>
                                <th>Cantidad</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->codigo }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>{{ $producto->bodega }}</td>
                                    <td>{{ $producto->seccion }}</td>
                                    <td>{{ $producto->medida }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>{{ $producto->cantidad }}</td>
                                    <td>{{ $producto->importe }}</td>
                                </tr>
                                @php
                                    $contPe++;
                                    if ($contadorFilas > 22) {
                                        break;
                                    } else {
                                        $contadorFilas++;
                                    }

                                @endphp
                            @endforeach

                            @for ($i = 0; $i < 24; $i++)
                                @php unset($productos[$i]); @endphp
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="page-break-after: always"></div>

            @if (count($productos) > 30)
                @php
                    $numeroTablas = ceil(count($productos) / 30);
                @endphp

                @for ($g = 0; $g < $numeroTablas; $g++)
                    @if (count($productos) >= 30)
                        <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:80px; width:45rem">

                            <div>

                                @php
                                    if ($g != 0) {
                                        $vueltasTabla++;
                                    }
                                    $contadorFilas = 0;
                                    $contPe = 0;
                                @endphp

                                <table class="" style="font-size: 10px; ">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Bodega</th>
                                            <th>Seccion</th>
                                            <th>Medida</th>
                                            <th>Precio </th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($productos as $producto)
                                            <tr>
                                                <td>{{ $producto->codigo }}</td>
                                                <td>{{ $producto->descripcion }}</td>
                                                <td>{{ $producto->bodega }}</td>
                                                <td>{{ $producto->seccion }}</td>
                                                <td>{{ $producto->medida }}</td>
                                                <td>{{ $producto->precio }}</td>
                                                <td>{{ $producto->cantidad }}</td>
                                                <td>{{ $producto->importe }}</td>
                                            </tr>
                                            @php
                                                $contPe++;
                                                if ($contadorFilas > 28) {
                                                    break;
                                                } else {
                                                    $contadorFilas++;
                                                }

                                            @endphp
                                        @endforeach





                                    </tbody>
                                </table>
                                @if ($vueltasTabla == 0)
                                    @php
                                        $p2 = $p2 + $p1;
                                    @endphp
                                    @for ($i = $p1; $i < $p2; $i++)
                                        @php unset($productos[$i]); @endphp
                                    @endfor
                                @elseif($vueltasTabla > 1 && $vueltasTabla < $numeroTablas)

                                    @php $p2=$p2 + 30; @endphp @for ($i = $p2; $i < $p2; $i++)
                                        @php unset($productos[$i]); @endphp
                                    @endfor
                                @endif
                            </div>
                        </div>
                        <div style="page-break-after: always"></div>
                    @elseif(count($productos) < 30)
                        <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:80px; width:45rem">

                            <div>

                                @php
                                    $contadorFilas = 0;
                                @endphp

                                <table class="" style="font-size: 10px; ">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Bodega</th>
                                            <th>Seccion</th>
                                            <th>Medida</th>
                                            <th>Precio </th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($productos as $producto)
                                            <tr>
                                                <td>{{ $producto->codigo }}</td>
                                                <td>{{ $producto->descripcion }}</td>
                                                <td>{{ $producto->bodega }}</td>
                                                <td>{{ $producto->seccion }}</td>
                                                <td>{{ $producto->medida }}</td>
                                                <td>{{ $producto->precio }}</td>
                                                <td>{{ $producto->cantidad }}</td>
                                                <td>{{ $producto->importe }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="page-break-after: always"></div>
                    @endif
                @endfor
            {{-- @else
                <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:80px; width:45rem">
                    <div>

                        @php
                            $contadorFilas = 0;
                        @endphp

                        <table class="" style="font-size: 11px; ">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Bodega</th>
                                    <th>Seccion</th>
                                    <th>Medida</th>
                                    <th>Precio </th>
                                    <th>Cantidad</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->descripcion }}</td>
                                        <td>{{ $producto->bodega }}</td>
                                        <td>{{ $producto->seccion }}</td>
                                        <td>{{ $producto->medida }}</td>
                                        <td>{{ $producto->precio }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                        <td>{{ $producto->importe }}</td>
                                    </tr>
                                    @php
                                        $contPe++;
                                        if ($contadorFilas > 12) {
                                            break;
                                        } else {
                                            $contadorFilas++;
                                        }

                                    @endphp
                                @endforeach
                                @for ($i = 0; $i < 14; $i++)
                                    @php unset($productos[$i]); @endphp
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            @elseif(count($productos) <= 15)
            <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:80px; width:45rem">

                <div>

                    @php
                        $contadorFilas = 0;
                    @endphp

                    <table class="" style="font-size: 10px; ">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Bodega</th>
                                <th>Seccion</th>
                                <th>Medida</th>
                                <th>Precio </th>
                                <th>Cantidad</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->codigo }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>{{ $producto->bodega }}</td>
                                    <td>{{ $producto->seccion }}</td>
                                    <td>{{ $producto->medida }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>{{ $producto->cantidad }}</td>
                                    <td>{{ $producto->importe }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @elseif(count($productos) < 30 && count($productos) > 15)
            <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:80px; width:45rem">

                <div>

                    @php
                        $contadorFilas = 0;
                    @endphp

                    <table class="" style="font-size: 10px; ">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Bodega</th>
                                <th>Seccion</th>
                                <th>Medida</th>
                                <th>Precio </th>
                                <th>Cantidad</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->codigo }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>{{ $producto->bodega }}</td>
                                    <td>{{ $producto->seccion }}</td>
                                    <td>{{ $producto->medida }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>{{ $producto->cantidad }}</td>
                                    <td>{{ $producto->importe }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="page-break-after: always"></div>
            @endif

        @endif















        <div style=" position: relative; margin-left:44px; margin-top:30px">
            <div class="card border border-dark" style="position:absolute;left:0px;  width:26rem; height:15rem;">
                <div class="card-body">

                    <p class="card-text" style="position:absolute;left:10px;  top:2px; font-size:14px;"><b>Vendedor:
                        </b>
                        {{ $cai->name }} </p>


                    <p class="card-text" style="position:absolute;left:0px;  top:28px; font-size:11px;">
                        ____________________________________________________________________</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:40px; font-size:11px;">1. por cada
                        cheque
                        devuelto se cobra 750 lempiras.</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:51px; font-size:11px">2. toda cuenta
                        vencida pagara el 3.5% de interés mensual.</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:63px; font-size:11px">3. el único
                        comprobante de pago de ésta factura es el emitido por distribuciones valencia.</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:95px; font-size:11px">4 no se aceptan
                        reclamos ni devoluciones después de 10 días.</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:110px; font-size:11px">5. la firma del
                        cliente o representante en la factura, da por hecho que acepta y obliga a este a cumplir con
                        todas
                        las condiciones estipuladas.</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:143px; font-size:11px">6. el cliente
                        debera realizar el pago de la factura a su fecha de vencimiento, en caso de incumplimiento de
                        pago,
                        este se compromete a aceptar otros procesos de cobrosm a la vez renuncia a su domicilio para
                        efectos
                        legales y somete a la jurisdicción de tegucigalpa municipio del distrito central.</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:205px; font-size:11px">7. las entregas
                        y
                        creditos para cuentas con facturas vencidas serán congeladas hasta el pago de las mismas haya
                        sido
                        efectuado en su totalidad.

                        @if ($cai->estado_factura == 1)
                            <span style="font-size: 10px">N{{ $cai->numero }}-CF11</span>
                    </p>
                @else
                    <span style="font-size: 10px">N{{ $cai->numero }}-CF12</span></p>
                    @endif

                    @if ($flagCentavos == false)
                        <p class="card-text" style="position:absolute;left:35px;  top:240px; font-size:12px;">
                            "{{ $numeroLetras . ' CON CERO CENTAVOS' }}"</p>
                    @else
                        <p class="card-text" style="position:absolute;left:35px;  top:240px; font-size:12px;">
                            "{{ $numeroLetras }}"</p>
                    @endif

                </div>
            </div>

            <div class="card border border-dark"
                style="position:absolute;left:430px;   width:18rem; height:15rem;">
                <div class="card-body">
                    <div>
                        <p class="card-text " style="position:absolute; left:10px;  top:10px; font-size:16px;">Importe
                            exonerado:</p>
                        <p class="card-text" style="position:absolute;  right:10px;  top:10px; font-size:16px;">L.
                            0.00</p>
                    </div>
                    <div>
                        <p class="card-text" style="position:absolute; left:10px;  top:28px; font-size:16px;">Importe
                            Gravado: </p>
                        <p class="card-text" style="position:absolute; right:10px;  top:28px; font-size:16px;">L.
                            {{ $importesConCentavos->sub_total }}</p>
                    </div>

                    <div>
                        <p class="card-text" style="position:absolute; left:10px;  top:46px; font-size:16px;">Importe
                            Exento: </p>
                        <p class="card-text" style="position:absolute; right:10px;  top:46px; font-size:16px;">L. 0.00
                        </p>
                    </div>


                    {{-- <p class="card-text" style="position:absolute; left:10px;  top:65px; font-size:16px;">Total Importe:
                    </p>
                    <p class="card-text" style="position:absolute; left:200px;  top:65px; font-size:16px;">1200.00</p> --}}

                    <p class="card-text" style="position:absolute; left:10px;  top:85px; font-size:16px;">Desc. y
                        Rebajas:
                    </p>
                    <p class="card-text" style="position:absolute; right:10px;  top:85px; font-size:16px;">L. 0.00</p>

                    <p class="card-text" style="position:absolute; left:10px;  top:105px; font-size:16px;">Sub Total:
                    </p>
                    <p class="card-text" style="position:absolute; right:10px;  top:105px; font-size:16px;">L.
                        {{ $importesConCentavos->sub_total }}</p>

                    <p class="card-text" style="position:absolute; left:10px;  top:130px; font-size:16px;">Impuesto
                        sobre
                        venta:</p>
                    <p class="card-text" style="position:absolute; right:10px;  top:130px; font-size:16px;">L.
                        {{ $importesConCentavos->isv }}</p>

                    <p class="card-text" style="position:absolute; left:10px;  top:148px; font-size:16px;">Impuesto
                        sobre
                        bebida:</p>
                    <p class="card-text" style="position:absolute; right:10px;  top:148px; font-size:16px;">L. 0.00
                    </p>

                    <p class="card-text" style="position:absolute; left:10px;  top:185px; font-size:18px;"><b>Total a
                            Pagar: </b></p>
                    <p class="card-text" style="position:absolute; right:10px;  top:185px; font-size:18px;">
                        <b>L. {{ $importesConCentavos->total }}</b>
                    </p>
                </div>




            </div>



            <div style="position:absolute; left:0px;   width:45rem; margin-top:300px">
                <p class="card-text" style="position:absolute;left:20px;  top:10px;">
                    _______________________________________</p>
                <p class="card-text" style="position:absolute;left:450px;  top:10px;">
                    _______________________________________</p>
                <p class="card-text" style="position:absolute;left:80px;  top:25px; ">
                    {{ strtoupper($cliente->nombre) }}</p>
                <p class="card-text" style="position:absolute;left:495px;  top:25px;">DISTRIBUCIONES VALENCIA</p>
            </div>


        </div>

        @if ($cai->estado_venta_id == 2)
            <div>
                <p class=""
                    style="position:absolute; margin-top:{{ $altura2 + 40 }}px;  left:80px;   font-size:50px;">
                    --FACTURA ANULADA--</p>
            </div>
        @endif






    </div>




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
