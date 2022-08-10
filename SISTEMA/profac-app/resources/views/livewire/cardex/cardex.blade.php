<div>
    @push('styles')



    <style>
        @media (max-width: 600px) {
            .ancho-imagen {
                max-width: 200px;
            }
            }

         @media (min-width: 601px ) and (max-width:900px){
            .ancho-imagen {
                max-width: 300px;
            }
            }

            @media (min-width: 901px) {
            .ancho-imagen {
                max-width: 300px;
            }
            }
      </style>

    @endpush

<div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
    <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
        <h2>Cardex</h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Lista</a>
            </li>
            <li class="breadcrumb-item">
                <a>Cardex</a>
            </li>

        </ol>
    </div>

    <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
        <div style="margin-top: 1.5rem">
            <a href="#" class="btn add-btn btn-success" data-toggle="modal" data-target="#modal_clientes_crear"><i
                    class="fa fa-plus"></i> Registrar Cliente</a>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="tbl_usuariosListar" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Correo</th>
                                        <th>Identidad</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>tipo</th>
                                        <th>Fecha Ingreso</th>

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
            $(document).ready(function() {
            $('#tbl_usuariosListar').DataTable({
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
