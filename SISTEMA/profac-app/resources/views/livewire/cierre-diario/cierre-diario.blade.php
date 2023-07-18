<div>
    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>CIERRE DIARIO DE CAJA</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">/ CONSULTA DE FACTURAS</a>
                </li>


            </ol>
        </div>

    </div>


    <p> <b>Nota: </b> Se requiere de selección de fecha para mostrar la información.</p>

    <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">


                            <div class="col-6 col-sm-6 col-md-6 ">
                                <label for="fecha" class="col-form-label focus-label">Fecha a revisar:<span class="text-danger">*</span></label>
                                <input class="form-group form-control" type="date" id="fecha" name="fecha" value="{{date('Y-m-01')}}">
                            </div>

                        </div>
                        <button class="btn btn-primary" onclick="cargaConsulta()"><i class="fa-solid fa-paper-plane text-white"></i> Solicitar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <p> <b>Nota: </b> FACTURAS DE CONTADO.</p>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_contado" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>FECHA</th>
                                        <th>MES</th>
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>FECHA</th>
                                            <th>MES</th>
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>VENDENDOR</th>
                                            <th>SUBTOTAL</th>
                                            <th>IMPUESTO DE VENTA</th>
                                            <th>TOTAL</th>
                                            <th>TIPO</th>
                                        </tr>
                                    </tfoot>

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <p> <b>Nota: </b> FACTURAS DE CREDITO.</p>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_credito" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>FECHA</th>
                                        <th>MES</th>
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>FECHA</th>
                                            <th>MES</th>
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>VENDENDOR</th>
                                            <th>SUBTOTAL</th>
                                            <th>IMPUESTO DE VENTA</th>
                                            <th>TOTAL</th>
                                            <th>TIPO</th>
                                        </tr>
                                    </tfoot>

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <p> <b>Nota: </b> FACTURAS ANULADAS.</p>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_anuladas" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>FECHA</th>
                                        <th>MES</th>
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>FECHA</th>
                                        <th>MES</th>
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                    </tr>
                                </tfoot>
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

   {{--   function cargaConsulta(){

        $("#tbl_contado").dataTable().fnDestroy();
        $("#tbl_credito").dataTable().fnDestroy();
        $("#tbl_anuladas").dataTable().fnDestroy();

        var fecha = document.getElementById('fecha').value;

        $('#tbl_contado').DataTable({
            "order": ['0', 'desc'],
            "paging": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [

                {
                    extend: 'excel',
                    title: 'Facuracion_dia',
                    className:'btn btn-success'
                }
            ],
            "ajax": "/contado/"+fecha+",
            "columns": [
                {
                    data: 'fecha'
                },
                {
                    data: 'mes'
                },
                {
                    data: 'factura'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'vendedor'
                },
                {
                    data: 'subtotal'
                },

                {
                    data: 'imp_venta'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tipo'
                },
            ]


        });


    }  --}}



    function cargaConsulta(){

        $("#tbl_contado").dataTable().fnDestroy();
        $("#tbl_credito").dataTable().fnDestroy();
        $("#tbl_anuladas").dataTable().fnDestroy();

        var fecha = document.getElementById('fecha').value;

        $('#tbl_contado').DataTable({
            "order": ['0', 'desc'],
            "paging": true,
            "language": {
                "url": "//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"
            },
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [

                {
                    extend: 'excel',
                    title: 'Facuracion_dia',
                    className:'btn btn-success'
                }
            ],
            "ajax": "/contado/"+fecha,
            "columns": [
                {
                    data: 'fecha'
                },
                {
                    data: 'mes'
                },
                {
                    data: 'factura'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'vendedor'
                },
                {
                    data: 'subtotal'
                },

                {
                    data: 'imp_venta'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tipo'
                },
            ],initComplete: function () {
                var r = $('#tbl_contado tfoot tr');
                r.find('th').each(function(){
                  $(this).css('padding', 8);
                });
                $('#tbl_contado thead').append(r);
                $('#search_0').css('text-align', 'center');
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            }


        });

        $('#tbl_credito').DataTable({
            "order": ['0', 'desc'],
            "paging": true,
            "language": {
                "url": "//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"
            },
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [

                {
                    extend: 'excel',
                    title: 'Facuracion_dia',
                    className:'btn btn-success'
                }
            ],
            "ajax": "/credito/"+fecha,
            "columns": [
                {
                    data: 'fecha'
                },
                {
                    data: 'mes'
                },
                {
                    data: 'factura'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'vendedor'
                },
                {
                    data: 'subtotal'
                },

                {
                    data: 'imp_venta'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tipo'
                },
            ],initComplete: function () {
                var r = $('#tbl_credito tfoot tr');
                r.find('th').each(function(){
                  $(this).css('padding', 8);
                });
                $('#tbl_credito thead').append(r);
                $('#search_0').css('text-align', 'center');
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            }


        });

        $('#tbl_anuladas').DataTable({
            "order": ['0', 'desc'],
            "paging": true,
            "language": {
                "url": "//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"
            },
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [

                {
                    extend: 'excel',
                    title: 'Facuracion_dia',
                    className:'btn btn-success'
                }
            ],
            "ajax": "/anuladas/"+fecha,
            "columns": [
                {
                    data: 'fecha'
                },
                {
                    data: 'mes'
                },
                {
                    data: 'factura'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'vendedor'
                },
                {
                    data: 'subtotal'
                },

                {
                    data: 'imp_venta'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tipo'
                },
            ],initComplete: function () {
                var r = $('#tbl_anuladas tfoot tr');
                r.find('th').each(function(){
                  $(this).css('padding', 8);
                });
                $('#tbl_anuladas thead').append(r);
                $('#search_0').css('text-align', 'center');
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            }


        });
    }
</script>

@endpush


