<div>
    @push('styles')
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Listado De Facturas </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a>Coorporativo</a>
                </li>

                <li class="breadcrumb-item">
                    <a>Estatal</a>
                </li>
               
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div>
                          
                                <button type="button" onclick="obtenerArrar()" class="btn btn-w-m btn-warning ">Monto mayor</button>                              
                                <button type="button" class="btn btn-w-m btn-success ">Monto menor</button>
                        </div>
                        <div class="table-responsive">
                            <table id="tbl_lista_ventas" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                      
                                        <th>N° Factura</th>
                                        <th>D/C</th>
                                        <th>N/D</th>
                                        <th>Opciones</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   

                                </tbody>
                            </table>

                        </div>
                        <div>
                            <button type="button" class="btn btn-w-m btn-primary">Guardar</button>
                            <p class="mt-2"><strong>Nota:</strong>Una vez se guarden los cambios efectuados, estos ya no se podrán modificar de ninguna forma posible.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
             $(document).ready(function() {
            $('#tbl_lista_ventas').DataTable({
                "order": [0, 'asc'],
                "paging": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                    buttons: [

                    {
                        extend: 'copy'
                    },
                    {
                        extend: 'excel',
                        title: 'Listado de declaraciones '
                    },



                    ],          
              

                "ajax": "/ventas/lista/seleccionar",
                "columns": [
                    {
                        data: 'cai'
                    },
                    {
                        data: 'DC'
                    },
                    {
                        data: 'ND'
                    },
                    {
                        data:'opciones'
                    }

  
                ]


            });
            })

            function modalTranslado(cai){
                 
                 Swal.fire({
                 title: 'Está suguro(a) de realizar este cambio?',
                
                 showCancelButton: true,
                 confirmButtonText: 'Confirmar', 
                 confirmButtonColor:'#19A689',
                 cancelButtonText: `Cancelar`,
                 }).then((result) => {
                 /* Read more about isConfirmed, isDenied below */
                 if (result.isConfirmed) {
                     actualizarEstado(cai);
                 } 
                 })
             }

             function actualizarEstado(cai){
                   let data = {cai:cai};
                   axios.post('/ventas/cambio',data)
                   .then( response =>{
                    let data = response.data;

                    Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,

                    })

                    $('#tbl_lista_ventas').DataTable().ajax.reload();      
                   })
                   .catch(err =>{

                    let data = err.response.data;
                    Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,
                   })
                })
                

                
             }

             function obtenerArrar(){
                var table = $('#tbl_lista_ventas').DataTable();
 
                var plainArray = table.column( 0 ).data().toArray();
                console.log(plainArray);
                }
        </script>
    @endpush
</div>

