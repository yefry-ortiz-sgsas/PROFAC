<div>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Histórico de comisiones. </h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Lista de las facturas y vendedor comisionadas. </a>
                </li>


            </ol>
        </div>
        <br>
        <div class="wrapper wrapper-content animated fadeInRight">
                <br>
                <label for="" class="col-form-label focus-label"><b> Lista Comisiones aprobadas por mes:</b></label>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table name="tbl_historico_comisionesMes" id="tbl_historico_comisones" class="table table-striped table-bordered table-hover">
                                        <thead class="">
                                            <tr>
                                                <th>Código de comisión</th>
                                                <th>Código de Factura</th>
                                                <th>Código de vendedor</th>
                                                <th>Vendedor</th>
                                                <th>Ganancia de Factura x vendedor</th>
                                                <th>Procentaje Asignado</th>
                                                <th>Monto de ganancia asignado</th>
                                                <th>Usuario de Registro</th>
                                                <th>Fecha de Registro</th>
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
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
           <br>
            <label for="" class="col-form-label focus-label"><b> Lista Comisiones por factura:</b></label>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table name="tbl_historico_comisones" id="tbl_historico_comisones" class="table table-striped table-bordered table-hover">
                                    <thead class="">
                                        <tr>
                                            <th>Código de comisión</th>
                                            <th>Código de Factura</th>
                                            <th>Código de vendedor</th>
                                            <th>Vendedor</th>
                                            <th>Ganancia de Factura x vendedor</th>
                                            <th>Procentaje Asignado</th>
                                            <th>Monto de ganancia asignado</th>
                                            <th>Usuario de Registro</th>
                                            <th>Fecha de Registro</th>
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
                                <table name="tbl_historico_comisionesPagadas" id="tbl_historico_comisonesPagadas" class="table table-striped table-bordered table-hover">
                                    <thead class="">
                                        <tr>
                                            <th>Código de comisión</th>
                                            <th>Código de Factura</th>
                                            <th>Código de vendedor</th>
                                            <th>Vendedor</th>
                                            <th>Ganancia de Factura x vendedor</th>
                                            <th>Procentaje Asignado</th>
                                            <th>Monto de ganancia asignado</th>
                                            <th>Usuario de Registro</th>
                                            <th>Fecha de Registro</th>
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
    </div>


 @push('scripts')
    <script>
        $( document ).ready(function() {

            $('#tbl_historico_comisones').DataTable({
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
                "ajax": "/historico/listar",
                "columns": [
                    {
                        data: 'codigoComision'
                    },
                    {
                        data: 'idFactura'
                    },
                    {
                        data: 'vendedor_id'
                    },
                    {
                        data: 'vendedor'
                    },
                    {
                        data: 'gananciaFactura'
                    },
                    {
                        data: 'porcentaje'
                    },
                    {
                        data: 'montoAsignado'
                    },
                    {
                        data: 'userRegistro'
                    },
                    {
                        data: 'fechaRegistro'
                    },
                    {
                        data: 'acciones'
                    }


                ]


            });
        });
    </script>
@endpush
</div>
