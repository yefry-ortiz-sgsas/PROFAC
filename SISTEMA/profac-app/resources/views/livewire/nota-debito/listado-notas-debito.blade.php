<div>
    @push('styles')

    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Notas de debito Clientes <b>A</b></h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a>Listado </a>
                        </li>


                    </ol>
                </div>


            </div>


        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3>Seleccionar Rango de Fechas</h3>
                    </div>
                    <div class="ibox-content ">

                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="_venta" class="col-form-label focus-label">Fecha de inicio</label>
                                <input id="fechaInicio" type="date" value="{{ $fechaInicio }}" class="form-group form-control">
                            </div>

                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="_venta" class="col-form-label focus-label">Fecha Final</label>
                                <input id="fechaFinal" type="date" value="{{ date('Y-m-t') }}" class="form-group form-control">
                            </div>


                        </div>
                        <div>
                            <button onclick="listarNotasDebito()" class="btn btn-primary mt-3"><i
                                    class="fa-solid fa-arrow-rotate-right"></i> Solicitar</button>
                        </div>
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
                            <table id="tbl_listar_notas_debito" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>

                                        <th>#</th>
                                        <th>Nota de débito</th>
                                        <th>Monto Asignado</th>
                                        <th>Código de Factura</th>
                                        <th>Cliente</th>
                                        <th>Fecha de Emisión</th>

                                        <th>Registrado por</th>
                                        <th>Estado</th>
                                        <th>Documento</th>
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
    </div>





    @push('scripts')
        <script>
            listarNotasDebito();
            function listarNotasDebito(){

                let fechaInicio = document.getElementById("fechaInicio").value;
                let fechaFinal = document.getElementById("fechaFinal").value;

                $('#tbl_listar_notas_debito').DataTable().clear().destroy();


                $('#tbl_listar_notas_debito').DataTable({
                "order": [3, 'desc'],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "order": [0, 'desc'],
                pageLength: 10,
                responsive: true,


                "ajax": "/listado/nota/debito/corporativo/"+fechaInicio+"/"+fechaFinal,
                "columns": [
                    {
                        data: 'id'
                    },
                    {
                        data: 'correlativoND'
                    },
                    {
                        data: 'monto_asignado'
                    },
                    {
                        data: 'cai'
                    },

                    {
                        data: 'cliente'
                    },
                    {
                        data: 'fechaEmision'
                    },

                    {
                        data: 'user'
                    },
                    {
                        data: 'estado'
                    },
                    {
                        data: 'file'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'acciones'
                    }

                ]


            });
            }
            function anularnd(idNota){

                axios.get("/debito/anular/"+idNota)
                    .then(response => {


                        $('#tbl_listar_notas_debito').DataTable().ajax.reload();


                        Swal.fire({
                            icon: 'success',
                            title: 'Exito!',
                            text: "Anulado con exito."
                        })

                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                            icon: 'error',
                            text: "Hubo un error al anular nota de débito."
                        })

                })

            }
        </script>
    @endpush
</div>
