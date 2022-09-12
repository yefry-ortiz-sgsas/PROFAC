<div>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Historico de Precios</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Listar</a>
                </li>


            </ol>
        </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">


                            <div class="col-6 col-sm-6 col-md-6 ">
                                <label for="cliente" class="col-form-label focus-label">Seleccionar Cliente:<span class="text-danger">*</span></label>
                                <select id="cliente" name="cliente" class="form-group form-control" style=""
                                    data-parsley-required >
                                    <option value="" selected disabled>--Seleccionar un Cliente--</option>
                                </select>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 ">
                                <label for="producto" class="col-form-label focus-label">Seleccionar Producto:<span class="text-danger">*</span></label>
                                <select id="producto" name="producto" class="form-group form-control" style=""
                                    data-parsley-required >
                                    <option value="" selected disabled>--Seleccionar un Producto--</option>
                                </select>
                            </div>


                        </div>
                        <button class="btn btn-primary" onclick="listarHistorico()"><i class="fa-solid fa-paper-plane text-white"></i> Solicitar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_historico_precios" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Numero Factura</th>
                                        <th>CAI</th>
                                        <th>Fecha Emision</th>
                                        <th>Cliente</th>
                                        <th>Producto</th>
                                        <th>Descripcion</th>
                                        <th>Unidad Medida</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unidad</th>
                                        <th>Sub-Total</th>
                                        <th>ISV</th>
                                        <th>Total</th>
                                        <th>Opciones</th>
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

    
     
         $('#cliente').select2({
             ajax: {
                 url: '/ventas/historico_precios/clientes',
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

         $('#producto').select2({
            ajax: {
                url: '/ventas/historico_precios_cliente/productos',
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
        
        $(document).ready(function() {

     })


    // function listarProductos() {
    //     $('#producto').select2({
    //         ajax: {
    //             url: '/ventas/historico_precios_cliente/productos',
    //             data: function(params) {
    //                 var query = {
    //                     search: params.term,
    //                     type: 'public',
    //                     page: params.page || 1
    //                 }

                    
    //                 return query;
    //             }
    //         }
    //     });
    // }

    function listarHistorico() {

        var idCliente = document.getElementById('cliente').value;
        var idProducto = document.getElementById('producto').value;

        $('#tbl_historico_precios').DataTable({
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
                    "ajax": "/ventas/historico_precios_cliente/"+idCliente"/"+idProducto,
                    "columns": [{
                            data: 'numero_factura'
                        },
                        {
                            data: 'cai'
                        },
                        {
                            data: 'fecha_emision'
                        },
                        {
                            data: 'nombre_cliente'
                        },
                        {
                            data: 'producto'
                        },                        
                        {
                            data: 'descripcion'
                        },
                        {
                            data: 'unidad_medida'
                        },
                        {
                            data: 'cantidad'
                        },
                        {
                            data: 'precio_unidad'
                        },
                        {
                            data: 'sub_total'
                        },
                        {
                            data: 'isv'
                        },
                        {
                            data: 'total'
                        },
                        {
                            data: 'opciones'
                        }

                    ]


                });
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>

@endpush