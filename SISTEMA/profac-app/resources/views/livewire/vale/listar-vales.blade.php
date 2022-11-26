<div>
    @push('styles')
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Listado De Vales </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a>Imprimir</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Facturar</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_listar_compras" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>

                                        <th>N°</th>
                                        <th>N° Vale</th>
                                        <th>Cliente</th>
                                        <th>RTN</th>
                                        <th>N° Factura</th>
                                        <th>Sub Total</th>
                                        <th>ISV</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Registrado Por</th>
                                        <th>Fecha</th>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tbl_listar_compras').DataTable({
                    "order": [0, 'desc'],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
                    pageLength: 10,
                    responsive: true,


                    "ajax": "/vale/listado/general",
                    "columns": [{
                            data: 'contador'
                        },
                        {
                            data: 'numero_vale'
                        },
                        {
                            data: 'nombre_cliente'
                        },
                        {
                            data: 'rtn'
                        },
                        {
                            data: 'numero_factura'
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
                            data: 'estado_entrega'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'opciones'
                        },

                    ]


                });
            })

            function anularVentaConfirmar(idFactura) {

                Swal.fire({
                    title: '¿Está seguro de anular esta factura?',


                    // --------------^-- define html element with id
                    html: '<p>Una vez que ha sido anulada la factura el producto registrado en la misma sera devuelto al inventario.</p> <textarea rows="4" placeholder="Es obligatorio describir el motivo." required id="comentario"     class="form-group form-control" data-parsley-required></textarea>',
                    showDenyButton: false,
                    showCancelButton: false,
                    showDenyButton: true,
                    confirmButtonText: 'Si, Anular Factura',
                    denyButtonText: `Cancelar`,
                    confirmButtonColor: '#19A689',
                    denyButtonColor: '#676A6C',
                }).then((result) => {

                    let motivo = document.getElementById("comentario").value

                    if (result.isConfirmed && motivo) {


                        anularVenta(idFactura, motivo);

                    } else if (result.isDenied) {
                        Swal.close()
                    } else {
                        Swal.close()
                    }
                })
            }

            function anularVenta(idFactura, motivo) {

                axios.post("/factura/corporativo/anular", {
                        'idFactura': idFactura,
                        'motivo': motivo
                    })
                    .then(response => {


                        let data = response.data;
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            html: data.text,
                        });
                        $('#tbl_listar_compras').DataTable().ajax.reload();

                    })
                    .catch(err => {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Ha ocurrido un error al anular la compra.',
                        })

                    })

            }

            function anularValeMensaje(idVale) {
                Swal.fire({
                    title: '¿Está seguro de anular este vale de entrega?',



                    html: '<p>Una vez que ha sido anulado este vale, el producto registrado dejara de reflejarse en cardex como vale y se registrara su salida de bodega en la factura correspondiente.</p> <textarea rows="4" placeholder="Es obligatorio describir el motivo." required id="comentarioAnular"     class="form-group form-control" data-parsley-required></textarea>',
                    showDenyButton: false,
                    showCancelButton: false,
                    showDenyButton: true,
                    confirmButtonText: 'Si, Anular Vale',
                    denyButtonText: `Cancelar`,
                    confirmButtonColor: '#19A689',
                    denyButtonColor: '#676A6C',
                }).then((result) => {

                    let motivo = document.getElementById("comentarioAnular").value

                    if (result.isConfirmed && motivo) {


                        anularVale(idVale, motivo);

                    } else if (result.isDenied) {
                        Swal.close()
                    } else {
                        Swal.close()
                    }
                })
            }

            function anularVale(idVale, motivo) {

                axios.post("/anular/vale", {
                        'idVale': idVale,
                        'motivo': motivo
                    })
                    .then(response => {


                        let data = response.data;
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            html: data.text,
                        });
                        $('#tbl_listar_compras').DataTable().ajax.reload();

                    })
                    .catch(err => {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Ha ocurrido un error al anular la compra.',
                        })

                    })

            }


            function eliminarValeMensaje(idVale) {
                Swal.fire({
                    title: '¿Está seguro de eliminar este vale de entrega?',



                    html: '<p>Una vez que ha sido eliminado, el producto registrado dejara de reflejar su salida como vale y se registrara en la factura correspondiente. Adiferencia de anular, al eliminar el vale el producto vuleve a estar disponible para realizar nuevamente el vale</p> <textarea rows="4" placeholder="Es obligatorio describir el motivo." required id="comentarioEliminar"     class="form-group form-control" data-parsley-required></textarea>',
                    showDenyButton: false,
                    showCancelButton: false,
                    showDenyButton: true,
                    confirmButtonText: 'Si, Eliminar Vale',
                    denyButtonText: `Cancelar`,
                    confirmButtonColor: '#19A689',
                    denyButtonColor: '#676A6C',
                }).then((result) => {

                    let motivo = document.getElementById("comentarioEliminar").value

                    if (result.isConfirmed && motivo) {


                        eliminarVale(idVale, motivo);

                    } else if (result.isDenied) {
                        Swal.close()
                    } else {
                        Swal.close()
                    }
                })
            }

            function eliminarVale(idVale, motivo) {

                axios.post("/eliminar/vale", {
                        'idVale': idVale,
                        'motivo': motivo
                    })
                    .then(response => {


                        let data = response.data;
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            html: data.text,
                        });
                        $('#tbl_listar_compras').DataTable().ajax.reload();

                    })
                    .catch(err => {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Ha ocurrido un error al eliminar el vale.',
                        })

                    })

            }
        </script>
    @endpush
</div>
