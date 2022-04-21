<div>
    @push('styles')
        <style>
            @media (max-width: 767.5px) {
                .hide-container {
                    display: none;
                }

            }

        </style>
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Compras</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Realizar Compra</a>
                </li>
                {{-- <li class="breadcrumb-item">
                    <a data-toggle="modal" data-target="#modal_producto_crear">Registrar</a>
                </li> --}}

            </ol>
        </div>


        {{-- <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
                <div style="margin-top: 1.5rem">
                    <a href="#" class="btn add-btn btn-primary" data-toggle="modal" data-target="#modal_producto_crear"><i
                            class="fa fa-plus"></i> Registrar Producto</a>
                </div>
            </div> --}}


    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3>Datos de compra <i class="fa-solid fa-cart-shopping"></i></h3>
                    </div>
                    <div class="ibox-content">
                        <form id="crear_compra" name="crear_compra" data-parsley-validate>
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                                    <label class="col-form-label text-danger" for="totalGeneral"
                                        style="font-size: 1rem; font-weight:600;">Numero de compra</label>
                                </div>

                                <div class="col-6 col-sm-6 col-md-2 col-lg-2 col-xl-2">

                                    <input class="form-control" type="text" id="nombre_emision" name="nombre_emision"
                                        value="{{ $ordenNumero->numero + 1 }}" data-parsley-required disabled>
                                </div>

                            </div>
                            <div class="row mt-4">
                                <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <label for="seleccionarProveedor" class="col-form-label focus-label">Seleccionar
                                        Proveedor:</label>
                                    <select id="seleccionarProveedor" class="form-group form-control" style="" 
                                        data-parsley-required>
                                        <option value="" selected disabled>--Seleccionar un proveedor--</option>
                                    </select>




                                </div>

                                <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <label for="tipoPagoCompra" class="col-form-label focus-label">Seleccionar tipo de
                                        pago:</label>
                                    <select class="form-group form-control " name="tipoPagoCompra" id="tipoPagoCompra"
                                        data-parsley-required onchange="validarFechaPago()">

                                    </select>

                                </div>


                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">




                                        <label for="fecha_vencimiento"
                                            class="col-form-label focus-label text-warning">Fecha de vencimiento:
                                        </label>
                                        <input class="form-control" type="date" id="fecha_vencimiento"
                                            name="fecha_vencimiento" value="" data-parsley-required
                                            min="{{ date('Y-m-d') }}" disabled>

                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">

                                        <label for="fecha_emision" class="col-form-label focus-label">Fecha de emisión
                                            :</label>
                                        <input class="form-control" type="date" id="fecha_emision"
                                            name="fecha_emision" value="{{ date('Y-m-d') }}" data-parsley-required>

                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">

                                        <label for="fecha_entrega" class="col-form-label focus-label">Fecha de
                                            recibido:</label>
                                        <input class="form-control" type="date" id="fecha_entrega"
                                            name="fecha_entrega" value="" data-parsley-required
                                            min="{{ date('Y-m-d') }}">

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <select id="seleccionarProdcuto" class="form-group form-control" style=""
                                                onchange="obtenerIdProducto()">
                                                <option value="" selected disabled>--Seleccione un producto--</option>
                                            </select>
                                        </div>

                                        <div id="botonAdd"
                                            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-4 text-center d-none">
                                            <button type="button" class="btn-rounded btn btn-success p-3"
                                                style="font-weight: 900; " onclick="agregarProductoCarrito()">Añadir
                                                Producto a Compra <i class="fa-solid fa-cart-plus"></i> </button>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                                    <div id="carouselProducto" class="carousel slide" data-ride="carousel">
                                        {{-- <ol  id="carousel_imagenes_producto" class="carousel-indicators">
                
                                                <li data-target="#carouselProducto" data-slide-to="{{ $i }}" class="active"></li>                        
                                           
                                                <li data-target="#carouselProducto" data-slide-to="{{ $i }}" class=""></li>
                                                  
                                           
                
                                        </ol> --}}
                                        <div id="bloqueImagenes" class="carousel-inner ">






                                        </div>
                                        <a class="carousel-control-prev" href="#carouselProducto" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselProducto" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                </div>

                            </div>
                            <hr>

                            <div class="hide-container">
                                <div class="row no-gutters ">
                                    <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                        <div class="d-flex">
    
    
    
                                            <div style="width:100%">
                                                <label class="sr-only">Nombre del
                                                    producto</label>
                                                <input type="text" placeholder="Nombre del producto" class="form-control"
                                                    pattern="[A-Z]{1}" data-parsley-pattern="[A-Z]{1}" autocomplete="off"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <label class="sr-only">Precio</label>
                                        <input type="number" placeholder="Precio de unidad" class="form-control" min="1"
                                            autocomplete="off" disabled>
                                    </div>
    
                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <label class="sr-only">cantidad</label>
                                        <input type="number" placeholder="Cantidad" class="form-control" min="1"
                                            autocomplete="off" disabled>
                                    </div>
    
                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <label class="sr-only">Sub Total</label>
                                        <input type="number" placeholder="Sub total del producto" class="form-control"
                                            min="1" autocomplete="off" disabled>
                                    </div>
    
                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                        <label class="sr-only">ISV</label>
                                        <input type="number" placeholder="ISV" class="form-control" min="1"
                                            autocomplete="off" disabled>
                                    </div>
    
                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <label class="sr-only">Total</label>
                                        <input type="number" placeholder="Total del producto" class="form-control" min="1"
                                            disabled autocomplete="off">
                                    </div>
    
                                </div>

                            </div>




                            <div id="divProductos">

                            </div>




                            <hr>
                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="subTotalGeneral">Sub Total L.</label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="number" step="any" placeholder="Sub total " id="subTotalGeneral"
                                        name="subTotalGeneral" class="form-control" min="1" data-parsley-required
                                        autocomplete="off" disabled>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="isvGeneral">ISV L.</label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="number" step="any" placeholder="ISV " id="isvGeneral" name="isvGeneral"
                                        class="form-control" min="1" data-parsley-required autocomplete="off"
                                        disabled>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="totalGeneral">Total L.</label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="number" step="any" placeholder="Total  " id="totalGeneral"
                                        name="totalGeneral" class="form-control" min="1" data-parsley-required
                                        autocomplete="off" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <button type="submit" class="btn btn-sm btn-primary float-left m-t-n-xs" ><strong>Guardar
                                            compra</strong></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            var numeroInputs = 0;
            var arregloIdInputs = [];

            window.onload = obtenerTipoPago;
            var public_path = "{{ asset('catalogo/') }}";

            function obtenerTipoPago() {

                axios.get('/producto/tipo/pagos')
                    .then(response => {

                        let tipoDePago = response.data.tipos;

                        let htmlPagos = '  <option value="" selected disabled>--Seleccione una opcion--</option>';

                        tipoDePago.forEach(element => {

                            htmlPagos += `
                            <option value="${element.id}" >${element.descripcion}</option>                                      
                            `
                        });

                        document.getElementById('tipoPagoCompra').innerHTML = htmlPagos;

                    })
                    .catch(err => {
                        //console.log(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: "Ha ocurrido un error al obtener los tipos de pago"
                        })
                    })

            }

            $('#seleccionarProveedor').select2({
                ajax: {
                    url: '/producto/lista/proveedores',
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



            $('#seleccionarProdcuto').select2({
                ajax: {
                    url: '/producto/listar/producto',
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

            function obtenerIdProducto() {
                let id = document.getElementById('seleccionarProdcuto').value;

                this.obtenerImagenes(id)
            }

            function obtenerImagenes(id) {
                let htmlImagenes = '';
                axios.post('/producto/listar/imagenes', {
                        id: id
                    })
                    .then(response => {

                        let imagenes = response.data.imagenes;

                        if (imagenes.length == 0) {

                            console.log("entro")
                            htmlImagenes += `                                                
                            <div class="carousel-item active " >
                                <img class="d-block  " src="${public_path+'/'+'noimage.png'}" alt="noimage.png" style="width: 100%; height:20rem" >
                            </div>`

                            document.getElementById('bloqueImagenes').innerHTML = htmlImagenes;

                            var element = document.getElementById('botonAdd');
                            element.classList.remove("d-none");

                        } else {





                            imagenes.forEach(element => {



                                if (element.contador == 1) {
                                    htmlImagenes += `                                                
                            <div class="carousel-item active " >
                                <img class="d-block  " src="${public_path+'/'+element.url_img}" alt="imagen ${element.contador}" style="width: 100%; height:20rem" >
                            </div>`
                                } else {

                                    htmlImagenes += `                                                
                            <div class="carousel-item  " >
                                <img class="d-block  " src="${public_path+'/'+element.url_img}" alt="imagen ${element.contador}" style="width: 100%; height:20rem" >
                            </div>`

                                }




                            });

                            document.getElementById('bloqueImagenes').innerHTML = htmlImagenes;

                            var element = document.getElementById('botonAdd');
                            element.classList.remove("d-none");
                        }

                        return;



                    })
                    .catch(err => {

                        console.log(err);

                    })
            }

            function agregarProductoCarrito() {
                let id = document.getElementById('seleccionarProdcuto').value;

                axios.post('/prodcuto/compra/datos', {
                        id: id
                    })
                    .then(response => {
                        let producto = response.data.producto;
                        //console.log(response.data.producto);
                        numeroInputs += 1;

                        html = `
                        <div id='${numeroInputs}' class="row no-gutters">
                                            <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                <div class="d-flex">

                                                    <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(${numeroInputs})"><i
                                                            class="fa-regular fa-rectangle-xmark"></i>
                                                    </button>

                                                    <div style="width:100%">
                                                        <label for="nombre${numeroInputs}" class="sr-only">Nombre del producto</label>
                                                        <input type="text" placeholder="Nombre del producto" id="nombre${numeroInputs}"
                                                            name="nombre${numeroInputs}" class="form-control" 
                                                            data-parsley-required "
                                                            autocomplete="off"
                                                            disabled
                                                            value='${producto.nombre}'
                                                            >
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <label for="precio${numeroInputs}" class="sr-only">Precio</label>
                                                <input type="number" placeholder="Precio de unidad" id="precio${numeroInputs}"
                                                    name="precio${numeroInputs}" class="form-control" min="1" data-parsley-required step="any"
                                                    autocomplete="off" onchange="calcularTotales(precio${numeroInputs},cantidad${numeroInputs},${producto.isv},${numeroInputs})">
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <label for="cantidad${numeroInputs}" class="sr-only">cantidad</label>
                                                <input type="number" placeholder="Cantidad" id="cantidad${numeroInputs}"
                                                    name="cantidad${numeroInputs}" class="form-control" min="1" data-parsley-required
                                                    autocomplete="off" onchange="calcularTotales(precio${numeroInputs},cantidad${numeroInputs},${producto.isv},${numeroInputs})">
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <label for="subTotal${numeroInputs}" class="sr-only">Sub Total</label>
                                                <input type="number" placeholder="Sub total del producto" id="subTotal${numeroInputs}"
                                                    name="subTotal${numeroInputs}" class="form-control" min="1" step="any"
                                                    autocomplete="off"
                                                    disabled>
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                <label for="isvProducto${numeroInputs}" class="sr-only">ISV</label>
                                                <input type="number" placeholder="ISV" id="isvProducto${numeroInputs}"
                                                    name="isvProducto${numeroInputs}" class="form-control" min="1" step="any"
                                                    autocomplete="off"
                                                    disabled>
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <label for="total${numeroInputs}" class="sr-only">Total</label>
                                                <input type="number" placeholder="Total del producto" id="total${numeroInputs}"
                                                    name="total${numeroInputs}" class="form-control" min="1"  step="any"
                                                    autocomplete="off"
                                                    disabled>
                                            </div>
                                    
                        </div>
                        `;

                        arregloIdInputs.splice(numeroInputs, 0, numeroInputs);
                        document.getElementById('divProductos').insertAdjacentHTML('beforeend', html);

                        return;

                    })
                    .catch(err => {

                        console.error(err);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: "Ha ocurrido un error al agregar el producto a la compra."
                        })
                    })
            }

            function eliminarInput(id) {
                const element = document.getElementById(id);
                element.remove();


                var myIndex = arregloIdInputs.indexOf(id);
                if (myIndex !== -1) {
                    arregloIdInputs.splice(myIndex, 1);
                    this.totalesGenerales();
                }

            }

            function calcularTotales(idPrecio, idCantidad, isvProducto, id) {


                valorInputPrecio = idPrecio.value;
                valirInputCantidad = idCantidad.value;

                if (valorInputPrecio && valirInputCantidad) {

                    let subTotal = valorInputPrecio * valirInputCantidad;
                    let isv = subTotal * (isvProducto / 100);
                    let total = subTotal + subTotal * (isvProducto / 100);

                    document.getElementById('subTotal' + id).value = subTotal.toFixed(2);
                    document.getElementById('total' + id).value = total.toFixed(2);
                    document.getElementById('isvProducto' + id).value = isv.toFixed(2);

                    this.totalesGenerales();



                }


                return 0;


            }

            function totalesGenerales() {

                console.log(arregloIdInputs);



                let totalGeneralValor = new Number(0);
                let totalISV = new Number(0);
                let subTotalGeneralValor = new Number(0);


                for (let i = 0; i < arregloIdInputs.length; i++) {
                    subTotalGeneralValor += new Number(document.getElementById('subTotal' + arregloIdInputs[i]).value);
                    totalISV += new Number(document.getElementById('isvProducto' + arregloIdInputs[i]).value);
                    totalGeneralValor += new Number(document.getElementById('total' + arregloIdInputs[i]).value);

                }

                document.getElementById('subTotalGeneral').value = subTotalGeneralValor.toFixed(2);
                document.getElementById('isvGeneral').value = totalISV.toFixed(2);
                document.getElementById('totalGeneral').value = totalGeneralValor.toFixed(2);

                return 0;


            }

            function validarFechaPago() {

                let tipoPago;

                tipoPago = document.getElementById('tipoPagoCompra').value;

                if (tipoPago == 1) {
                    document.getElementById('fecha_vencimiento').disabled = false;


                } else {
                    document.getElementById('fecha_vencimiento').value = "{{ date('Y-m-d') }}";

                }

                return 0;


            }

            function retencionProveedor(){
                let idProveedor = document.getElementById('seleccionarProveedor').value;
                axios.post('/producto/compra/retencion',{idProveedor:idProveedor})
                .then( response=>{
                    let data = response.data;

                 

                         
                            Swal.fire({
                            title: data.title,
                            text:data.text,
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Aplicar',
                            denyButtonText: `No aplicar`,
                            cancelButtonText: 'Cancelar',
                            }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                Swal.fire('La retencion sera aplicada a esta compra!', '', 'success')
                            } else if (result.isDenied) {
                                Swal.fire('¡No se aplicara retencion a esta compra!', '', 'info')
                            }
                            })

         

                })
                .catch( err=>{

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: "Ha ocurrido un error al seleccionar el proveedor."
                    })

                    console.error('ha ocurrido un erro', err)

                }) 
            }

            $(document).on('submit', '#crear_compra', 
            function(event) {
            event.preventDefault();
            retencionProveedor();
            });
        </script>
    @endpush
</div>
