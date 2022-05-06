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

                            <p class="letra-tamanio"><strong>Numero de Factura:</strong>
                                {{ $datosCompra->numero_factura }}</p>
                            <p class="letra-tamanio"><strong class="">Numero de compra:</strong>
                                {{ $datosCompra->numero_orden }}</p>
                            <p class="letra-tamanio"><strong class="">Proveedor:</strong>
                                {{ $datosCompra->nombre }}</p>

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
                                        <th>Cantidad sin asignar</th>
                                        <th>Sub Total</th>
                                        <th>ISV</th>
                                        <th>Total</th>
                                        <th>Fecha de Vencimiento</th>
                                        <th>Estado de Recibido</th>
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

                                        <th>Codigo Producto</th>
                                        <th>Nombre</th>
                                        <th>Cantidad en compra</th>
                                        <th>Departamento</th>
                                        <th>Municipio</th>
                                        <th>Bodega</th>
                                        <th>Direccion</th>
                                        <th>Seccion</th>
                                        <th>Cantidad Ingresada</th>
                                        <th>Cantidad Disponible</th>
                                        <th>Recibido Por:</th>
                                        <th>Fecha</th>
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
                    <h3 class="modal-title" id="modalRecibirProductoLabel"> Recibir En Bodega </h3>
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
                                        <option value="" selected disabled>---Seleccione una bodega---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="segmento">Segmento</label>
                                    <select class="form-control m-b" name="segmento" id="segmento" required
                                        data-parsley-required onchange="listarSecciones()">
                                        <option value="" selected disabled>---Seleccione un segmento---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="seccion">Seccion</label>
                                    <select class="form-control m-b" name="seccion" id="seccion" required
                                        data-parsley-required="">
                                        <option value="" selected disabled>---Seleccione una sección---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comentario">Cantidad a Recibir</label>


                                    <input id="cantidad" name="cantidad" type="number" min="1" class="form-control"
                                        required data-parsley-required>

                                </div>




                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="btn_recibir_bodega" type="submit" form="recibirProducto" class="btn btn-primary">Recibir
                        en bodega</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para registrar excedente de producto-->
    <div class="modal fade" id="modalRecibirIncidencia" tabindex="-1" role="dialog"
        aria-labelledby="modalRecibirIncidenciaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalRecibirIncidenciaLabel"> Registrar Incidencia </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="registrarIncidencia" data-parsley-validate>


                                <div class="form-group">
                                    <label for="bodega">Comentario</label>
                                    <textarea name="comentario" id="comentario" cols="4" rows="5" class="form-control"></textarea>
                                </div>



                                <div class="form-group">
                                    <label for="imagen">Imgen de evidencia</label>


                                    <input id="imagen" name="imagen" type="file"
                                        accept="image/png, image/jpeg, image/jpg, application/pdf"
                                        class="form-control">

                                </div>




                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="" type="submit" form="registrarIncidencia" class="btn btn-primary">Registrar Incendia
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRecibirExcedente" tabindex="-1" role="dialog"
        aria-labelledby="modalRecibirExcedenteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalRecibirExcedenteLabel"> Registrar Producto Excedente </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="recibirProductoExcedente" data-parsley-validate>


                                <div class="form-group">
                                    <label for="bodegaExcedente">Bodega</label>
                                    <select class="form-control m-b" name="bodegaExcedente" id="bodegaExcedente"
                                        onchange="listarSegmentosExcedente()" required data-parsley-required>
                                        <option value="" selected disabled>---Seleccione una bodega---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="segmentoExcedente">Segmento</label>
                                    <select class="form-control m-b" name="segmentoExcedente" id="segmentoExcedente" required
                                        data-parsley-required onchange="listarSeccionesExcedente()">
                                        <option value="" selected disabled>---Seleccione un segmento---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="seccionExcedente">Seccion</label>
                                    <select class="form-control m-b" name="seccionExcedente" id="seccionExcedente" required
                                        data-parsley-required="">
                                        <option value="" selected disabled>---Seleccione una sección---</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="cantidadExcedente">Cantidad a Recibir</label>


                                    <input id="cantidadExcedente" name="cantidadExcedente" type="number" min="1"
                                        class="form-control" required data-parsley-required>

                                </div>




                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="" type="submit" form="recibirProductoExcedente" class="btn btn-primary">Recibir en
                        bodega</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var idCompra = {{ $idCompra }}
            var idProducto;

            window.onload = listarBodegas;
            window.onload = listarBodegasExcedente;

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
                            "data": "cantidad_sin_asignar"
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


                $('#tbl_producto_bodega').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
                    pageLength: 10,
                    responsive: true,
                    "ajax": "/producto/lista/bodega/" + idCompra,
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "producto"
                        },
                        {
                            "data": "cantidad_compra_lote"
                        },
                        {
                            "data": "departamento"
                        },
                        {
                            "data": "municipio"
                        },
                        {
                            "data": "bodega"
                        },
                        {
                            "data": "direccion"
                        },
                        {
                            "data": "seccion"
                        },
                        {
                            "data": "cantidad_inicial_seccion"
                        },
                        {
                            "data": "cantidad_disponible"
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "created_at"
                        },
                        {
                            "data": "opciones"
                        }

                    ]
                });

            });

            function mostratModal(compraId, productoId) {



                idProducto = productoId;

                axios.post("/producto/recibir/datos", {
                        compraId,
                        productoId
                    })
                    .then(response => {
                            let data = response.data.datosCompra;

                            let cantidadElemento = document.getElementById("cantidad");
                            cantidadElemento.setAttribute("max", data.cantidad_sin_asignar);
                            $('#modalRecibirProducto').modal('show');

                        }

                    )
                    .catch(err => {

                        console.log(err)
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Ha ocurrido un error al obtener los datos generales de la compra.',
                        })

                    })

            }

            function listarBodegas() {
                document.getElementById('segmento').innerHTML =
                    '<option value="" selected disabled>---Seleccione un segmento---</option>';
                document.getElementById('seccion').innerHTML =
                    '<option value="" selected disabled>---Seleccione una sección---</option>';;
                axios.get('/producto/recibir/bodega')
                    .then(response => {

                        //console.log(response)

                        let array = response.data.listaBodegas;
                        let htmlBodega = ' <option value="" selected disabled>---Seleccione una bodega---</option>';
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
                        let htmlSegmento = '  <option value="" selected disabled>---Seleccione un segmento---</option>';
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
                        let htmlSeccion = '  <option value="" selected disabled>---Seleccione una sección---</option>';
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

            function guardarProductoBodega() {

                document.getElementById("btn_recibir_bodega").disabled = true;
                var data = new FormData($('#recibirProducto').get(0));
                data.append('idCompra', idCompra);
                data.append('idProducto', idProducto);

                axios.post('/producto/recibir/guardar', data)
                    .then(response => {

                        $('#modalRecibirProducto').modal('hide');
                        document.getElementById('recibirProducto').reset();

                        $('#recibirProducto').parsley().reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Exito!',
                            text: 'Producto recibido con exito.',
                        })

                        $('#tbl_recibir_compra').DataTable().ajax.reload();
                        $('#tbl_producto_bodega').DataTable().ajax.reload();
                        document.getElementById("btn_recibir_bodega").disabled = false;

                    })
                    .catch(err => {
                        $('#modalRecibirProducto').modal('hide');
                        //console.log(err.response.data);
                        let data = err.response.data;
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            text: data.text,
                        })
                    })
            }

            function mostrarModalIncidencias(id) {
                $('#modalRecibirIncidencia').modal('show');
            }

            function mostrarModalExcedente(compraId, productoId) {
                $('#modalRecibirExcedente').modal('show');
            }

            function listarBodegasExcedente() {
                document.getElementById('segmentoExcedente').innerHTML =
                    '<option value="" selected disabled>---Seleccione un segmento---</option>';
                document.getElementById('seccionExcedente').innerHTML =
                    '<option value="" selected disabled>---Seleccione una sección---</option>';;
                axios.get('/producto/recibir/bodega')
                    .then(response => {

                        //console.log(response)

                        let array = response.data.listaBodegas;
                        let htmlBodega = ' <option value="" selected disabled>---Seleccione una bodega---</option>';
                        array.forEach(element => {
                            htmlBodega += `
                <option value="${element.id}">${element.nombre}</option>
                `

                        })

                        document.getElementById('bodegaExcedente').innerHTML = htmlBodega;


                    })
                    .catch(err => {

                        console.log(err);

                    })
            }

            function listarSegmentosExcedente() {

                let bodega = document.getElementById("bodegaExcedente").value;


                axios.post('/producto/recibir/segmento', {
                        idBodega: bodega
                    })
                    .then(response => {

                        //console.log(response)

                        let array = response.data.listaSegmentos;
                        let htmlSegmento = '  <option value="" selected disabled>---Seleccione un segmento---</option>';
                        array.forEach(element => {
                            htmlSegmento += `
                <option value="${element.id}">${element.descripcion}</option>
                `

                        })

                        document.getElementById('segmentoExcedente').innerHTML = htmlSegmento;

                    })
                    .catch(err => {

                        console.log(err);

                    })
            }

            function listarSeccionesExcedente() {

                let segmento = document.getElementById("segmentoExcedente").value;


                axios.post('/producto/recibir/seccion', {
                        idSegmento: segmento
                    })
                    .then(response => {

                        //console.log(response)

                        let array = response.data.listaSecciones;
                        let htmlSeccion = '  <option value="" selected disabled>---Seleccione una sección---</option>';
                        array.forEach(element => {
                            htmlSeccion += `
                                <option value="${element.id}">${element.descripcion}</option>
        `

                        })

                        document.getElementById('seccionExcedente').innerHTML = htmlSeccion;

                    })
                    .catch(err => {

                        console.log(err);

                    })
            }
        </script>
    @endpush
</div>
