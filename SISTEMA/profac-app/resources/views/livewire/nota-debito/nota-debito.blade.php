<div>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Nota de Débito</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Lista</a>
                </li>


            </ol>
        </div>



        <!-- Modal para registro de Banco-->
            <div class="modal fade" id="modal_usuario_crear" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Registro de Usuarios</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="userAddForm" name="userAddForm" data-parsley-validate>
                                <div class="row" id="row_datos">

                                    <div class="col-md-12">
                                        <label for="identidad_user" class="col-form-label focus-label">Número de Identidad:<span class="text-danger">*</span></label>
                                        <input class="form-control" required type="text" id="identidad_user" name="identidad_user" data-parsley-required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="nombre_usuario" class="col-form-label focus-label">Nombre de Usuario:<span class="text-danger">*</span></label>
                                        <input class="form-control" required type="text" id="nombre_usuario" name="nombre_usuario" data-parsley-required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="email_user" class="col-form-label focus-label">Correo Institucional:<span class="text-danger">*</span></label>
                                        <input class="form-control" required type="mail" id="email_user" name="email_user" data-parsley-required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="pass_user" class="col-form-label focus-label">Contraseña:<span class="text-danger">*</span></label>
                                        <input class="form-control" required type="text" id="pass_user" name="pass_user" data-parsley-required>
                                    </div>



                                    <div class="col-md-12">
                                        <label for="rol_user" class="col-form-label focus-label">Seleccionar Rol de acceso:<span class="text-danger">*</span></label>
                                        <select class="form-select form-control" name="rol_user" id="rol_user" required data-parsley-required>
                                            <option value="1">Administrador</option>
                                            <option value="5">Auxiliar Administrativo</option>
                                            <option value="2">Vendedor</option>
                                            <option value="3">Facturador</option>
                                            <option value="4">Auxiliar de Contabilidad</option>
                                        </select>
                                    </div>


                                </div>
                            </form>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" form="userAddForm" class="btn btn-primary">Guardar Usuario</button>
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
                            <table id="tbl_listar_compras" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>

                                        <th>N° Factura</th>
                                        <th>Correlativo</th>
                                        <th>CAI</th>
                                        <th>Fecha de Emision</th>
                                        <th>Cliente</th>
                                        <th>Tipo de Pago</th>
                                        <th>Fecha de Vencimiento</th>
                                        <th>Sub Total Lps.</th>
                                        <th>ISV en Lps.</th>
                                        <th>Total en Lps.</th>
                                        <th>Esto de Cobro</th>
                                        <th>Vendedor</th>
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
    <br>
    <hr>
    <br>

    <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
        <div style="margin-top: 1.5rem">
            <a href="#" class="btn add-btn btn-primary" data-toggle="modal"
                data-target="#modal_monto_crear"><i class="fa fa-plus"></i>Registrar Usuarios</a>
        </div>
    </div>




</div>
@push('scripts')

<script>
    $(document).on('submit', '#userAddForm', function(event) {
        event.preventDefault();
        guardarUsuario();
    });

        function guardarUsuario() {
            $('#modalSpinnerLoading').modal('show');

            var data = new FormData($('#userAddForm').get(0));

            axios.post("/usuario/guardar", data)
                .then(response => {


                    $('#userAddForm').parsley().reset();

                    document.getElementById("userAddForm").reset();
                    $('#modal_usuario_crear').modal('hide');

                    $('#tbl_usuariosListar').DataTable().ajax.reload();


                    Swal.fire({
                        icon: 'success',
                        title: 'Exito!',
                        text: "Usuario Creado con exito."
                    })

                })
                .catch(err => {
                    let data = err.response.data;
                    $('#modal_usuario_crear').modal('hide');
                    Swal.fire({
                        icon: data.icon,
                        title: data.title,
                        text: data.text
                    })
                    console.error(err);

                })

        }


        $(document).ready(function() {
            $('#tbl_listar_compras').DataTable({
                "order": [3, 'desc'],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "order": [3, 'desc'],
                pageLength: 10,
                responsive: true,


                "ajax": "/debito/lista/facturas",
                "columns": [
                    {
                        data: 'numero_factura'
                    },
                    {
                        data: 'correlativo'
                    },
                    {
                        data: 'cai'
                    },
                    {
                        data: 'fecha_emision'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'descripcion'
                    },
                    {
                        data: 'fecha_vencimiento'
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
                        data: 'estado_cobro'
                    },
                    {
                        data: 'creado_por'
                    },

                    {
                        data: 'opciones'
                    }

                ]


            });
            })

</script>

@endpush

