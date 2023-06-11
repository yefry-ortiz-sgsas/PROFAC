<div>


    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Retenciones</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Lista</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Edicion</a>
                </li>

            </ol>
        </div>

        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem">
                <a href="#" class="btn add-btn btn-primary" data-toggle="modal" data-target="#modal_retenciones_crear"><i
                        class="fa fa-plus"></i> Agregar Retencion</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_retenciones" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Valor</th>
                                        <th>Tipo de Retencion</th>
                                        <th>Registrado por:</th>
                                        <th>Fecha de registro</th>
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

            <!----MODAL PARA CREAR RETENCIONES---->
    <div id="modal_retenciones_crear" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success">Regitro de Retenciones</h5>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="retencionCreacionForm" name="retencionCreacionForm" data-parsley-validate>

                        <div class="row" id="row_datos">
                            <div class="col-md-12">
                                <label for="nombre_retencion" class="col-form-label focus-label">Descripción:</label>
                                <input class="form-control" required type="text" id="nombre_retencion" name="nombre_retencion"
                                    data-parsley-required>
                            </div>
                            <div class="col-md-12">
                                <label for="valor_retencion" class="col-form-label focus-label">Valor:</label>
                                <input class="form-control" required type="text" id="valor_retencion" name="valor_retencion"
                                    data-parsley-required>
                            </div>

                            <div class="col-md-12">
                                <label for="tipo_retencion" class="col-form-label focus-label">Tipo de Retencion</label>
                                <select class="form-group form-control" name="tipo_retencion" id="tipo_retencion">
                                    <option selected disabled>---Seleccione un tipo---</option>
                                    @foreach ($listaRetenciones as $retencion)
                                    <option value="{{ $retencion->id }}">{{ $retencion->nombre }}</option>
                                    @endforeach



                                </select>
                            </div>

                        </div>
                    </form>
                    <button class="btn btn-sm btn-primary float-left m-t-n-xs"
                        form="retencionCreacionForm"><strong>Crear
                            Retencion</strong></button>
                </div>

            </div>
        </div>
    </div>




    <!----MODAL PARA EDITAR RETENCIONES---->
    <div id="modal_retenciones_editar" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success">Edición de Retenciones</h5>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="retencionEdicionForm" name="retencionCreacionForm" data-parsley-validate>

                        <div class="row" id="row_datos">
                            <div class="col-md-12">
                                <label for="nombre_retencion" class="col-form-label focus-label">Descripción:</label>
                                <input class="form-control" required type="text" id="nombre_retencion_edit" name="nombre_retencion_edit"
                                    data-parsley-required>
                                    <input required type="hidden" id="id_retencion_edit" name="id_retencion_edit">
                            </div>
                            <div class="col-md-12">
                                <label for="valor_retencion" class="col-form-label focus-label">Valor:</label>
                                <input class="form-control" required type="text" id="valor_retencion_edit" name="valor_retencion_edit"
                                    data-parsley-required>
                            </div>

                            <div class="col-md-12">
                                <label for="tipo_retencion" class="col-form-label focus-label">Tipo de Retencion</label>
                                <select class="form-group form-control" name="tipo_retencion_edit" id="tipo_retencion_edit">
                                    <option selected id="tiporetene" name="tiporetene"></option>
                                    @foreach ($listaRetenciones as $retencion)
                                    <option value="{{ $retencion->id }}">{{ $retencion->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </form>
                    <button class="btn btn-sm btn-primary float-left m-t-n-xs"
                        form="retencionEdicionForm"><strong>Crear
                            Retencion</strong></button>
                </div>

            </div>
        </div>
    </div>

    </div>




    @push('scripts')

    <script>

        $(document).ready(function() {
            console.log("entro")
            $('#tbl_retenciones').DataTable({
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
                "ajax": "/inventario/retenciones/listar",
                "columns": [
                    {
                        data: 'codigo'
                    },
                    {
                        data: 'descripcion'
                    },
                    {
                        data: 'valor'
                    },
                    {
                        data: 'tipo'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'fecha'
                    },
                    {
                        data: 'opciones'
                    },


                ]


            });
        })

        $(document).on('submit', '#retencionCreacionForm', function(event) {

            event.preventDefault();
            crear_Retencion();

            });

        function  crear_Retencion(){
            var data = new FormData($('#retencionCreacionForm').get(0));

            axios.post("/proveedores/retencion/crear", data)
            .then( response =>{
                document.getElementById("retencionCreacionForm").reset();
                    $('#modal_retenciones_crear').modal('hide');


                    Swal.fire({
                        icon: 'success',
                        title: 'Exito!',
                        text: "Retencion creada con exito."
                    })

                    $('#tbl_retenciones').DataTable().ajax.reload();

            })
        }


        function mostrarModalEditar(id){

            let data = {"id":id};

            axios.post('/retencion/obtener',data)
            .then( response=>{

                console.log(response.data.retencion);

                let retencion = response.data.retencion;

                document.getElementById("id_retencion_edit").value = retencion.id;
                document.getElementById("nombre_retencion_edit").value = retencion.nombre;
                document.getElementById("valor_retencion_edit").value = retencion.valor;
                document.getElementById("tipo_retencion_edit").value = retencion.tipoRetenID;

                document.getElementById("tipo_retencion_edit").innerHTL = retencion.tipoReten;


                $("#modal_retenciones_editar").modal("show");

                return;
            })
            .catch(err=>{

                console.log(err)

            });


        }

        $(document).on('submit', '#retencionEdicionForm', function(event) {

            event.preventDefault();
            editar_Retencion();

        });

        function  editar_Retencion(){
            var data = new FormData($('#retencionEdicionForm').get(0));

            axios.post("/retencion/editar", data)
            .then( response =>{
                document.getElementById("retencionEdicionForm").reset();
                    $('#modal_retenciones_editar').modal('hide');


                    Swal.fire({
                        icon: 'success',
                        title: 'Exito!',
                        text: "Retencion Editada con exito."
                    })
                    document.getElementById('retencionEdicionForm').reset();
                    $('#tbl_retenciones').DataTable().ajax.reload();

            })
        }

        function eliminarRetencion(id) {


            Swal.fire({
                title: '¿Esta seguro de Eliminar esta retención?',
                text: "¡Si si lo elimina, ya no podrá disponer de la retención con estas características, tendrá que crear una nueva.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, Eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {


                    axios.post('/retencion/eliminar', {
                            "id": id
                        })
                        .then(function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Exito!',
                                text: "Retencion eliminada con exito."
                            })

                            $('#tbl_retenciones').DataTable().ajax.reload();

                        })
                        .catch(function(error) {
                            // handle error
                            console.log(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: "Ha ocurrido un error al eliminar retención"
                            })
                        })





                }
            })


        }



    </script>
    @endpush
</div>
