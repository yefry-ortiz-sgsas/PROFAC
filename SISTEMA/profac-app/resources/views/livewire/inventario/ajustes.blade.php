<div>
    @push('styles')
        <style>

        </style>
    @endpush
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Ajustes de Producto</h2>

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3>Listado De Producto En Bodega</h3>
                    </div>
                    <div class="ibox-content">
                        <form id="selec_data_form" name="selec_data_form" data-parsley-validate>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 b-r">
                                    <div>

                                        <label for="selectBodega" class="col-form-label focus-label">Seleccionar
                                            Bodega:</label>
                                        <select id="selectBodega" class="form-group form-control" style=""
                                            data-parsley-required onchange="obtenerProductosBodega()">
                                            <option value="" selected disabled>--Seleccionar una Bodega--</option>
                                        </select>

                                    </div>


                                </div>


                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                                    <label for="selectProducto" class="col-form-label focus-label">Seleccionar
                                        Producto:</label>
                                    <select id="selectProducto" class="form-group form-control" style=""
                                        data-parsley-required>
                                        <option value="" selected disabled>--Seleccionar un producto por codigo ó nombre--</option>
                                    </select>

                                </div>






                            </div>
                        </form>
                        <button type="submit" form="selec_data_form" class="btn btn-primary btn-lg mb-4 mt-3">Solicitar
                            Producto</button>


                        <hr>

                            <h3  class=""><i class="fa-solid fa-warehouse  m-0 p-0" style="color: #1AA689"></i> <span id="total"></span></h3>
                        <div class="table-responsive">
                            <table id="tbl_translados" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Cod Producto</th>
                                        <th>Nombre</th>
                                        <th>Unidad de Medida</th>
                                        <th>Cantidad Disponible</th>
                                        <th>Bodega</th>
                                        <th>Sección</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Translado</th>
                                        


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

    <div id="destino" class="d-none">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h3>Listado De Producto En Bodega De Destino</h3>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id="tbl_translados_destino" class="table table-striped table-bordered table-hover">
                                    <thead class="">
                                        <tr>
                                            <th>Cod Producto</th>
                                            <th>Nombre</th>
                                            <th>Unidad de Medida</th>
                                            <th>Cantidad Disponible</th>
                                            <th>Bodega</th>
                                            <th>Sección</th>
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
             
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_transladar_producto">
        Launch demo modal
      </button>

    <!-- Modal para transferir producto a otra bodega-->
    <div class="modal fade"  id="modal_transladar_producto"  role="dialog"
        aria-labelledby="modal_transladar_productoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal_transladar_productoLabel"> Datos de Ajuste </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="recibirProducto" data-parsley-validate>
                                <input type="hidden" name="idRecibido" id="idRecibido">


                                <div class="form-group" >
                                    <label for="tipo_ajuste_id">Motivo</label>
                                    <select class="form-control m-b" name="tipo_ajuste_id" id="tipo_ajuste_id"
                                       required data-parsley-required>
                                        <option value="" selected disabled>---Seleccione una bodega de destino---</option>

                                        

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comentario" class="col-form-label focus-label">Comentario:<span class="text-danger">*</span></label>
                                    <textarea  placeholder="Escriba aquí..." required id="comentario" name ="comentario" cols="30" rows="3"
                                        class="form-group form-control" data-parsley-required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="solicitado_por">Solicitado por:</label>
                                            <select class="form-control " name="solicitado_por" id="solicitado_por" required
                                                data-parsley-required >
                                                <option value="" selected disabled>---Seleccionar una opción:---</option>
        
                                            </select>
                                        </div>
                                      

                                       
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            
                                        <label for="fecha">Fecha de solicitud:</label>
                                        <input class="form-control"
                                        required data-parsley-required type="date" name="fecha" id="fecha">
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                      
                                            <label for="idProducto">Código de producto</label>
                                            <input type="text" name="idProducto" id="idProducto" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                        <label for="nombre_producto">Nombre de producto:</label>
                                            <input class="form-control"
                                            required data-parsley-required type="text" name="nombre_producto" id="nombre_producto" readonly>
                                        </div>    
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                      
                                            <label for="cantidad_dispo">Cantidad disponible en sección:</label>
                                            <input type="text" name="cantidad_dispo" id="cantidad_dispo" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                      
                                            <label for="precio_producto">Precio producto:</label>
                                            <input type="text" name="precio_producto" id="precio_producto" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                        <label for="cantidad">Cantidad:</label>
                                            <input class="form-control" autocomplete="off"
                                            required data-parsley-required type="text" name="cantidad" id="cantidad" >
                                        </div>    
                                    </div>
                                </div>

 

  




                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="btn_recibir_bodega" type="submit" form="recibirProducto" class="btn btn-primary">Realizar Ajuste</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var idRecibido = null;

            
            $( document ).ready(function() {
                obtenerMotivos();
            });


            $('#selectBodega').select2({
                ajax: {
                    url: '/ajustes/listar/bodegas',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public',
                            page: params.page || 1
                        }
                        
                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    }

                }
            });

            

            $(document).on('submit', '#selec_data_form', function(event) {

                event.preventDefault();
                obtenerListaBodega();

            });

            function obtenerProductosBodega(){
                let bodegaId = document.getElementById('selectBodega').value; 
                let selectProducto= document.getElementById('selectProducto');               
                selectProducto.innerHTML = '<option value="" selected disabled>--Seleccionar un producto por codigo ó nombre--</option>';  

                $('#selectProducto').select2({
                ajax: {
                    url: '/ajustes/listar/productos',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            bodegaId:bodegaId,
                            type: 'public',
                            page: params.page || 1
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    }
                }
            });
            }

            function obtenerListaBodega() {
                let idBodega = document.getElementById('selectBodega').value;
                let idProducto = document.getElementById('selectProducto').value;
                //let data = {'idBodega':idBodega, 'idProducto',idProducto};

                let table = $('#tbl_translados').DataTable();
                table.destroy();

                $('#tbl_translados').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
                    pageLength: 10,
                    responsive: true,                   
                    "ajax":{ 
                    'url':"/ajustes/listado/producto/bodega",
                    'data' : {'idBodega' : idBodega, idProducto:idProducto },
                    'type' : 'post',
                    'headers': {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }


                     },
                    "columns": [{
                            data: 'idProducto'
                        },
                        {
                            data: 'nombre'
                        },
                        {
                            data: 'simbolo'
                        },
                        {
                            data: 'cantidad_disponible'
                        },
                        {
                            data: 'bodega'
                        },
                        {
                            data: 'descripcion'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'opciones'
                        },



                    ],
                    drawCallback: function () {
                    var sum = $('#tbl_translados').DataTable().column(3).data().sum();
                    let html = 'Cantidad Total en Bodega: '+sum
                    $('#total').html(html);
                }	
                    


                });

                // let tabla = $('#tbl_translados').DataTable();
                // let suma = tabla.column(4,{page:'current'}).data().sum();
                // console.log(suma);
            }

            function modalTranslado(idRecibido) {
                this.idRecibido = idRecibido

                $('#modal_transladar_producto').modal('show')
                console.log(this.idRecibido);

            }



            $(document).on('submit', '#recibirProducto', function(event) {

                event.preventDefault();
                transladoProducto();

                });

            function transladoProducto(){
                document.getElementById('btn_recibir_bodega').disabled = true;
                let idSeccion = document.getElementById('seccion').value;
                console.log(idSeccion,'idSeccion')
                let dataForm = new FormData($('#recibirProducto').get(0));
                dataForm.append('idRecibido',idRecibido);
                //console.log(dataForm);

                let table = $('#tbl_translados_destino').DataTable();
                table.destroy();

                axios.post('/translado/producto/bodega',dataForm)
                .then( response =>{

                    let data = response.data;

                    $('#modal_transladar_producto').modal('hide')
                    document.getElementById('btn_recibir_bodega').disabled = false;
                    document.getElementById("recibirProducto").reset();
                    $('#recibirProducto').parsley().reset();

                    
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            text: data.text,
                           
                        })                


                    $('#tbl_translados').DataTable().ajax.reload();
                    

                    listadoBodegaDestino(idSeccion);

                    //document.getElementById('destino').class
                    document.getElementById('destino').classList.remove('d-none');
                    document.getElementById("recibirProducto").reset();
                    $('#recibirProducto').parsley().reset();


                    return;


                })
                .catch( err =>{
                    //console.log(err)
                    $('#modal_transladar_producto').modal('hide')
                    document.getElementById('btn_recibir_bodega').disabled = false;

                    let data = err.response.data;
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            text: data.text,
                        })

                })

            }

        function obtenerMotivos(){
            axios.get("/ajustes/motivos/listar")
            .then(response=>{
                html = '<option value="" selected disabled>---Seleccionar una opción:---</option>';
                htmlUsers = '<option value="" selected disabled>---Seleccionar una opción:---</option>';
                let data = response.data.results;
                let usuarios = response.data.usuarios;

                data.forEach(element => {
                    html += `<option value="${element.id}">${element.text}</option>`
                });

                usuarios.forEach( usuario =>{
                    htmlUsers += `<option value="${usuario.id}">${usuario.name}</option>` 
                })

                let select = document.getElementById('tipo_ajuste_id');
                document.getElementById('solicitado_por').innerHTML = htmlUsers;
                select.innerHTML = html;
            })
            .catch( err=>{
                console.log(err);
            })


        }



        function datosProducto(idProducto, idRecibido, cantidadDisponible){
            axios.post('/ajustes/datos/producto',{id:idProducto})
            .then(response=>{

                let data = response.data.producto;

                document.getElementById('idProducto').value=data.id;
                document.getElementById('nombre_producto').value=data.nombre;
                document.getElementById('precio_producto').value=data.precio_base;
                document.getElementById('idRecibido').value=idRecibido
                document.getElementById('cantidad_dispo').value=cantidadDisponible;
                $('#modal_transladar_producto').modal('show')
            })
            .catch( err=>{
                let data = err.response.data
                Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            text: data.text,
                           
                        })     
                console.log(err)        
            })
        }


        </script>
    @endpush

</div>
