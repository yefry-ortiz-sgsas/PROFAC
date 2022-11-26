<div>
    @push('styles')
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Listado de Vales</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a>Listado</a>
                </li>

                <li class="breadcrumb-item">
                    <a>Detalle de Vale</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Restar producto al inventario</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Eliminar Vale</a>
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
                            <table id="tbl_listar_vales" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Vale</th>
                                        <th>Factura</th>
                                        <th>Cliente</th>
                                        <th>Sub total</th>
                                        <th>ISV</th>
                                        <th>Total</th>
                                        <th>Estado</th>                                   
                                        <th>Registrado por</th>
                                        <th>Fecha de Registro</th>                                     
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

    <!-- Modal para Elegir Mes a Exportar-->
    <div class="modal fade" id="modal_exportar_excel" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Exportar Mes a Excel</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="exportarExcelForm" name="exportarExcelForm" data-parsley-validate>
                        {{-- <input type="hidden" name="_token" value="{!! csrf_token() !!}"> --}}
                        
                        <div class="row" id="row_datos">
                            
                            <div class="col-md-12">
                                <label for="compras_mes" class="col-form-label focus-label">Seleccione el Mes:<span class="text-danger">*</span></label>
                                <input required type="month" id="compras_mes" name="compras_mes"  data-parsley-required onchange="insertarBotonExportar()"> 
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center mt-2" id="exportar">
                                <!--///////////////////////Aqui se insertará el boton cuando se selecione un Mes///////////////////-->
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <!--<button type="button" form="exportarExcelForm" class="btn btn-primary excel_compras_mes">Exportar
                        Excel</button>-->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
            $('#tbl_listar_vales').DataTable({
                "order": [8, 'desc'],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                
                pageLength: 10,
                responsive: true,
              

                "ajax": "/vale/restar/lista",
                "columns": [
                    {
                        data: 'numero_vale'
                    },
                    {
                        data: 'numero_factura'
                    },
                    {
                        data: 'nombre_cliente'
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
                        data: 'estado'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'created_at'
                    },

                    {
                        data: 'opciones'
                    }
  
                ]


            });
            })

        function anularVale(idVale){
             
            Swal.fire({
            title: '¿Está seguro de anular este vale?',
            text:'Una vez sea anulado el vale, el producto listado en el mismo será restado del inventario automaticamente.',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Si, Anular vale', 
            confirmButtonColor:'#18A689',           
            cancelButtonText: `Cancelar`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                //Swal.fire('Saved!', '', 'success')
                this.anularValeGuardar(idVale);

            } 
            })
        }

        function anularValeGuardar(idVale){

            axios.post("/vale/restar/lista/anular", {idVale:idVale})
            .then( response =>{


                let data = response.data;
                Swal.fire({
                            confirmButtonColor:'#18A689', 
                            icon: data.icon,
                            title: data.title,
                            html: data.text,
                        });
                        $('#tbl_listar_vales').DataTable().ajax.reload();        

            })
            .catch( err => {

                Swal.fire({
                            confirmButtonColor:'#18A689', 
                            icon: 'error',
                            title: 'Error!',
                            html: 'Ha ocurrido un error al anular el vale.',
                        })

            })

        }

        function eliminarVale(idVale){
            Swal.fire({
                    title: '¿Está seguro de eliminar este vale?',
                    html: '<p>Una vez que se elimina el vale, el producto listado en el mismo será removido de la factura asignada a este vale.</p> <textarea rows="4" placeholder="Es obligatorio describir el motivo." required id="comentarioEliminar"     class="form-group form-control" data-parsley-required></textarea>',
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


                        eliminarValeGuardar(idVale, motivo);

                    } else if (result.isDenied) {
                        Swal.close()
                    } else {
                        Swal.close()
                    }
                })
        }

        function eliminarValeGuardar(idVale, motivo){
                axios.post('/vale/restar/lista/eliminar',{idVale:idVale, motivo:motivo})
                .then(response=>{
                    let data = response.data;
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            html: data.text,
                        });
                        $('#tbl_listar_vales').DataTable().ajax.reload();
                })
                .catch( err =>{
                    Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Ha ocurrido un error al eliminar el vale.',
                        })

                    })
              
        }

        function insertarBotonExportar(){
            
            try {
                var compras_mes = document.getElementById('compras_mes').value;

                let htmlSelect = ''
                
                htmlSelect =   ` 
                        <a href="/compras/excel_mes/${compras_mes}" class="btn add-btn btn-primary"><i class="fa fa-plus "></i> Exportar Excel</a>
                                `

                document.getElementById('exportar').innerHTML = htmlSelect;
                
            } catch (error) {
                
            }

        }

        </script>
    @endpush
</div>
