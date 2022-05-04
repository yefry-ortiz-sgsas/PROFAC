<div>
    @push('styles')
    <style>
    .letra-tamanio {
        font-size: 0.8rem    
    }
    </style>

    @endpush
    {{-- The whole world belongs to you. --}}

    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12		
        ">
            <h2>Recibir Producto En Bodega</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Recibir</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="ibox ">
                    <div class="ibox-title">
                            <h3>Lista de Compra</h3>
                    </div>
                    <div class="ibox-content">
                        <div>
                            
                            <p class="letra-tamanio"><strong>Numero de Factura:</strong> {{$datosCompra->numero_factura}}</p>
                            <p class="letra-tamanio"><strong class="">Numero de compra:</strong> {{$datosCompra->numero_orden}}</p>
                            <p class="letra-tamanio"><strong class="">Proveedor:</strong> {{$datosCompra->nombre}}</p>

                        </div>
                        <div class="table-responsive">
                            <table id="tbl_recibir_compra" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>N°</th>                                        
                                        <th>Codigo de Producto</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Sub Total</th>
                                        <th>ISV</th>
                                        <th>Total</th>
                                        <th>Fecha de Vencimiento</th>   
                                        <th>Estado</th>                                        
                                        <th>Recibir</th>

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


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="ibox ">
                    <div class="ibox-title">
                            <h3>Detalle De Recepcion En Bodega</h3>
                    </div>
                    <div class="ibox-content">
 
                        <div class="table-responsive">
                            <table id="tbl_producto_bodega" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>N°</th>                                        
                                        <th>Codigo Producto</th>
                                        <th>Nombre</th>
                                        <th>Cantidad en compra</th>
                                        <th>Departamento</th>
                                        <th>Municipio</th>
                                        <th>Direccion</th>
                                        <th>Bodega</th>
                                        <th>Seccion</th>   
                                        <th>Cantidad en Bodega</th>                                        
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

    <!-- Modal para recibir en Bodega-->
    <div class="modal fade" id="modalRecibirProducto" tabindex="-1" role="dialog"
        aria-labelledby="modalRecibirProductoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalRecibirProductoLabel">Editar Bodega</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="recibirProducto" data-parsley-validate>


                                <div class="form-group">
                                    <label for="bodega">Bodega</label>
                                    <select class="form-control m-b" name="bodega" id="bodega"
                                        onchange="listarSegmentos()" required data-parsley-required>
                                        <option value="" selected disabled>---Selecciones una bodega---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="segmento">Segmento</label>
                                    <select class="form-control m-b" name="segmento" id="segmento" required
                                        data-parsley-required onchange="listarSecciones()">
                                        <option value="" selected disabled>---Selecciones un segmento---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="seccion">Seccion</label>
                                    <select class="form-control m-b" name="seccion" id="seccion" required
                                        data-parsley-required="">
                                        <option value="" selected disabled>---Selecciones una sección---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comentario">Comentario</label>
                                    {{-- <input id="comentario" name="comentario" type="text" placeholder="comentario"
                                        class="form-control" > --}}

                                        <textarea name="comentario" id="comentario" cols="3" rows="3" class="form-control"></textarea>

                                </div>

                               

                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="recibirProducto" class="btn btn-primary">Recibir en bodega</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var idCompra = {{ $idCompra }}
            var idProducto;

            window.onload = listarBodegas;

            $(document).ready(function() {



                $('#tbl_recibir_compra').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
                    pageLength: 10,
                    responsive: true,
                    "ajax": "/producto/compra/recibir/listar/" + idCompra,
                    "columns": [{
                            "data": "contador"
                        },
                        {
                            "data": "producto_id"
                        },
                        {
                            "data": "nombre"
                        },
                        {
                            "data": "precio_unidad"
                        },
                        {
                            "data": "cantidad_comprada"
                        },
                        {
                            "data": "sub_total_producto"
                        },
                        {
                            "data": "isv"
                        },
                        {
                            "data": "precio_total"
                        },
                        {
                            "data": "fecha_expiracion"
                        },
                        {
                            "data": "estado_recibido"
                        },
                        {
                            "data": "opciones"
                        },
                       
                    ]
                });

            });

            function mostratModal(compraId, productoId) {

                $('#modalRecibirProducto').modal('show')

                idProducto = productoId;

            }

            function listarBodegas() {
                document.getElementById('segmento').innerHTML = '<option value="" selected disabled>---Selecciones un segmento---</option>';
                        document.getElementById('seccion').innerHTML = '<option value="" selected disabled>---Selecciones una sección---</option>';;
                axios.get('/producto/recibir/bodega')
                    .then(response => {

                        //console.log(response)

                        let array = response.data.listaBodegas;
                        let htmlBodega = ' <option value="" selected disabled>---Selecciones una bodega---</option>';
                        array.forEach(element => {
                            htmlBodega += `
                <option value="${element.id}">${element.nombre}</option>
                `

                        })

                        document.getElementById('bodega').innerHTML = htmlBodega;                      
                       

                    })
                    .catch(err => {

                        console.log(err);

                    })
            }

            function listarSegmentos() {

                let bodega = document.getElementById("bodega").value;


                axios.post('/producto/recibir/segmento', {
                        idBodega: bodega
                    })
                    .then(response => {

                        //console.log(response)

                        let array = response.data.listaSegmentos;
                        let htmlSegmento = '  <option value="" selected disabled>---Selecciones un segmento---</option>';
                        array.forEach(element => {
                            htmlSegmento += `
                <option value="${element.id}">${element.descripcion}</option>
                `

                        })

                        document.getElementById('segmento').innerHTML = htmlSegmento;

                    })
                    .catch(err => {

                        console.log(err);

                    })
            }

            function listarSecciones() {

                let segmento = document.getElementById("segmento").value;


                axios.post('/producto/recibir/seccion', {
                    idSegmento: segmento
                    })
                    .then(response => {

                        //console.log(response)

                        let array = response.data.listaSecciones;
                        let htmlSeccion = '  <option value="" selected disabled>---Selecciones una sección---</option>';
                        array.forEach(element => {
                            htmlSeccion += `
                                <option value="${element.id}">${element.descripcion}</option>
        `

                        })

                        document.getElementById('seccion').innerHTML = htmlSeccion;

                    })
                    .catch(err => {

                        console.log(err);

                    })
            }

            $(document).on('submit', '#recibirProducto', function(event) {
                event.preventDefault();
                guardarProductoBodega();
                });

        function guardarProductoBodega(){
            let idSeccion = document.getElementById('seccion').value;
            axios.post('/producto/recibir/guardar',{idSeccion:idSeccion, idCompra:idCompra, idProducto:idProducto})
            .then( response=>{

                $('#modalRecibirProducto').modal('hide');
                document.getElementById('recibirProducto').reset();
                   
                   $('#recibirProducto').parsley().reset();

                   Swal.fire({
                   icon: 'success',
                   title: 'Exito!',
                   text: 'Producto recibido con exito.',
                   })

                   $('#tbl_recibir_compra').DataTable().ajax.reload();  

            })
            .catch( err =>{
                console.log(err);
                Swal.fire({
                   icon: 'error',
                   title: 'Error!',
                   text: 'Ha ocurrido un error al recibir el producto.',
                   })
            })
        }        
        </script>
    @endpush
</div>
