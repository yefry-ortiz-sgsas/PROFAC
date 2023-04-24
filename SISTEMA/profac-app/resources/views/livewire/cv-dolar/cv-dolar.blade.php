<div>
    @push('styles')
        <style>
            @media (max-width: 600px) {
                .ancho-imagen {
                    max-width: 200px;
                }
            }

            @media (min-width: 601px) and (max-width:900px) {
                .ancho-imagen {
                    max-width: 300px;
                }
            }

            @media (min-width: 901px) {
                .ancho-imagen {
                    max-width: 12rem;
                }
            }

            /* a {
                    pointer-events: none;
                } */
            .loader,
            .loader:before,
            .loader:after {
                border-radius: 50%;
            }

            .loader {
                color: #0dc5c1;
                font-size: 11px;
                text-indent: -99999em;
                margin: 55px auto;
                position: relative;
                width: 10em;
                height: 10em;
                box-shadow: inset 0 0 0 1em;
                -webkit-transform: translateZ(0);
                -ms-transform: translateZ(0);
                transform: translateZ(0);
            }

            .loader:before,
            .loader:after {
                position: absolute;
                content: '';
            }

            .loader:before {
                width: 5.2em;
                height: 10.2em;
                background: #ffffff;
                border-radius: 10.2em 0 0 10.2em;
                top: -0.1em;
                left: -0.1em;
                -webkit-transform-origin: 5.1em 5.1em;
                transform-origin: 5.1em 5.1em;
                -webkit-animation: load2 2s infinite ease 1.5s;
                animation: load2 2s infinite ease 1.5s;
            }

            .loader:after {
                width: 5.2em;
                height: 10.2em;
                background: #ffffff;
                border-radius: 0 10.2em 10.2em 0;
                top: -0.1em;
                left: 4.9em;
                -webkit-transform-origin: 0.1em 5.1em;
                transform-origin: 0.1em 5.1em;
                -webkit-animation: load2 2s infinite ease;
                animation: load2 2s infinite ease;
            }

            @-webkit-keyframes load2 {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframes load2 {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }
        </style>
    @endpush
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2> Conversiones </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Lista de conversiones</a>
                </li>
                <li class="breadcrumb-item">
                    <a data-toggle="modal" data-target="#modal_dolar_crear">Ingresar precio del dolar</a>
                </li>

            </ol>
        </div>


        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem">
                <a href="#" class="btn add-btn btn-primary" data-toggle="modal"
                    data-target="#modal_dolar_crear"><i class="fa fa-plus"></i>Ingresar precio del dolar</a>
            </div>

        </div>


    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_conversiones_listar" class="table table-striped table-bordered table-hover ">
                                <thead class="">
                                    <tr>
                                        <th>Cod</th>
                                        <th>Registrado Por</th>
                                        <th>Valor</th>
                                        <th>Fecha de registro</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>


                    </div>
                </div>
            </div>

            <!-- Modal para registro de Banco-->
            <div class="modal fade" id="modal_dolar_crear" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Registro de precio de Dólar</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="creardolarForm" name="creardolarForm" data-parsley-validate>
                                {{-- <input type="hidden" name="_token" value="{!! csrf_token() !!}"> --}}

                                <div class="row" id="row_datos">

                                    <div class="col-md-12">
                                        <label for="valor_dolar" class="col-form-label focus-label">Valor actuál del dolar:<span class="text-danger">*</span></label>
                                        <input class="form-control" required type="text" id="valor_dolar"
                                            name="valor_dolar" data-parsley-required>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" form="creardolarForm" class="btn btn-primary">Guardar
                                Banco</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <!-- Modal -->
        <div class="modal" id="modalSpinnerLoading" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="modalSpinnerLoadingTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h2 class="text-center">Espere un momento...</h2>
                        <div class="loader">Loading...</div>

                    </div>

                </div>
            </div>
        </div>






    </div>
    @push('scripts')
        <script>

         $(document).on('submit', '#creardolarForm', function(event) {
            event.preventDefault();
            guardarBanco();
        });

            function guardarBanco() {



                $('#modalSpinnerLoading').modal('show');

                //var data = new FormData($('#creardolarForm').get(0));
                var data = {
                    valor_dolar: document.getElementById("valor_dolar").value
                }

                axios.post("/conversion/dolar/guardar", data)
                    .then(response => {
                        console.log("entro al response");
                        $('#modalSpinnerLoading').modal('hide');


                        $('#creardolarForm').parsley().reset();

                        document.getElementById("creardolarForm").reset();
                        $('#modal_dolar_crear').modal('hide');

                        $('#tbl_conversiones_listar').DataTable().ajax.reload();


                        Swal.fire({
                            icon: 'success',
                            title: 'Exito!',
                            text: "Banco guardado con exito."
                        })

                    })
                    .catch(err => {

                        let data = err.response.data;
                        $('#modalSpinnerLoading').modal('hide');
                        $('#modal_dolar_crear').modal('hide');
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            text: data.text
                        })

                        console.log("entro al error");
                        console.error(err);

                    })

            }

            $(document).ready(function() {
                $('#tbl_conversiones_listar').DataTable({
                    "order": [0, 'desc'],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
                    pageLength: 10,
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [


                    ],
                    "ajax": "/conversion/dolar/listar",
                    "columns": [{
                            data: 'id'
                        },
                        {
                            data: 'user'
                        },
                        {
                            data: 'valor'
                        },
                        {
                            data: 'fechaRegistro'
                        }

                    ]


                });
            });


        </script>
    @endpush
</div>


