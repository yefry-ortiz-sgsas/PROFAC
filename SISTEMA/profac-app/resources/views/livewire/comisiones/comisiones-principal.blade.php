<div>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Módulo de Comsiones</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Gestiones de búsqueda</a>
                </li>


            </ol>
        </div>

            {{--          <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem">
                <a href="#" class="btn add-btn btn-primary" data-toggle="modal"
                    data-target="#modal_usuario_crear"><i class="fa fa-plus"></i>Asignar Comisión</a>
            </div>
        </div>  --}}


    </div>

    <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">


                            <div class="col-6 col-sm-6 col-md-6 ">
                                <label for="seleccionar" class="col-form-label focus-label">Seleccionar mes para revisión de facturas:<span class="text-danger">*</span></label>
                                <select id="mes" name="mes" class="form-group form-control" style=""
                                    data-parsley-required >
                                    <option value="" selected disabled>--Seleccione--</option>
                                        <option value="01">ENERO</option>
                                        <option value="02">FEBRERO</option>
                                        <option value="03">MARZO</option>
                                        <option value="04">ABRIL</option>
                                        <option value="05">MAYO</option>
                                        <option value="06">JUNIO</option>
                                        <option value="07">JULIO</option>
                                        <option value="08">AGOSTO</option>
                                        <option value="09">SEPTIEMBRE</option>
                                        <option value="10">OCTUBRE</option>
                                        <option value="11">NOVIEMBRE</option>
                                        <option value="12">DICIEMBRE</option>
                                </select>
                            </div>

                            <div class="col-6 col-sm-6 col-md-6">
                                <label for="seleccionar" class="col-form-label focus-label">Seleccionar Vendedor a comisionar:<span class="text-danger">*</span></label>
                                <select id="vendedorSelect" name="vendedorSelect" class="form-group form-control" style=""
                                    data-parsley-required >
                                    <option value="" selected disabled>--Seleccione--</option>
                                </select>
                            </div>

                        </div>
                        <button class="btn btn-primary btn-block" onclick="buscarFacturas()"><i class="fa-solid fa-paper-plane text-white"></i> Solicitar</button>
                    </div>
                </div>
            </div>
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




</div>
@push('scripts')

<script>

    obtenerVendedor();

    function obtenerVendedor(){
        $('#vendedorSelect').select2({
            ajax:{
                url:'/ventas/corporativo/vendedores',
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'public',
                        page: params.page || 1
                    }

                    return query;
                }

            }
        });
    }


    function buscarFacturas(){
        var mes = document.getElementById('mes').value;
        var idVendedor = document.getElementById('vendedorSelect').value;
                $("#tbl_facturasVendedor_cerradas").dataTable().fnDestroy();
                $("#tbl_facturasVendedor_sinCerrar").dataTable().fnDestroy();

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
                    "ajax": "/comisiones/facturas/buscar/"+mes+"/"+idVendedor,
                    "columns": [


                        {
                            data: 'id'
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
                    "ajax": "/comisiones/facturas/buscar2/"+mes+"/"+idVendedor,
                    "columns": [


                        {
                            data: 'id'
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



    }


</script>

@endpush
