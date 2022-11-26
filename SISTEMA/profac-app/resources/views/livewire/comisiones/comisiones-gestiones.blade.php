<div>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Módulo de Comsiones</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Gestiones generales</a>
                </li>


            </ol>
        </div>

        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem">
                <a href="#" class="btn add-btn btn-primary" data-toggle="modal"
                    data-target="#modal_techo_crear"><i class="fa fa-plus"></i>Asignar techo de comisión</a>
            </div>
        </div>
{{--          <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem">
                <a href="#" class="btn add-btn btn-primary" data-toggle="modal"
                    data-target="#modal_techo_crear"><i class="fa fa-plus"></i>Otro boton</a>
            </div>
        </div>  --}}

        <!-- Modal para registro de techo-->
            <div class="modal fade" id="modal_techo_crear" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Registro de Techos de Comisiones</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="techoAddForm" name="techoAddForm" data-parsley-validate>
                                <Label>Nota: Al insertar un techo de comisión en ésta ventana, usted está asignando un techo general a <b>Todos</b> los colaboradores con rol de Vendedor. </Label>
                                <div class="row" id="row_datos">

                                    <div class="col-md-12">
                                        <label for="identidad_user" class="col-form-label focus-label">Ingrese un techo General de comisiones (ejemplo: 15000):<span class="text-danger">*</span></label>
                                        <input class="form-control" required type="number" min="0" id="techo" name="techo" data-parsley-required>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" form="techoAddForm" class="btn btn-primary">Guardar Techo</button>
                        </div>
                    </div>
                </div>
            </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <label for="" class="col-form-label focus-label"><b> Nota: Para filtros de techos de comision, se tomará en cuenta el último registrado </b></label>
       <br>
        <label for="" class="col-form-label focus-label"><b> Lista de techos de comisiones generales:</b></label>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_techos_guardados" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Mes de asignación</th>
                                        <th>Monto de techo</th>
                                        <th>Fecha registro</th>
                                        <th>User Registro</th>
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
    $(document).on('submit', '#techoAddForm', function(event) {
        event.preventDefault();
        guardarUsuario();
    });

        function guardarUsuario() {

            var data = new FormData($('#techoAddForm').get(0));

            axios.post("/techo/guardar", data)
                .then(response => {


                    $('#techoAddForm').parsley().reset();

                    document.getElementById("techoAddForm").reset();
                    $('#modal_techo_crear').modal('hide');

                    $('#tbl_techos_guardados').DataTable().ajax.reload();


                    Swal.fire({
                        icon: 'success',
                        title: 'Exito!',
                        text: "Techo agregado con Éxito."
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
            $('#tbl_techos_guardados').DataTable({
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
                "ajax": "/usuarios/listar/usuarios",
                "columns": [
                    {
                        data: 'contador'
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'telefono'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'identidad'
                    },
                    {
                        data: 'fecha_nacimiento'
                    },
                    {
                        data: 'tipo_usuario'
                    },
                    {
                        data: 'fecha_registro'
                    },

                ]


            });
        })
</script>

@endpush

