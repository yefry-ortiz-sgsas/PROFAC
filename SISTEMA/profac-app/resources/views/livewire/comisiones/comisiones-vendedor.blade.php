
    <div>
        <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <h2>Desgloce de comisiones Personales de:  {{ Auth::user()->name }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html"></a>
                    </li>
                </ol>
            </div>
        </div>





        <div class="wrapper wrapper-content animated fadeInRight">
            <label for="" class="col-form-label focus-label"><b> Lista de facturas cerradas:</b></label>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id="tbl_facturasVendedor_cerradas" class="table table-striped table-bordered table-hover">
                                    <thead class="">
                                        <tr>


                                            <th>Código Factura</th>
                                            <th>Mes de Factura</th>
                                            <th>Nº Factura</th>
                                            <th>Fecha de emisión</th>
                                            <th>Fecha de vencimiento</th>
                                            <th>Fecha Máxima de gracia</th>
                                            <th>Cliente</th>
                                            <th>Total </th>
                                            <th>Estado de pago</th>
                                            <th>Comisión</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <label for="" class="col-form-label focus-label">  <b> Lista de facturas sin cerrar:</b></label>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id="tbl_facturasVendedor_sinCerrar" class="table table-striped table-bordered table-hover">
                                    <thead class="">
                                        <tr>

                                            <th>Código Factura</th>
                                            <th>Mes de Factura</th>
                                            <th>Nº Factura</th>
                                            <th>Fecha de emisión</th>
                                            <th>Fecha de vencimiento</th>
                                            <th>Fecha Máxima de gracia</th>
                                            <th>Cliente</th>
                                            <th>Total </th>
                                            <th>Estado de pago</th>
                                            <th>Comisión</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="wrapper wrapper-content animated fadeInRight">
            <br>
            <label for="" class="col-form-label focus-label"><b> Lista Comisiones Pagadas:</b></label>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table name="tbl_historico_comisionesPagadas" id="tbl_historico_comisionesPagadas" class="table table-striped table-bordered table-hover">
                                    <thead class="">
                                        <tr>
                                            <th>Código de vendedor</th>
                                            <th>Vendedor</th>
                                            <th>Mes de comisión</th>
                                            <th>Código de mes</th>
                                            <th>Cantidad de facturas comisionadas</th>
                                            <th>Techo asignado</th>
                                            <th>Ganancia total de las facturas del mes</th>
                                            <th>Monto asignado y pagado</th>
                                            <th>Usuario de registro de pago</th>
                                            <th>Fecha del registro de pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>





        @push('scripts')
            <script>
                $( document ).ready(function() {

                    $('#tbl_facturasVendedor_cerradas').DataTable({
                        "order": [1, 'asc'],
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                        },
                        pageLength: 10,
                        responsive: true,
                        dom: '<"html5buttons"B>lTfgitp',
                        buttons: [{
                                extend: 'copy'
                            },
                            {
                                extend: 'csv'
                            },
                            {
                                extend: 'excel',
                                title: 'ExampleFile'
                            },
                            {
                                extend: 'pdf',
                                title: 'ExampleFile'
                            },

                            {
                                extend: 'print',
                                customize: function(win) {
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                }
                            }
                        ],
                        "ajax": "/listar/cerradas",
                        "columns": [
                            {
                                data: 'id'
                            },
                            {
                                data: 'mesFactura'
                            },
                            {
                                data: 'numero_factura'
                            },
                            {
                                data: 'fecha_emision'
                            },
                            {
                                data: 'fecha_vencimiento'
                            },
                            {
                                data: 'fechaGracia'
                            },
                            {
                                data: 'nombre'
                            },
                            {
                                data: 'total'
                            },
                            {
                                data: 'estadoPago'
                            },
                            {
                                data: 'comision'
                            },
                            {
                                data: 'acciones'
                            }

                        ]


                    });

                    $('#tbl_facturasVendedor_sinCerrar').DataTable({
                        "order": [1, 'asc'],
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                        },
                        pageLength: 10,
                        responsive: true,
                        dom: '<"html5buttons"B>lTfgitp',
                        buttons: [{
                                extend: 'copy'
                            },
                            {
                                extend: 'csv'
                            },
                            {
                                extend: 'excel',
                                title: 'ExampleFile'
                            },
                            {
                                extend: 'pdf',
                                title: 'ExampleFile'
                            },

                            {
                                extend: 'print',
                                customize: function(win) {
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                }
                            }
                        ],
                        "ajax": "/listar/sinCerrar",
                        "columns": [
                            {
                                data: 'id'
                            },
                            {
                                data: 'mesFactura'
                            },
                            {
                                data: 'numero_factura'
                            },
                            {
                                data: 'fecha_emision'
                            },
                            {
                                data: 'fecha_vencimiento'
                            },
                            {
                                data: 'fechaGracia'
                            },
                            {
                                data: 'nombre'
                            },
                            {
                                data: 'total'
                            },
                            {
                                data: 'estadoPago'
                            },
                            {
                                data: 'comision'
                            },
                            {
                                data: 'acciones'
                            }

                        ]


                    });

                    $('#tbl_historico_comisionesPagadas').DataTable({
                        "order": [0, 'desc'],
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                        },
                        pageLength: 10,
                        responsive: true,
                        dom: '<"html5buttons"B>lTfgitp',
                        buttons: [{
                                extend: 'copy'
                            },
                            {
                                extend: 'csv'
                            },
                            {
                                extend: 'excel',
                                title: 'ExampleFile'
                            },
                            {
                                extend: 'pdf',
                                title: 'ExampleFile'
                            },

                            {
                                extend: 'print',
                                customize: function(win) {
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                }
                            }
                        ],
                        "ajax": "/listar/pagos",
                        "columns": [
                            {
                                data: 'vendedor_id'
                            },
                            {
                                data: 'nombre_vendedor'
                            },
                            {
                                data: 'mes_comision'
                            },
                            {
                                data: 'meses_id'
                            },
                            {
                                data: 'cantidad_facturas'
                            },
                            {
                                data: 'techo_asignado'
                            },
                            {
                                data: 'ganancia_total'
                            },
                            {
                                data: 'monto_asignado'
                            },
                            {
                                data: 'users_registra_id'
                            },
                            {
                                data: 'created_at'
                            }


                        ]


                    });
                });
            </script>
        @endpush

    </div>








    <?php
    date_default_timezone_set('America/Tegucigalpa');
    $act_fecha=date("Y-m-d");
    $act_hora=date("H:i:s");
    $mes=date("m");
    $year=date("Y");
    $datetim=$act_fecha." ".$act_hora;
?>
<script>
    function mostrarHora() {
        var fecha = new Date(); // Obtener la fecha y hora actual
        var hora = fecha.getHours();
        var minutos = fecha.getMinutes();
        var segundos = fecha.getSeconds();

        // A単adir un 0 delante si los minutos o segundos son menores a 10
        minutos = minutos < 10 ? "0" + minutos : minutos;
        segundos = segundos < 10 ? "0" + segundos : segundos;

        // Mostrar la hora actual en el elemento con el id "reloj"
        document.getElementById("reloj").innerHTML = hora + ":" + minutos + ":" + segundos;
    }
    // Actualizar el reloj cada segundo
    setInterval(mostrarHora, 1000);
</script>
<div class="float-right">
    <?php echo "$act_fecha";  ?> <strong id="reloj"></strong>
</div>
<div>
    <strong>Copyright</strong> Distribuciones Valencia &copy; <?php echo "$year";  ?>
</div>
<p id="reloj"></p>
