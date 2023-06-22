<div>
    @push('styles')
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2> Comprobantes De Entrega </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a>Activos</a>
                </li>
                <li class="breadcrumb-item active">
                    <a>Listado</a>
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
                            <table id="tbl_listar_comprobantes" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        
                                        <th>N° Comprobante</th>
                                        <th>Cliente</th>
                                        <th>RTN</th>
                                        <th>Fecha de Emision</th>
                                        <th>Sub Total Lps.</th>
                                        <th>ISV en Lps.</th>
                                        <th>Total en Lps.</th>
                                        <th>Estado</th>
                                        <th>Registrado Por:</th>
                                        <th>Fecha de registro</th>
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
            $('#tbl_listar_comprobantes').DataTable({
                "order": [3, 'desc'],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "order": [3, 'desc'],
                pageLength: 10,
                responsive: true,
              

                "ajax": "/comprovante/entrega/listado/activos",
                "columns": [
                    {
                        data: 'numero_comprovante'
                    },
                    {
                        data: 'nombre_cliente'
                    },
                    {
                        data: 'RTN'
                    },
                    {
                        data: 'fecha_emision'
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
                        data:'estado'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data:'fecha_creacion'
                    },
   
                    {
                        data: 'opciones'
                    }
  
                ]


            });
            })




        function anularComprobante(idComprobante){
                   axios.get('/comprobante/entrega/anular/'+idComprobante)
                   .then(response=>{
                    let data = response.data;
                        Swal.fire({
                                    icon: data.icon,
                                    title: data.title,
                                    html: data.text,
                                });
                                $('#tbl_listar_comprobantes').DataTable().ajax.reload();             
                   })
                   .catch(err=>{
                    Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Ha ocurrido un error al anular el comprobante.',
                        })
                   })
            }
        </script>
    @endpush
</div>

