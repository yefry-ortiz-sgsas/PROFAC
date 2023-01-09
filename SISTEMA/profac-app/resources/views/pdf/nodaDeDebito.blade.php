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
            background-image: url('img/membrete/membrete2.jpg');

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
    <title>Comprobante de Entrega</title>
</head>

<body>

@php
    $altura =20;
    $altura2 = 320;
    $contadorFilas = 0;
@endphp


    <div class="pruebaFondo">
        <br><br><br><br><br>
        <div class="card border border-dark" style="margin-left:44px;  margin-top:150px; width:45rem; height:7rem;">

            <div class="card-header">

            <p class="card-text" style="position:absolute;left:20px;  top:0px;"><b>CAI: {{ $cai->cai }} </b></p>
            <p class="card-text" style="position:absolute;left:20px;  top:15px;"><b>Fecha Emisión: {{ $cai->fecha_limite_emision }} </b></p>
            <br>
            <b>NOTA DE DÉBITO No. {{$notaDebito->numeroCai}}</b>

            </div>
            <div class="card-body">
                <p class="card-text" style="position:absolute;left:20px;  top:73px;"><b>Cliente: {{ $cliente->nombre_cliente }} </b></p>

                <p class="card-text" style="position:absolute;left:20px;  top:87px;"><b>Fecha Emisión: {{ $cliente->nombre_cliente }} </b></p>

            </div>
        </div>

        <br>
        <br><br>

        <div class="card border border-dark" style="position: relative; margin-left:44px; margin-top:10px; width:45rem;">
            <div >
                <table  class="" style="font-size: 11px;">
                    <thead>
                        <tr>
                          <th>DESCRIPCIÓN</th>
                          <th>VALOR</th>
                          <th>TOTAL</th>
                        </tr>
                    </thead>
                        <tr>
                            <td>POR FACTURA NO. {{ $cliente->cai }} </td>
                            <td>L - </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ $notaDebito->motivoDescripcion }}</td>
                            <td>L. {{ $montoConCentavos->total }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>RECARGO APLICADO</td>
                            <td>L - </td>
                            <td>L. {{ $montoConCentavos->total }}</td>
                        </tr>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <p class="card-text" style="position:absolute;left:20px;  top:530px;"><b>TOTAL EN LETRAS: {{ $numeroLetras }} </b></p>

        <div style=" position: relative; margin-left:44px;">

            <div style="position:absolute;left:0px;  margin-top:{{$altura2}}px;  width:45rem;">
                <p class="card-text" style="position:absolute;left:20px;  top:10px;">
                    _______________________________________</p>
                <p class="card-text" style="position:absolute;left:450px;  top:10px;">
                    _______________________________________</p>
                <p class="card-text" style="position:absolute;left:60px;  top:25px; ">{{ $cliente->nombre_cliente }}</p>
                <p class="card-text" style="position:absolute;left:495px;  top:25px;">DISTRIBUCIONES VALENCIA</p>
            </div>



        </div>

        {{-- @if($datosEntrega->estadoVale==2)
        <div>
            <p class="" style="position:absolute; margin-top:{{$altura2 + 85}}px;  left:140px;   font-size:50px;">--VALE ANULADO--</p>
        </div>
        @elseif($datosEntrega->estadoVale==5)
        <div>
            <p class="" style="position:absolute; margin-top:{{$altura2 + 85}}px;  left:140px;   font-size:50px;">--VALE ELIMINADO--</p>
        </div>
        @endif --}}






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
