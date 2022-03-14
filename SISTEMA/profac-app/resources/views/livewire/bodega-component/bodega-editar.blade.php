<div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Lista de Bodegas</h2>
            <h4>Editar bodega</h4>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_bodegaEditar" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th># de Bodega</th>
                                        <th>Codigo</th>
                                        <th>Dirreción</th>
                                        <th>Encargado</th>
                                        <th>Estado</th>
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
        {{-- Care about people's approval and you will be their prisoner. --}}
     

        @push('scripts')

    
            <script>
                $(document).ready(function() {
                            $('#tbl_bodegaEditar').DataTable({
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
                                "ajax": "/bodega/listar/bodegas",
                                "columns": [
                                {data:'numero_bodega'},
                                {data:'codigo'},
                                {data:'direccion'},
                                {data:'encargado'},
                                {data:'estado_bodega'},
                                {data:'opciones'}
                                ]
                               

                            });
                })    
            </script>
        @endpush

    </div>
