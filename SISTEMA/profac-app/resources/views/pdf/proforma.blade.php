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
            margin: -45px;
            padding: 0px;
            /* background-image: url('img/membrete/membrete2.jpg'); */

            background-size: 200% 200%;
            background-size: cover;

            width: 115% !important;

        }

        table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        }
        th, td {
        text-align: left;
        padding: 2px;

        }

        thead {
            background-color: #f2f2f2
        }

        tr:nth-child(even){background-color: #f2f2f2}

        .letra {
            font-weight: 800;


        }
    </style>
    <title>PROFORMA</title>
</head>

<body>

@php
        $altura = 200;
        $altura2 = 620;
        $contadorFilas = 0;
        $contPe = 0;
        $p1 = 14;
        $p2 = 20;
        $vueltasTabla = 0;
@endphp


    <div class="pruebaFondo">
        {{-- <img src="img/membrete/Logo3.png" width="800rem"
        style="margin-left:3%; margin-top:25px; position:absolute;"
         alt=""> --}}
        <div class="card border border-dark" style="margin-left:44px;  margin-top:150px; width:45rem; height:5.5rem;">
            <div class="card-header">
                <b>Proforma  No.  {{$datos->codigo}}</b>

            </div>
            <div class="card-body">
                <p class="card-text" style="position:absolute;left:20px;  top:50px;"><b>Reistro tributario:
                    RTN GRUPO ALCA</b></p>
            </div>
        </div>

        <div class="card border border-dark"   style="margin-left:44px; margin-top:10px; width:45rem; height:6.5rem;">
            <div class="card-body">
                <p class="card-text" style="position:absolute;left:20px;  top:10px;"><b>Cliente: </b>{{$datos->nombre}}</p>

                <br>
                <br>
                <p class="card-text" style="position:absolute;left:20px;  top:29px;font-size: 11px; max-width:520px">
                    <b>Dirección:</b> {{ $datos->direccion }}
                </p>
                <br>
                <br>
                <br>

                <p class="card-text" style="position:absolute;left:20px;  top:75px;"><b>Correo:</b> {{$datos->correo}}
                </p>{{--
                        <p class="card-text" style="position:absolute;left:20px;  top:70px;"><b>Notas:</b> </p>
                    --}}
                <p class="card-text" style="position:absolute;left:540px;  top:10px;"><b>Fecha:</b> {{$datos->fecha_emision}} </p>
                <p class="card-text" style="position:absolute;left:540px;  top:25px;"><b>Hora:</b> {{$datos->hora}}</p>
                <p class="card-text" style="position:absolute;left:540px;  top:40px;"><b>Vence:</b> {{$datos->fecha_vencimiento}}</p>
                <p class="card-text" style="position:absolute;left:540px;  top:57px;"><b>RTN:</b> {{$datos->rtn}}</p>

                </p>



                <p class="card-text" style="position:absolute;left:270px;  top:75px;"><b>Teléfono:</b> {{ $datos->telefono_empresa}}
                </p>
            </div>
        </div>

        @if(count($productos) <= 10)
        <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:10px; width:45rem; page-break-inside: auto;">
            <div>

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
                                <td>{{ $producto->nombre }}</td>
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

        @elseif(count($productos) > 10)
                <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:10px; width:45rem; page-break-inside: auto;">
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
                                        <td>{{ $producto->nombre }}</td>
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

                                        {{-- eliminando productos ya rebderizados --}}
                                @for ($i = 0; $i < 14; $i++)
                                    @php
                                    unset($productos[$i]);
                                    @endphp
                                @endfor



                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="page-break-after: always"></div>
                @if (count($productos) > 20)
                    @php
                        $numeroTablas = ceil(count($productos) / 20);
                    @endphp

                    @for ($g = 0; $g < $numeroTablas; $g++)
                        @if(count($productos) > 20)

                            <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:80px; width:45rem; page-break-inside: auto;">
                                <div>

                                    @php
                                        if ($g != 0) {
                                            $vueltasTabla++;
                                        }
                                        $contadorFilas = 0;
                                        $contPe = 0;
                                    @endphp

                                    <table class="" style="font-size: 12px; ">
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
                                                    <td>{{ $producto->nombre }}</td>
                                                    <td>{{ $producto->bodega }}</td>
                                                    <td>{{ $producto->seccion }}</td>
                                                    <td>{{ $producto->medida }}</td>
                                                    <td>{{ $producto->precio }}</td>
                                                    <td>{{ $producto->cantidad }}</td>
                                                    <td>{{ $producto->importe }}</td>
                                                </tr>
                                                @php
                                                    $contPe++;
                                                    if ($contadorFilas > 18) {
                                                        break;
                                                    } else {
                                                        $contadorFilas++;
                                                    }

                                                @endphp
                                            @endforeach





                                        </tbody>
                                    </table>
                                    @if($vueltasTabla == 0)
                                        @php
                                            $p2 =$p2  + $p1;
                                        @endphp
                                        @for ($i = $p1; $i < $p2 ; $i++)
                                            @php
                                            unset($productos[$i]);
                                            @endphp
                                        @endfor

                                    @elseif($vueltasTabla > 1 && $vueltasTabla < $numeroTablas)
                                        @php
                                            $p2 =$p2  + 20;
                                        @endphp
                                        @for ($i = $p2; $i < $p2 ; $i++)
                                            @php
                                            unset($productos[$i]);
                                            @endphp
                                        @endfor
                                    @endif

                                </div>
                            </div>
                            <div style="page-break-after: always"></div>

                        @elseif(count($productos) < 20)
                            <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:80px; width:45rem; page-break-inside: auto;">
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
                                                    <td>{{ $producto->nombre }}</td>
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
                @else
                        <div class="card border border-dark"
                        style="position: relative; margin-left:44px; margin-top:80px; width:45rem; page-break-inside: auto;">
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
                                                <td>{{ $producto->nombre }}</td>
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

                                                {{-- eliminando productos ya rebderizados --}}
                                        @for ($i = 0; $i < 14; $i++)
                                            @php
                                            unset($productos[$i]);
                                            @endphp
                                        @endfor



                                    </tbody>
                                </table>
                            </div>
                        </div>
                @endif
        @endif




        <div style=" position: relative; margin-left:44px; page-break-inside: avoid; margin-top:10px; ">
            <div class="card border border-dark" style="position:absolute;left:0px;  width:26rem; height:15rem;">
                <div class="card-body">

                    <p class="card-text" style="position:absolute;left:10px;  top:2px; font-size:14px;"><b>Vendedor: </b>
                         </p>

                    {{-- <p class="card-text" style="position:absolute;left:10px;  top:18px; font-size:14px"><b>Repartidor: </b>
                        NULL</p> --}}

                        {{-- @if($cai->factura == 1)
                        <p class="letra" style="position:absolute; right:10px;  top:2px; font-size:20px;">C</p>
                        @else
                        <p class="letra" style="position:absolute; right:10px;  top:2px; font-size:20px;">G</p>
                        @endif     --}}



                    <p class="card-text" style="position:absolute;left:0px;  top:28px; font-size:11px;">
                        ____________________________________________________________________</p>
                    <p class="card-text" style="position:absolute;left:10px;  top:40px; font-size:11px;">Precios sujetos a cambios.</p>

                    @if($flagCentavos == false)
                    <p class="card-text" style="position:absolute;left:35px;  top:240px; font-size:12px;">"{{$numeroLetras." CON CERO CENTAVOS"}}"</p>

                    @else
                    <p class="card-text" style="position:absolute;left:35px;  top:240px; font-size:12px;">"{{$numeroLetras }}"</p>
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
                            {{ $importesConCentavos->sub_total_grabado }}</p>
                    </div>

                    <div>
                        <p class="card-text" style="position:absolute; left:10px;  top:46px; font-size:16px;">Importe
                            Exento: </p>
                        <p class="card-text" style="position:absolute; right:10px;  top:46px; font-size:16px;">L. {{ $importesConCentavos->sub_total_excento }}
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

            <div style="position:absolute;left:0px;  margin-top:{{$altura2}}px;  width:45rem;">
                <p class="card-text" style="position:absolute;left:20px;  top:10px;">
                    _______________________________________</p>

                <p class="card-text" style="position:absolute;left:120px;  top:25px; ">Autorizado por:</p>

            </div>
        </div>






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
