<div>
    @push('styles')
        <style>

        </style>
    @endpush
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Translado en Bodega</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Translado de Producto</a>
                </li>
                {{-- <li class="breadcrumb-item">
                    <a data-toggle="modal" data-target="#modal_producto_crear">Registrar</a>
                </li> --}}

            </ol>
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
                                            data-parsley-required onchange="obteneProducto()">
                                            <option value="" selected disabled>--Seleccionar una Bodega--</option>
                                        </select>

                                    </div>


                                </div>


                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                                    <label for="selectProducto" class="col-form-label focus-label">Seleccionar
                                        Producto:</label>
                                    <select id="selectProducto" class="form-group form-control" style="" 
                                        data-parsley-required disabled >
                                        <option value="" selected disabled>--Seleccionar un producto por codigo ó
                                            nombre--</option>
                                    </select>

                                </div>






                            </div>
                        </form>
                        <button type="submit" form="selec_data_form" class="btn btn-primary btn-lg mb-4 mt-3">Solicitar
                            Producto</button>


                        <hr>

                        <h3 class=""><i class="fa-solid fa-warehouse  m-0 p-0" style="color: #1AA689"></i> <span
                                id="total"></span></h3>
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




    <!-- Modal para transferir producto a otra bodega-->
    <div class="modal fade" id="modal_transladar_producto" tabindex="-22" role="dialog"
        aria-labelledby="modal_transladar_productoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal_transladar_productoLabel"> Transladar a otra bodega </h3>
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
                                        <option value="" selected disabled>---Seleccione una bodega de destino---
                                        </option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="segmento">Segmento</label>
                                    <select class="form-control m-b" name="segmento" id="segmento" required
                                        data-parsley-required onchange="listarSecciones()">
                                        <option value="" selected disabled>---Seleccione un segmento de destino---
                                        </option>

                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="seccion">Seccion</label>
                                    <select class="form-control m-b" name="seccion" id="seccion" required
                                        data-parsley-required="">
                                        <option value="" selected disabled>---Seleccione una sección de destino---
                                        </option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comentario">Cantidad a transladar</label>


                                    <input id="cantidad" name="cantidad" type="number" min="1"
                                        class="form-control" required data-parsley-required>

                                </div>

                                <div class="form-group">
                                    <label for="seccion">Unidad de medida</label>
                                    <select class="form-control m-b" name="Umedida" id="Umedida" required
                                        data-parsley-required="">
                                        <option value="" selected disabled>---Seleccione una Unidad de medida---
                                        </option>

                                    </select>
                                </div>

                                <input id="idProducto" type="hidden" value="">

                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="btn_recibir_bodega" type="submit" form="recibirProducto"
                        class="btn btn-primary">Agregar a lista</button>
                </div>
            </div>
        </div>
    </div>


    <!--Tabla para productos a transladar-->
    <div id="lista_translado" class="">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                                <h3>Listado de productos a transaladar</h3>
                            </div>
                             <div class="ibox-content">                          
                                <div class="table-responsive">
                                    <form onkeydown="return event.key != 'Enter';" autocomplete="off" id="guardar_translados"   name="guardar_translados" data-parsley-validate>
                                        
                                    </form>
                                    <table id="tbl_translados_productos"
                                        class="table table-striped table-bordered table-hover">
                                        <thead class="">
                                            <tr>
                                                <th>Eliminar</th>
                                                <th>Cod Producto</th>
                                                <th>Bodega</th>
                                                <th>Segmento</th>
                                                <th>Seccion</th>
                                                <th>Cantidad</th>
                                                <th>Uniad de medida</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody id="cuerpoListaProducto">
                                          
                                            
                                           
                                        </tbody>
                                       
                                    </table>
                                    
                                    <button id="btn_guardar_translado" type="submit" form="guardar_translados"   class="btn btn-primary btn-lg mb-4 mt-3" >Guardar Translado</button>                           
                                </div>
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
                                <table id="tbl_translados_destino"
                                    class="table table-striped table-bordered table-hover">
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
                                <button onclick="limpiar()" type="button" class="btn btn-warning btn-lg mb-4 mt-3" >Limpiar</button>                           
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@push('scripts')
    <script>
        var contador = 1;
        var arrayInputs = [];
        var idProductoArray = [];
        var idRecibidoArray = [];

        var idRecibido = null;
        $(document).ready(function() {

            listarBodegas();


        });




        $('#selectBodega').select2({
            ajax: {
                url: '/translado/lista/bodegas',

            }
        });

        $(document).on('submit', '#selec_data_form', function(event) {

            event.preventDefault();
            obtenerListaBodega();

        });

        function limpiar(){
            window.location.reload()
        }



        function obteneProducto() {
            let idBodega = document.getElementById('selectBodega').value;
            document.getElementById('selectProducto').disabled = false;
            $('#selectProducto').select2({
                ajax: {
                    url: '/translado/lista/productos',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            idBodega: idBodega,
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
            //let table2 = document.getElementById('tbl_translados_destino');
            table.destroy();


            //table2.destroy();

            $('#tbl_translados').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                pageLength: 10,
                responsive: true,
                "ajax": "/translado/producto/lista/" + idBodega + "/" + idProducto,
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
                drawCallback: function() {
                    var sum = $('#tbl_translados').DataTable().column(3).data().sum();
                    let html = 'Cantidad Total en Bodega: ' + sum
                    $('#total').html(html);
                }



            });

            // let tabla = $('#tbl_translados').DataTable();
            // let suma = tabla.column(4,{page:'current'}).data().sum();
            // console.log(suma);
        }

        function modalTranslado(idRecibido, cantidadDisponible, idProducto) {
            this.idRecibido = idRecibido
            document.getElementById('cantidad').max = cantidadDisponible;

            //console.log(idProducto);
            this.listarUmedidas(idProducto);

            $('#modal_transladar_producto').modal('show')
            // console.log(this.idRecibido);

            document.getElementById("idProducto").value = idProducto

        }

        function listarBodegas() {
            //console.log("entro")
            document.getElementById('segmento').innerHTML =
                '<option value="" selected disabled>---Seleccione un segmento de destino---</option>';
            document.getElementById('seccion').innerHTML =
                '<option value="" selected disabled>---Seleccione una sección de destino---</option>';

            axios.get('/producto/recibir/bodega')
                .then(response => {

                    //console.log(response)

                    let array = response.data.listaBodegas;
                    let htmlBodega =
                        ' <option value="" selected disabled>---Seleccione una bodega de destino---</option>';
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
                        htmlSeccion += `<option value="${element.id}">${element.descripcion}</option>`

                    })

                    document.getElementById('seccion').innerHTML = htmlSeccion;

                })
                .catch(err => {

                    console.log(err);

                })
        }

        function listarUmedidas(idProducto) {
            axios.get('/producto/recibir/Umedidas/' + idProducto)
                .then(response => {

                    let array = response.data.listaUmedidas;
                    let htmlSeccion = '  <option value="" selected disabled>---Seleccione una sección---</option>';
                    array.forEach(element => {
                        htmlSeccion += `<option value="${element.id}">${element.unidad}</option>`
                    })

                    document.getElementById('Umedida').innerHTML = htmlSeccion;

                })
                .catch(err => {

                    console.log(err);

                })
        }



        $(document).on('submit', '#recibirProducto', function(event) {

            event.preventDefault();
            transladoProducto();

        });

        // function transladoProducto(){
        //     document.getElementById('btn_recibir_bodega').disabled = true;
        //     let idSeccion = document.getElementById('seccion').value;

        //     let dataForm = new FormData($('#recibirProducto').get(0));
        //     dataForm.append('idRecibido',idRecibido);
        //     //console.log(dataForm);

        //     let table = $('#tbl_translados_destino').DataTable();
        //     table.destroy();

        //     axios.post('/translado/producto/bodega',dataForm)
        //     .then( response =>{

        //         let data = response.data;

        //         $('#modal_transladar_producto').modal('hide')
        //         document.getElementById('btn_recibir_bodega').disabled = false;
        //         document.getElementById("recibirProducto").reset();
        //         $('#recibirProducto').parsley().reset();


        //             Swal.fire({
        //                 icon: data.icon,
        //                 title: data.title,
        //                 text: data.text,

        //             })


        //         $('#tbl_translados').DataTable().ajax.reload();


        //         listadoBodegaDestino(idSeccion);

        //         //document.getElementById('destino').class
        //         document.getElementById('destino').classList.remove('d-none');
        //         document.getElementById("recibirProducto").reset();
        //         $('#recibirProducto').parsley().reset();


        //         return;


        //     })
        //     .catch( err =>{
        //         //console.log(err)
        //         $('#modal_transladar_producto').modal('hide')
        //         document.getElementById('btn_recibir_bodega').disabled = false;

        //         let data = err.response.data;
        //             Swal.fire({
        //                 icon: data.icon,
        //                 title: data.title,
        //                 text: data.text,
        //             })

        //     })

        // }

        function transladoProducto() {

            let idCuerpoLista = document.getElementById("cuerpoListaProducto");

            let idProducto = document.getElementById("idProducto").value;

            let bodegaSelect = document.getElementById("bodega");
            let bodegaNombre = bodegaSelect.options[bodegaSelect.selectedIndex].text
            let bodegaId = bodegaSelect.value;

            let segmentoSelect = document.getElementById("segmento");
            let segmentoNombre = segmentoSelect.options[segmentoSelect.selectedIndex].text
            let segmentoId = segmentoSelect.value;


            let seccionSelect = document.getElementById("seccion");
            let seccionNombre = seccionSelect.options[seccionSelect.selectedIndex].text
            let seccionId = seccionSelect.value;

            let cantidad = document.getElementById("cantidad").value;


            let medidaSelect = document.getElementById("Umedida");
            let medidaNombre = medidaSelect.options[medidaSelect.selectedIndex].text
            let medidaId = medidaSelect.value;

            let comprobarIdRecibido = idRecibidoArray.find(element => element == ('' + idProducto + seccionId));

            if (comprobarIdRecibido) {
                Swal.fire({
                    icon: "warning",
                    title: "Advertencia!",
                    text: "El producto, bodega y sección de destino ya existen en la lista. No se puede repetir estos elementos. ",
                    confirmButtonColor: "#1AA689",
                })
                $('#modal_transladar_producto').modal('hide')
                return;
            }

            let productoSeccion = ''+idProducto + seccionId;

            idRecibidoArray.push('' + idProducto + seccionId);

            let html = `
                <tr id="tr${contador}">
                                            <td>
                                                     <button class="btn btn-danger text-center" type="button" onclick="eliminarInput(${contador},${productoSeccion})"><i
                                                            class="fa-regular fa-rectangle-xmark"></i>
                                                    </button>
                                            </dt>    
                                            <td>
                                                <input id="producto${contador}" name="producto${contador}" type="text" value="${idProducto}" disabled class="form-control" required form="guardar_translados">
                                            </td>

                                            <td>
                                                <input id="nombreBodega${contador}" name="nombreBodega${contador}" type="text" value="${bodegaNombre}" disabled required class="form-control" form="guardar_translados">
                                                <input id="idBodega${contador}" name="idBodega${contador}" type="hidden" value="${bodegaId}" disabled required form="guardar_translados">
                                            </td>

                                            <td>
                                                <input id="nombreSegmento${contador}" name="nombreSegmento${contador}" type="text" value="${segmentoNombre}" disabled class="form-control" required form="guardar_translados"> 
                                                <input id="idSegmento${contador}" name="idSegmento${contador}" type="hidden" value="${segmentoId}" disabled form="guardar_translados">
                                            </td>

                                            <td>
                                                <input id="nombreSeccion${contador}" name="nombreSeccion${contador}" type="text" value="${seccionNombre}" disabled class="form-control" form="guardar_translados">
                                                <input id="idSeccion${contador}" name="idSeccion${contador}" type="hidden" value="${seccionId}" required form="guardar_translados">
                                            </td>

                                            <td>
                                                <input id="cantidad${contador}"  name="cantidad${contador}" type="number" value="${cantidad}" readonly class="form-control" form="guardar_translados">
                                            </td>

                                            <td>
                                                <input id="unidadMedida${contador}" name="unidadMedida${contador}" type="text" value="${medidaNombre}" disabled class="form-control" form="guardar_translados">
                                                <input id="unidadMedidaId${contador}" name="unidadMedidaId${contador}" type="hidden" value="${medidaId}" readonly form="guardar_translados">
                                                <input id="idRecibido${contador}" name="idRecibido${contador}" type="hidden" value="${idRecibido}" readonly form="guardar_translados">
                                                
                                            </td>

                                        </tr>
                `



            $('#modal_transladar_producto').modal('hide')
            idCuerpoLista.insertAdjacentHTML('beforeend', html);
            document.getElementById("recibirProducto").reset();
            $('#recibirProducto').parsley().reset();

            arrayInputs.push(contador);
          
            contador++;
            return;
        }

        function listadoBodegaDestino(contadorTranslados) {

           
          let   contador = contadorTranslados;

            // console.log(idSeccion);
            // console.log(idProducto);
            $('#tbl_translados_destino').DataTable({
                "order": [6, 'desc'],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                pageLength: 10,
                responsive: true,
                "ajax": "/translado/destino/lista/"+contador,
                
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
                    }


                ]


            });
        }


        function eliminarInput(id, productoSeccion) {
           const element = document.getElementById("tr" + id);
            element.remove();

        

            var myIndex = arrayInputs.indexOf(id);
            if (myIndex !== -1) {
                arrayInputs.splice(myIndex, 1);

            }

            productoSeccion = ''+productoSeccion;
            var myIndex2 = idRecibidoArray.indexOf(productoSeccion);
         
            if (myIndex2 !== -1) {
                idRecibidoArray.splice(myIndex2, 1);

            }

            
        }


        $(document).on('submit', '#guardar_translados', function(event) {

            event.preventDefault();
            guardarTranslado();

        });


        function guardarTranslado() {
            document.getElementById("btn_guardar_translado").disabled = true;

            var dataForm = new FormData($('#guardar_translados').get(0));

            let longitudArreglo = arrayInputs.length;
            for (var i = 0; i < longitudArreglo; i++) {



                dataForm.append("arregloIdInputs[]", arrayInputs[i]);

            }

            let table = $('#tbl_translados_destino').DataTable();
            table.destroy();

            axios.post('/translado/producto/bodega', dataForm)
                .then(response => {

                    let data = response.data;
                    let contador = data.contadorTranslados;




                    Swal.fire({
                        icon: data.icon,
                        title: data.title,
                        html: data.text,

                    })



                    let table1 = $('#tbl_translados').DataTable();
                    table1.destroy();


                    
                 

                    //document.getElementById('destino').class
                    document.getElementById('destino').classList.remove('d-none');
                    document.getElementById("recibirProducto").reset();
                    $('#recibirProducto').parsley().reset();

                    listadoBodegaDestino(contador);

                    return;


                })
                .catch(err => {
                    //console.log(err)
                    document.getElementById("btn_guardar_translado").disabled = false;
                    console.log(err);
                    $('#modal_transladar_producto').modal('hide')
                    document.getElementById('btn_recibir_bodega').disabled = false;

                   
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Ha ocurrido un error.",
                    })

                })


        }
    </script>
@endpush

</div>
