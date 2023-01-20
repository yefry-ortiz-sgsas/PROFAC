<div>
    @push('styles')
        <style>

      /* #divProductos  input {
        font-size: 0.8rem;


      } */


      .img-size{
       /*width: 10rem*/
       width: 100%;
       height:20rem;
       margin: 0 auto;
      }

      @media (min-width: 670px) and (max-width:767px){
        .img-size{
       /*width: 10rem*/
       width: 85%;
       height:20rem;
       margin: 0 auto;
      }
    }

      @media (min-width: 768px) and (max-width:960px){
        .img-size{
       /*width: 10rem*/
       width: 75%;
       height:12rem;
       margin: 0 auto;
       background-color: blue
      }

      }

                  /* Chrome, Safari, Edge, Opera */
                input::-webkit-outer-spin-button,
                input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
                }

                /* Firefox */
                input[type=number] {
                -moz-appearance: textfield;
                }



        </style>
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Ventas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Cliente Corporativo</a>
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
                        <form onkeydown="return event.key != 'Enter';" autocomplete="off" id="crear_venta" name="crear_venta" data-parsley-validate>

                            <input type="hidden" id="restriccion" name="restriccion" value="1">
                            <input name="idComprobante" id="idComprobante" type="hidden" value="">
                            <input type="hidden" id="codigo_autorizacion" name="codigo_autorizacion" value="">
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                                        <label class="col-form-label text-danger" for="numero_venta"
                                            style="font-size: 1.5rem; font-weight:600;">Numero de Venta</label>
                                    </div>

                                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                                        <input class="form-control" style="font-size: 1.5rem; font-weight:600; text-align:center" type="text" id="numero_venta" name="numero_venta"
                                        value="" data-parsley-required readonly>
                                    </div>



                                </div>

                            <div class="row  mt-4 mb-4">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                      <label for="vendedor">Seleccionar Vendedor:<span class="text-danger">*</span> </label>
                                      <select name="vendedor" id="vendedor" class="form-group form-control" required>
                                        <option value="" selected disabled>--Seleccionar un vendedor--</option>
                                      </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label for="seleccionarCliente" class="col-form-label focus-label">Seleccionar
                                        Cliente:<span class="text-danger">*</span> </label>
                                    <select id="seleccionarCliente" name="seleccionarCliente" class="form-group form-control" style=""
                                        data-parsley-required onchange="obtenerDatosCliente()">
                                        <option value="" selected disabled>--Seleccionar un cliente--</option>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label class="col-form-label focus-label">Nombre del cliente:<span class="text-danger">*</span></label>
                                    <input class="form-control" required type="text" id="nombre_cliente_ventas" name="nombre_cliente_ventas"
                                        data-parsley-required readonly>

                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label class="col-form-label focus-label">RTN:<span class="text-danger">*</span></label>
                                    <input class="form-control"  type="text" id="rtn_ventas" name="rtn_ventas"
                                    readonly>

                                </div>





                            </div>

                            <div class="row mt-4">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label for="tipoPagoVenta" class="col-form-label focus-label">Seleccionar tipo de
                                        pago:<span class="text-danger">*</span></label>
                                    <select class="form-group form-control " name="tipoPagoVenta" id="tipoPagoVenta"
                                        data-parsley-required onchange="validarFechaPago()">
                                    </select>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">

                                        <label for="fecha_emision" class="col-form-label focus-label">Fecha de emisión
                                            :<span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" id="fecha_emision" onchange="sumarDiasCredito()"
                                            name="fecha_emision" value="{{ date('Y-m-d') }}" data-parsley-required>

                                    </div>
                                </div>


                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label for="fecha_vencimiento"
                                            class="col-form-label focus-label text-warning">Fecha de vencimiento:
                                        </label>
                                        <input class="form-control" type="date" id="fecha_vencimiento"
                                            name="fecha_vencimiento" value="" data-parsley-required
                                            min="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>


                            </div>

                            <div class="row">



                            </div>

                            <div class="row mt-4">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">


                                            <label for="seleccionarProducto" class="col-form-label focus-label">Seleccionar Producto:<span class="text-danger">*</span></label>
                                            <select id="seleccionarProducto" name="seleccionarProducto" class="form-group form-control" style=""
                                                 onchange="obtenerImagenes()">
                                                <option value="" selected disabled>--Seleccione un producto--</option>
                                            </select>




                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">

                                        <label for="bodega" class="col-form-label focus-label">Seleccionar bodega:<span class="text-danger">*</span></label>
                                        <select id="bodega" name="bodega" class="form-group form-control" style=""
                                            onchange="prueba()"  disabled
                                        >
                                            <option value="" selected disabled>--Seleccione un producto--</option>
                                        </select>


                                </div>


                            </div>

                            <div class="row">


                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4" >
                                    <div class="text-center">
                                        <a id="detalleProducto" href="" class="font-bold h3  d-none text-success" style="" target="_blank"> <i class="fa-solid fa-circle-info"></i> Ver Detalles De Producto </a>
                                    </div>


                                    <div id="carouselProducto" class="carousel slide mt-2" data-ride="carousel">
                                        {{-- <ol  id="carousel_imagenes_producto" class="carousel-indicators">

                                                <li data-target="#carouselProducto" data-slide-to="{{ $i }}" class="active"></li>

                                                <li data-target="#carouselProducto" data-slide-to="{{ $i }}" class=""></li>



                                        </ol> --}}
                                        <div id="bloqueImagenes" class="carousel-inner " >






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

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 " >
                                    <div id="botonAdd"
                                    class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-4 text-center d-none">
                                    <button type="button" class="btn-rounded btn btn-success p-3"
                                        style="font-weight: 900; " onclick="agregarProductoCarrito()">Añadir
                                        Producto a venta <i class="fa-solid fa-cart-plus"></i> </button>

                                </div>

                            </div>

                            </div>

                            <hr>

                            <div class="hide-container">
                                <p>Nota:El campo "Unidad" describe la unidad de medida para la venta del producto - seguido del numero de unidades a restar del inventario</p>
                                <div class="row no-gutters ">

                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <div class="d-flex">



                                            <div style="width:100%">
                                                <label class="sr-only">Nombre del
                                                    producto</label>
                                                <input type="text" placeholder="Nombre del producto"
                                                    class="form-control" pattern="[A-Z]{1}"
                                                   disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg- col-xl-1">
                                        <label class="sr-only">Bodega</label>
                                        <input type="number" placeholder="Bodega" class="form-control"
                                            autocomplete="off" disabled>
                                    </div>

                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg- col-xl-1">
                                        <label class="sr-only">Precio</label>
                                        <input type="number" placeholder="Precio Unidad" class="form-control"
                                            min="1" autocomplete="off" disabled>
                                    </div>

                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                        <label class="sr-only">cantidad</label>
                                        <input type="text" placeholder="Cantidad" class="form-control" min="1"
                                            autocomplete="off" disabled>
                                    </div>

                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 ">

                                        <label class="sr-only">Unidad</label>
                                        <input type="text" placeholder="Unidad " class="form-control"
                                            min="1" autocomplete="off" disabled>




                                    </div>


                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <label class="sr-only">Sub Total</label>
                                        <input type="number" placeholder="Sub total del producto" class="form-control"
                                            min="1" autocomplete="off" disabled>
                                    </div>

                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <label class="sr-only">ISV</label>
                                        <input type="number" placeholder="ISV" class="form-control" min="1"
                                            autocomplete="off" disabled>
                                    </div>

                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                        <label class="sr-only">Total</label>
                                        <input type="number" placeholder="Total del producto" class="form-control"
                                            min="1" disabled autocomplete="off">
                                    </div>

                                </div>



                            </div>

                            <div id="divProductos">


                                <div id="1" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(1)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto1" name="idProducto1" type="hidden" value="1002">

                                                            <div style="width:100%">
                                                                <label for="nombre1" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre1" name="nombre1" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1002 - BASURERO METALICO DE PEDAL MODELO H1002 20L. WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega1" name="bodega1" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio1" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio1" name="precio1" value="310.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="310.00" onchange="calcularTotales(precio1,cantidad1,15,unidad1,1,restaInventario1)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad1" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad1" name="cantidad1" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio1,cantidad1,15,unidad1,1,restaInventario1)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad1" id="unidad1" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio1,cantidad1,15,unidad1,1,restaInventario1)">
                                                                    <option selected="" value="1" data-id="3">UNIDAD-1</option><option value="1" data-id="1222">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar1" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar1" name="subTotalMostrar1" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal1" name="subTotal1" type="hidden" value="310.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar1" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar1" name="isvProductoMostrar1" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto1" name="isvProducto1" type="hidden" value="46.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar1" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar1" name="totalMostrar1" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total1" name="total1" type="hidden" value="356.500" required="">


                                                    </div>

                                                    <input id="idBodega1" name="idBodega1" type="hidden" value="5">
                                                    <input id="idSeccion1" name="idSeccion1" type="hidden" value="37">
                                                    <input id="restaInventario1" name="restaInventario1" type="hidden" value="1">
                                                    <input id="isv1" name="isv1" type="hidden" value="15">



                                </div>

                                <div id="2" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(2)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto2" name="idProducto2" type="hidden" value="1004">

                                                            <div style="width:100%">
                                                                <label for="nombre2" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre2" name="nombre2" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1004 - BLOCK DE CARTULINA 20H 45286 ARCOIRIS T/CARTA ARIMANY">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 E 2" placeholder="bodega-seccion" id="bodega2" name="bodega2" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio2" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio2" name="precio2" value="24.39" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="24.39" onchange="calcularTotales(precio2,cantidad2,15,unidad2,2,restaInventario2)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad2" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad2" name="cantidad2" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio2,cantidad2,15,unidad2,2,restaInventario2)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad2" id="unidad2" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio2,cantidad2,15,unidad2,2,restaInventario2)">
                                                                    <option selected="" value="1" data-id="5">UNIDAD-1</option><option value="1" data-id="1224">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar2" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar2" name="subTotalMostrar2" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal2" name="subTotal2" type="hidden" value="24.390" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar2" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar2" name="isvProductoMostrar2" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto2" name="isvProducto2" type="hidden" value="3.659" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar2" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar2" name="totalMostrar2" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total2" name="total2" type="hidden" value="28.049" required="">


                                                    </div>

                                                    <input id="idBodega2" name="idBodega2" type="hidden" value="7">
                                                    <input id="idSeccion2" name="idSeccion2" type="hidden" value="63">
                                                    <input id="restaInventario2" name="restaInventario2" type="hidden" value="1">
                                                    <input id="isv2" name="isv2" type="hidden" value="15">



                                </div>

                                <div id="3" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(3)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto3" name="idProducto3" type="hidden" value="1006">

                                                            <div style="width:100%">
                                                                <label for="nombre3" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre3" name="nombre3" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1006 - PAPEL BOND CONTOMETRO 2-1/4 OFINOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 B 1" placeholder="bodega-seccion" id="bodega3" name="bodega3" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio3" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio3" name="precio3" value="8.40" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="8.40" onchange="calcularTotales(precio3,cantidad3,15,unidad3,3,restaInventario3)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad3" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad3" name="cantidad3" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio3,cantidad3,15,unidad3,3,restaInventario3)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad3" id="unidad3" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio3,cantidad3,15,unidad3,3,restaInventario3)">
                                                                    <option selected="" value="1" data-id="7"> ROLLO-1</option><option value="100" data-id="1226"> CAJA-100</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar3" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar3" name="subTotalMostrar3" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal3" name="subTotal3" type="hidden" value="8.400" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar3" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar3" name="isvProductoMostrar3" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto3" name="isvProducto3" type="hidden" value="1.260" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar3" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar3" name="totalMostrar3" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total3" name="total3" type="hidden" value="9.660" required="">


                                                    </div>

                                                    <input id="idBodega3" name="idBodega3" type="hidden" value="6">
                                                    <input id="idSeccion3" name="idSeccion3" type="hidden" value="38">
                                                    <input id="restaInventario3" name="restaInventario3" type="hidden" value="1">
                                                    <input id="isv3" name="isv3" type="hidden" value="15">



                                </div>

                                <div id="4" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(4)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto4" name="idProducto4" type="hidden" value="1008">

                                                            <div style="width:100%">
                                                                <label for="nombre4" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre4" name="nombre4" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1008 - UNICO LARGO DE 200 PAGINAS DVALENCIA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 B 1" placeholder="bodega-seccion" id="bodega4" name="bodega4" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio4" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio4" name="precio4" value="44.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="44.50" onchange="calcularTotales(precio4,cantidad4,0,unidad4,4,restaInventario4)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad4" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad4" name="cantidad4" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio4,cantidad4,0,unidad4,4,restaInventario4)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad4" id="unidad4" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio4,cantidad4,0,unidad4,4,restaInventario4)">
                                                                    <option selected="" value="1" data-id="9">UNIDAD-1</option><option value="1" data-id="1228">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar4" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar4" name="subTotalMostrar4" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal4" name="subTotal4" type="hidden" value="44.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar4" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar4" name="isvProductoMostrar4" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto4" name="isvProducto4" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar4" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar4" name="totalMostrar4" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total4" name="total4" type="hidden" value="44.500" required="">


                                                    </div>

                                                    <input id="idBodega4" name="idBodega4" type="hidden" value="6">
                                                    <input id="idSeccion4" name="idSeccion4" type="hidden" value="38">
                                                    <input id="restaInventario4" name="restaInventario4" type="hidden" value="1">
                                                    <input id="isv4" name="isv4" type="hidden" value="0">



                                </div>

                                <div id="5" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(5)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto5" name="idProducto5" type="hidden" value="1009">

                                                            <div style="width:100%">
                                                                <label for="nombre5" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre5" name="nombre5" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1009 - DISPENSADOR DE GEL MANUAL (SD934W) COLOR BLANCO HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 B 1" placeholder="bodega-seccion" id="bodega5" name="bodega5" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio5" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio5" name="precio5" value="375.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="375.00" onchange="calcularTotales(precio5,cantidad5,15,unidad5,5,restaInventario5)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad5" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad5" name="cantidad5" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio5,cantidad5,15,unidad5,5,restaInventario5)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad5" id="unidad5" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio5,cantidad5,15,unidad5,5,restaInventario5)">
                                                                    <option selected="" value="1" data-id="10"> UNIDAD-1</option><option value="1" data-id="1229">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar5" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar5" name="subTotalMostrar5" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal5" name="subTotal5" type="hidden" value="375.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar5" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar5" name="isvProductoMostrar5" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto5" name="isvProducto5" type="hidden" value="56.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar5" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar5" name="totalMostrar5" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total5" name="total5" type="hidden" value="431.250" required="">


                                                    </div>

                                                    <input id="idBodega5" name="idBodega5" type="hidden" value="6">
                                                    <input id="idSeccion5" name="idSeccion5" type="hidden" value="38">
                                                    <input id="restaInventario5" name="restaInventario5" type="hidden" value="1">
                                                    <input id="isv5" name="isv5" type="hidden" value="15">



                                </div>

                                <div id="6" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(6)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto6" name="idProducto6" type="hidden" value="1012">

                                                            <div style="width:100%">
                                                                <label for="nombre6" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre6" name="nombre6" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1012 - DISPENSADOR JABÓN LÍQUIDO MANUAL SD927B AHUMADO HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega6" name="bodega6" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio6" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio6" name="precio6" value="375.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="375.00" onchange="calcularTotales(precio6,cantidad6,15,unidad6,6,restaInventario6)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad6" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad6" name="cantidad6" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio6,cantidad6,15,unidad6,6,restaInventario6)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad6" id="unidad6" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio6,cantidad6,15,unidad6,6,restaInventario6)">
                                                                    <option selected="" value="1" data-id="13"> UNIDAD-1</option><option value="1" data-id="1232">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar6" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar6" name="subTotalMostrar6" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal6" name="subTotal6" type="hidden" value="375.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar6" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar6" name="isvProductoMostrar6" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto6" name="isvProducto6" type="hidden" value="56.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar6" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar6" name="totalMostrar6" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total6" name="total6" type="hidden" value="431.250" required="">


                                                    </div>

                                                    <input id="idBodega6" name="idBodega6" type="hidden" value="5">
                                                    <input id="idSeccion6" name="idSeccion6" type="hidden" value="37">
                                                    <input id="restaInventario6" name="restaInventario6" type="hidden" value="1">
                                                    <input id="isv6" name="isv6" type="hidden" value="15">



                                </div>

                                <div id="7" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(7)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto7" name="idProducto7" type="hidden" value="1013">

                                                            <div style="width:100%">
                                                                <label for="nombre7" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre7" name="nombre7" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1013 - DISPENSADOR JABÓN LÍQUIDO MANUAL SD927W TRANSPARENTE HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega7" name="bodega7" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio7" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio7" name="precio7" value="375.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="375.00" onchange="calcularTotales(precio7,cantidad7,15,unidad7,7,restaInventario7)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad7" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad7" name="cantidad7" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio7,cantidad7,15,unidad7,7,restaInventario7)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad7" id="unidad7" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio7,cantidad7,15,unidad7,7,restaInventario7)">
                                                                    <option selected="" value="1" data-id="14">UNIDAD-1</option><option value="1" data-id="1233">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar7" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar7" name="subTotalMostrar7" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal7" name="subTotal7" type="hidden" value="375.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar7" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar7" name="isvProductoMostrar7" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto7" name="isvProducto7" type="hidden" value="56.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar7" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar7" name="totalMostrar7" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total7" name="total7" type="hidden" value="431.250" required="">


                                                    </div>

                                                    <input id="idBodega7" name="idBodega7" type="hidden" value="5">
                                                    <input id="idSeccion7" name="idSeccion7" type="hidden" value="37">
                                                    <input id="restaInventario7" name="restaInventario7" type="hidden" value="1">
                                                    <input id="isv7" name="isv7" type="hidden" value="15">



                                </div>

                                <div id="8" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(8)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto8" name="idProducto8" type="hidden" value="1014">

                                                            <div style="width:100%">
                                                                <label for="nombre8" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre8" name="nombre8" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1014 - DISPENSADOR PAPEL TOALLA INTERDOBLADA PD536W BLANCO HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 G1" placeholder="bodega-seccion" id="bodega8" name="bodega8" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio8" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio8" name="precio8" value="375.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="375.00" onchange="calcularTotales(precio8,cantidad8,15,unidad8,8,restaInventario8)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad8" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad8" name="cantidad8" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio8,cantidad8,15,unidad8,8,restaInventario8)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad8" id="unidad8" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio8,cantidad8,15,unidad8,8,restaInventario8)">
                                                                    <option selected="" value="1" data-id="15">UNIDAD-1</option><option value="1" data-id="1234">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar8" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar8" name="subTotalMostrar8" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal8" name="subTotal8" type="hidden" value="375.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar8" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar8" name="isvProductoMostrar8" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto8" name="isvProducto8" type="hidden" value="56.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar8" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar8" name="totalMostrar8" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total8" name="total8" type="hidden" value="431.250" required="">


                                                    </div>

                                                    <input id="idBodega8" name="idBodega8" type="hidden" value="6">
                                                    <input id="idSeccion8" name="idSeccion8" type="hidden" value="123">
                                                    <input id="restaInventario8" name="restaInventario8" type="hidden" value="1">
                                                    <input id="isv8" name="isv8" type="hidden" value="15">



                                </div>

                                <div id="9" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(9)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto9" name="idProducto9" type="hidden" value="1015">

                                                            <div style="width:100%">
                                                                <label for="nombre9" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre9" name="nombre9" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1015 - DISPENSADOR PLASTICO PARA VASOS (PD407) HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 G3" placeholder="bodega-seccion" id="bodega9" name="bodega9" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio9" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio9" name="precio9" value="395.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="395.00" onchange="calcularTotales(precio9,cantidad9,15,unidad9,9,restaInventario9)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad9" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad9" name="cantidad9" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio9,cantidad9,15,unidad9,9,restaInventario9)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad9" id="unidad9" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio9,cantidad9,15,unidad9,9,restaInventario9)">
                                                                    <option selected="" value="1" data-id="16"> UNIDAD-1</option><option value="1" data-id="1235">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar9" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar9" name="subTotalMostrar9" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal9" name="subTotal9" type="hidden" value="395.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar9" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar9" name="isvProductoMostrar9" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto9" name="isvProducto9" type="hidden" value="59.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar9" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar9" name="totalMostrar9" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total9" name="total9" type="hidden" value="454.250" required="">


                                                    </div>

                                                    <input id="idBodega9" name="idBodega9" type="hidden" value="6">
                                                    <input id="idSeccion9" name="idSeccion9" type="hidden" value="125">
                                                    <input id="restaInventario9" name="restaInventario9" type="hidden" value="1">
                                                    <input id="isv9" name="isv9" type="hidden" value="15">



                                </div>

                                <div id="10" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(10)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto10" name="idProducto10" type="hidden" value="1016">

                                                            <div style="width:100%">
                                                                <label for="nombre10" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre10" name="nombre10" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1016 - ENGRAPADORA STANDARD MILLENIUM 11-2000-20 MIL010 WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 G 1" placeholder="bodega-seccion" id="bodega10" name="bodega10" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio10" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio10" name="precio10" value="119.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="119.50" onchange="calcularTotales(precio10,cantidad10,15,unidad10,10,restaInventario10)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad10" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad10" name="cantidad10" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio10,cantidad10,15,unidad10,10,restaInventario10)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad10" id="unidad10" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio10,cantidad10,15,unidad10,10,restaInventario10)">
                                                                    <option selected="" value="1" data-id="17"> UNIDAD-1</option><option value="1" data-id="1236">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar10" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar10" name="subTotalMostrar10" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal10" name="subTotal10" type="hidden" value="119.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar10" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar10" name="isvProductoMostrar10" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto10" name="isvProducto10" type="hidden" value="17.925" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar10" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar10" name="totalMostrar10" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total10" name="total10" type="hidden" value="137.425" required="">


                                                    </div>

                                                    <input id="idBodega10" name="idBodega10" type="hidden" value="8">
                                                    <input id="idSeccion10" name="idSeccion10" type="hidden" value="112">
                                                    <input id="restaInventario10" name="restaInventario10" type="hidden" value="1">
                                                    <input id="isv10" name="isv10" type="hidden" value="15">



                                </div>

                                <div id="11" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(11)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto11" name="idProducto11" type="hidden" value="1017">

                                                            <div style="width:100%">
                                                                <label for="nombre11" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre11" name="nombre11" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1017 - FLEJE ESTRECH FILM PARA PAPELIZAR BESTAPE">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 5 B 5" placeholder="bodega-seccion" id="bodega11" name="bodega11" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio11" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio11" name="precio11" value="145.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="145.00" onchange="calcularTotales(precio11,cantidad11,15,unidad11,11,restaInventario11)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad11" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad11" name="cantidad11" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio11,cantidad11,15,unidad11,11,restaInventario11)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad11" id="unidad11" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio11,cantidad11,15,unidad11,11,restaInventario11)">
                                                                    <option selected="" value="1" data-id="18"> ROLLO-1</option><option value="1" data-id="1237">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar11" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar11" name="subTotalMostrar11" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal11" name="subTotal11" type="hidden" value="145.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar11" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar11" name="isvProductoMostrar11" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto11" name="isvProducto11" type="hidden" value="21.750" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar11" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar11" name="totalMostrar11" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total11" name="total11" type="hidden" value="166.750" required="">


                                                    </div>

                                                    <input id="idBodega11" name="idBodega11" type="hidden" value="1">
                                                    <input id="idSeccion11" name="idSeccion11" type="hidden" value="5">
                                                    <input id="restaInventario11" name="restaInventario11" type="hidden" value="1">
                                                    <input id="isv11" name="isv11" type="hidden" value="15">



                                </div>

                                <div id="12" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(12)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto12" name="idProducto12" type="hidden" value="1019">

                                                            <div style="width:100%">
                                                                <label for="nombre12" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre12" name="nombre12" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1019 - FOLDER T/OFICIO DE COLOR NARANJA ARCOLOR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 F 1" placeholder="bodega-seccion" id="bodega12" name="bodega12" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio12" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio12" name="precio12" value="260.86" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="260.86" onchange="calcularTotales(precio12,cantidad12,15,unidad12,12,restaInventario12)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad12" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad12" name="cantidad12" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio12,cantidad12,15,unidad12,12,restaInventario12)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad12" id="unidad12" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio12,cantidad12,15,unidad12,12,restaInventario12)">
                                                                    <option selected="" value="1" data-id="20"> RESMA-1</option><option value="1" data-id="1239">POR DEFECTO-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar12" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar12" name="subTotalMostrar12" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal12" name="subTotal12" type="hidden" value="260.860" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar12" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar12" name="isvProductoMostrar12" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto12" name="isvProducto12" type="hidden" value="39.129" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar12" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar12" name="totalMostrar12" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total12" name="total12" type="hidden" value="299.989" required="">


                                                    </div>

                                                    <input id="idBodega12" name="idBodega12" type="hidden" value="6">
                                                    <input id="idSeccion12" name="idSeccion12" type="hidden" value="40">
                                                    <input id="restaInventario12" name="restaInventario12" type="hidden" value="1">
                                                    <input id="isv12" name="isv12" type="hidden" value="15">



                                </div>

                                <div id="13" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(13)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto13" name="idProducto13" type="hidden" value="1024">

                                                            <div style="width:100%">
                                                                <label for="nombre13" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre13" name="nombre13" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1024 - HOJAS PARA FOLDER BOND 60 PERFORADO T/CARTA ARIMANY">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 E 1" placeholder="bodega-seccion" id="bodega13" name="bodega13" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio13" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio13" name="precio13" value="18.85" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="18.85" onchange="calcularTotales(precio13,cantidad13,15,unidad13,13,restaInventario13)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad13" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad13" name="cantidad13" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio13,cantidad13,15,unidad13,13,restaInventario13)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad13" id="unidad13" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio13,cantidad13,15,unidad13,13,restaInventario13)">
                                                                    <option selected="" value="1" data-id="25"> PAQUETE-1</option><option value="1" data-id="1244">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar13" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar13" name="subTotalMostrar13" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal13" name="subTotal13" type="hidden" value="18.850" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar13" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar13" name="isvProductoMostrar13" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto13" name="isvProducto13" type="hidden" value="2.828" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar13" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar13" name="totalMostrar13" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total13" name="total13" type="hidden" value="21.678" required="">


                                                    </div>

                                                    <input id="idBodega13" name="idBodega13" type="hidden" value="8">
                                                    <input id="idSeccion13" name="idSeccion13" type="hidden" value="102">
                                                    <input id="restaInventario13" name="restaInventario13" type="hidden" value="1">
                                                    <input id="isv13" name="isv13" type="hidden" value="15">



                                </div>

                                <div id="14" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(14)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto14" name="idProducto14" type="hidden" value="1025">

                                                            <div style="width:100%">
                                                                <label for="nombre14" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre14" name="nombre14" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1025 - JABON EN BARRA SURF">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 J1" placeholder="bodega-seccion" id="bodega14" name="bodega14" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio14" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio14" name="precio14" value="13.32" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="13.32" onchange="calcularTotales(precio14,cantidad14,15,unidad14,14,restaInventario14)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad14" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad14" name="cantidad14" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio14,cantidad14,15,unidad14,14,restaInventario14)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad14" id="unidad14" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio14,cantidad14,15,unidad14,14,restaInventario14)">
                                                                    <option selected="" value="1" data-id="26">UNIDAD-1</option><option value="1" data-id="1245">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar14" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar14" name="subTotalMostrar14" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal14" name="subTotal14" type="hidden" value="13.320" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar14" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar14" name="isvProductoMostrar14" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto14" name="isvProducto14" type="hidden" value="1.998" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar14" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar14" name="totalMostrar14" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total14" name="total14" type="hidden" value="15.318" required="">


                                                    </div>

                                                    <input id="idBodega14" name="idBodega14" type="hidden" value="7">
                                                    <input id="idSeccion14" name="idSeccion14" type="hidden" value="142">
                                                    <input id="restaInventario14" name="restaInventario14" type="hidden" value="1">
                                                    <input id="isv14" name="isv14" type="hidden" value="15">



                                </div>

                                <div id="15" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(15)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto15" name="idProducto15" type="hidden" value="1027">

                                                            <div style="width:100%">
                                                                <label for="nombre15" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre15" name="nombre15" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1027 - CORRECTOR EN LAPIZ WEX CTD08 7ML">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 C 3" placeholder="bodega-seccion" id="bodega15" name="bodega15" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio15" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio15" name="precio15" value="9.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="9.50" onchange="calcularTotales(precio15,cantidad15,15,unidad15,15,restaInventario15)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad15" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad15" name="cantidad15" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio15,cantidad15,15,unidad15,15,restaInventario15)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad15" id="unidad15" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio15,cantidad15,15,unidad15,15,restaInventario15)">
                                                                    <option selected="" value="1" data-id="28">UNIDAD-1</option><option value="1" data-id="1247">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar15" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar15" name="subTotalMostrar15" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal15" name="subTotal15" type="hidden" value="9.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar15" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar15" name="isvProductoMostrar15" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto15" name="isvProducto15" type="hidden" value="1.425" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar15" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar15" name="totalMostrar15" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total15" name="total15" type="hidden" value="10.925" required="">


                                                    </div>

                                                    <input id="idBodega15" name="idBodega15" type="hidden" value="7">
                                                    <input id="idSeccion15" name="idSeccion15" type="hidden" value="54">
                                                    <input id="restaInventario15" name="restaInventario15" type="hidden" value="1">
                                                    <input id="isv15" name="isv15" type="hidden" value="15">



                                </div>

                                <div id="16" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(16)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto16" name="idProducto16" type="hidden" value="1110">

                                                            <div style="width:100%">
                                                                <label for="nombre16" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre16" name="nombre16" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1110 - BINDER CLIPS 1 5/8 41MM MARIPOSA PRENSA PAPEL BS-1169 BENSSINI">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 B 3" placeholder="bodega-seccion" id="bodega16" name="bodega16" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio16" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio16" name="precio16" value="2.04" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="2.04" onchange="calcularTotales(precio16,cantidad16,15,unidad16,16,restaInventario16)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad16" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad16" name="cantidad16" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio16,cantidad16,15,unidad16,16,restaInventario16)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad16" id="unidad16" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio16,cantidad16,15,unidad16,16,restaInventario16)">
                                                                    <option selected="" value="1" data-id="111">UNIDAD-1</option><option value="1" data-id="1330">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar16" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar16" name="subTotalMostrar16" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal16" name="subTotal16" type="hidden" value="2.040" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar16" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar16" name="isvProductoMostrar16" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto16" name="isvProducto16" type="hidden" value="0.306" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar16" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar16" name="totalMostrar16" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total16" name="total16" type="hidden" value="2.346" required="">


                                                    </div>

                                                    <input id="idBodega16" name="idBodega16" type="hidden" value="8">
                                                    <input id="idSeccion16" name="idSeccion16" type="hidden" value="89">
                                                    <input id="restaInventario16" name="restaInventario16" type="hidden" value="1">
                                                    <input id="isv16" name="isv16" type="hidden" value="15">



                                </div>

                                <div id="17" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(17)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto17" name="idProducto17" type="hidden" value="1102">

                                                            <div style="width:100%">
                                                                <label for="nombre17" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre17" name="nombre17" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1102 - BINDER BASICO 1 BLANCO DVALENCIA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 A 1" placeholder="bodega-seccion" id="bodega17" name="bodega17" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio17" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio17" name="precio17" value="28.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="28.00" onchange="calcularTotales(precio17,cantidad17,15,unidad17,17,restaInventario17)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad17" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad17" name="cantidad17" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio17,cantidad17,15,unidad17,17,restaInventario17)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad17" id="unidad17" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio17,cantidad17,15,unidad17,17,restaInventario17)">
                                                                    <option selected="" value="1" data-id="103">UNIDAD-1</option><option value="1" data-id="1322">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar17" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar17" name="subTotalMostrar17" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal17" name="subTotal17" type="hidden" value="28.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar17" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar17" name="isvProductoMostrar17" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto17" name="isvProducto17" type="hidden" value="4.200" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar17" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar17" name="totalMostrar17" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total17" name="total17" type="hidden" value="32.200" required="">


                                                    </div>

                                                    <input id="idBodega17" name="idBodega17" type="hidden" value="8">
                                                    <input id="idSeccion17" name="idSeccion17" type="hidden" value="82">
                                                    <input id="restaInventario17" name="restaInventario17" type="hidden" value="1">
                                                    <input id="isv17" name="isv17" type="hidden" value="15">



                                </div>

                                <div id="18" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(18)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto18" name="idProducto18" type="hidden" value="1103">

                                                            <div style="width:100%">
                                                                <label for="nombre18" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre18" name="nombre18" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1103 - BINDER BASICO 1 COLOR NEGRO DVALENCIA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 A 3" placeholder="bodega-seccion" id="bodega18" name="bodega18" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio18" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio18" name="precio18" value="35.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="35.00" onchange="calcularTotales(precio18,cantidad18,15,unidad18,18,restaInventario18)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad18" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad18" name="cantidad18" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio18,cantidad18,15,unidad18,18,restaInventario18)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad18" id="unidad18" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio18,cantidad18,15,unidad18,18,restaInventario18)">
                                                                    <option selected="" value="1" data-id="104">UNIDAD-1</option><option value="1" data-id="1323">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar18" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar18" name="subTotalMostrar18" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal18" name="subTotal18" type="hidden" value="35.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar18" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar18" name="isvProductoMostrar18" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto18" name="isvProducto18" type="hidden" value="5.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar18" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar18" name="totalMostrar18" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total18" name="total18" type="hidden" value="40.250" required="">


                                                    </div>

                                                    <input id="idBodega18" name="idBodega18" type="hidden" value="8">
                                                    <input id="idSeccion18" name="idSeccion18" type="hidden" value="84">
                                                    <input id="restaInventario18" name="restaInventario18" type="hidden" value="1">
                                                    <input id="isv18" name="isv18" type="hidden" value="15">



                                </div>

                                <div id="19" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(19)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto19" name="idProducto19" type="hidden" value="1067">

                                                            <div style="width:100%">
                                                                <label for="nombre19" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre19" name="nombre19" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1067 - ARCHIVADOR T/C CONCEPT PLUS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 B 1" placeholder="bodega-seccion" id="bodega19" name="bodega19" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio19" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio19" name="precio19" value="32.16" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="32.16" onchange="calcularTotales(precio19,cantidad19,15,unidad19,19,restaInventario19)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad19" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad19" name="cantidad19" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio19,cantidad19,15,unidad19,19,restaInventario19)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad19" id="unidad19" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio19,cantidad19,15,unidad19,19,restaInventario19)">
                                                                    <option selected="" value="1" data-id="68">UNIDAD-1</option><option value="1" data-id="1287">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar19" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar19" name="subTotalMostrar19" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal19" name="subTotal19" type="hidden" value="32.160" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar19" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar19" name="isvProductoMostrar19" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto19" name="isvProducto19" type="hidden" value="4.824" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar19" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar19" name="totalMostrar19" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total19" name="total19" type="hidden" value="36.984" required="">


                                                    </div>

                                                    <input id="idBodega19" name="idBodega19" type="hidden" value="6">
                                                    <input id="idSeccion19" name="idSeccion19" type="hidden" value="38">
                                                    <input id="restaInventario19" name="restaInventario19" type="hidden" value="1">
                                                    <input id="isv19" name="isv19" type="hidden" value="15">



                                </div>

                                <div id="20" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(20)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto20" name="idProducto20" type="hidden" value="1295">

                                                            <div style="width:100%">
                                                                <label for="nombre20" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre20" name="nombre20" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1295 - CUADERNO COSIDO 200 PAG BIKE OFI-NOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 B 1" placeholder="bodega-seccion" id="bodega20" name="bodega20" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio20" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio20" name="precio20" value="14.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="14.50" onchange="calcularTotales(precio20,cantidad20,0,unidad20,20,restaInventario20)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad20" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad20" name="cantidad20" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio20,cantidad20,0,unidad20,20,restaInventario20)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad20" id="unidad20" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio20,cantidad20,0,unidad20,20,restaInventario20)">
                                                                    <option selected="" value="1" data-id="296">UNIDAD-1</option><option value="1" data-id="1515">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar20" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar20" name="subTotalMostrar20" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal20" name="subTotal20" type="hidden" value="14.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar20" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar20" name="isvProductoMostrar20" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto20" name="isvProducto20" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar20" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar20" name="totalMostrar20" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total20" name="total20" type="hidden" value="14.500" required="">


                                                    </div>

                                                    <input id="idBodega20" name="idBodega20" type="hidden" value="6">
                                                    <input id="idSeccion20" name="idSeccion20" type="hidden" value="38">
                                                    <input id="restaInventario20" name="restaInventario20" type="hidden" value="1">
                                                    <input id="isv20" name="isv20" type="hidden" value="0">



                                </div>

                                <div id="21" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(21)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto21" name="idProducto21" type="hidden" value="1223">

                                                            <div style="width:100%">
                                                                <label for="nombre21" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre21" name="nombre21" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1223 - CARTULINA SENCILLA COLOR PINK PINDO CARD">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 A 2" placeholder="bodega-seccion" id="bodega21" name="bodega21" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio21" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio21" name="precio21" value="2.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="2.50" onchange="calcularTotales(precio21,cantidad21,15,unidad21,21,restaInventario21)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad21" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad21" name="cantidad21" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio21,cantidad21,15,unidad21,21,restaInventario21)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad21" id="unidad21" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio21,cantidad21,15,unidad21,21,restaInventario21)">
                                                                    <option selected="" value="100" data-id="224"> RESMA-100</option><option value="1" data-id="1443"> PLIEGO-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar21" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar21" name="subTotalMostrar21" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal21" name="subTotal21" type="hidden" value="250.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar21" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar21" name="isvProductoMostrar21" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto21" name="isvProducto21" type="hidden" value="37.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar21" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar21" name="totalMostrar21" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total21" name="total21" type="hidden" value="287.500" required="">


                                                    </div>

                                                    <input id="idBodega21" name="idBodega21" type="hidden" value="7">
                                                    <input id="idSeccion21" name="idSeccion21" type="hidden" value="43">
                                                    <input id="restaInventario21" name="restaInventario21" type="hidden" value="100">
                                                    <input id="isv21" name="isv21" type="hidden" value="15">



                                </div>

                                <div id="22" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(22)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto22" name="idProducto22" type="hidden" value="2254">

                                                            <div style="width:100%">
                                                                <label for="nombre22" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre22" name="nombre22" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2254 - PAPEL TOALLA JUMBO ROLL 305 MTS PREMIUM TAD COLA BLANCA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 3 B 3" placeholder="bodega-seccion" id="bodega22" name="bodega22" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio22" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio22" name="precio22" value="250.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="250.00" onchange="calcularTotales(precio22,cantidad22,15,unidad22,22,restaInventario22)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad22" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad22" name="cantidad22" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio22,cantidad22,15,unidad22,22,restaInventario22)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad22" id="unidad22" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio22,cantidad22,15,unidad22,22,restaInventario22)">
                                                                    <option selected="" value="1" data-id="2482"> ROLLO-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar22" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar22" name="subTotalMostrar22" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal22" name="subTotal22" type="hidden" value="250.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar22" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar22" name="isvProductoMostrar22" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto22" name="isvProducto22" type="hidden" value="37.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar22" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar22" name="totalMostrar22" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total22" name="total22" type="hidden" value="287.500" required="">


                                                    </div>

                                                    <input id="idBodega22" name="idBodega22" type="hidden" value="3">
                                                    <input id="idSeccion22" name="idSeccion22" type="hidden" value="25">
                                                    <input id="restaInventario22" name="restaInventario22" type="hidden" value="1">
                                                    <input id="isv22" name="isv22" type="hidden" value="15">



                                </div>

                                <div id="23" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(23)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto23" name="idProducto23" type="hidden" value="2250">

                                                            <div style="width:100%">
                                                                <label for="nombre23" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre23" name="nombre23" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2250 - BOLIGRAFO TINTA GEL ROJO GP-675-B 0.7MM PUNTA METALICA STUDMARK">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 Z1" placeholder="bodega-seccion" id="bodega23" name="bodega23" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio23" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio23" name="precio23" value="6.55" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="6.55" onchange="calcularTotales(precio23,cantidad23,15,unidad23,23,restaInventario23)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad23" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad23" name="cantidad23" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio23,cantidad23,15,unidad23,23,restaInventario23)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad23" id="unidad23" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio23,cantidad23,15,unidad23,23,restaInventario23)">
                                                                    <option selected="" value="12" data-id="2475"> CAJA-12</option><option value="1" data-id="2476"> UNIDAD-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar23" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar23" name="subTotalMostrar23" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal23" name="subTotal23" type="hidden" value="78.600" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar23" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar23" name="isvProductoMostrar23" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto23" name="isvProducto23" type="hidden" value="11.790" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar23" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar23" name="totalMostrar23" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total23" name="total23" type="hidden" value="90.390" required="">


                                                    </div>

                                                    <input id="idBodega23" name="idBodega23" type="hidden" value="8">
                                                    <input id="idSeccion23" name="idSeccion23" type="hidden" value="138">
                                                    <input id="restaInventario23" name="restaInventario23" type="hidden" value="12">
                                                    <input id="isv23" name="isv23" type="hidden" value="15">



                                </div>

                                <div id="24" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(24)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto24" name="idProducto24" type="hidden" value="1458">

                                                            <div style="width:100%">
                                                                <label for="nombre24" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre24" name="nombre24" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1458 - DETERGENTE EN FARDO 15KG LARIANSA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega24" name="bodega24" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio24" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio24" name="precio24" value="390.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="390.00" onchange="calcularTotales(precio24,cantidad24,15,unidad24,24,restaInventario24)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad24" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad24" name="cantidad24" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio24,cantidad24,15,unidad24,24,restaInventario24)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad24" id="unidad24" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio24,cantidad24,15,unidad24,24,restaInventario24)">
                                                                    <option selected="" value="1" data-id="459"> FARDO-1</option><option value="1" data-id="1678">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar24" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar24" name="subTotalMostrar24" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal24" name="subTotal24" type="hidden" value="390.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar24" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar24" name="isvProductoMostrar24" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto24" name="isvProducto24" type="hidden" value="58.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar24" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar24" name="totalMostrar24" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total24" name="total24" type="hidden" value="448.500" required="">


                                                    </div>

                                                    <input id="idBodega24" name="idBodega24" type="hidden" value="5">
                                                    <input id="idSeccion24" name="idSeccion24" type="hidden" value="37">
                                                    <input id="restaInventario24" name="restaInventario24" type="hidden" value="1">
                                                    <input id="isv24" name="isv24" type="hidden" value="15">



                                </div>

                                <div id="25" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(25)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto25" name="idProducto25" type="hidden" value="1455">

                                                            <div style="width:100%">
                                                                <label for="nombre25" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre25" name="nombre25" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1455 - DESTRUCTORA DE PAPEL 20 HOJAS H1007 GRANDE WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 C 2" placeholder="bodega-seccion" id="bodega25" name="bodega25" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio25" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio25" name="precio25" value="7,148.79" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="7,148.79" onchange="calcularTotales(precio25,cantidad25,15,unidad25,25,restaInventario25)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad25" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad25" name="cantidad25" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio25,cantidad25,15,unidad25,25,restaInventario25)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad25" id="unidad25" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio25,cantidad25,15,unidad25,25,restaInventario25)">
                                                                    <option selected="" value="1" data-id="456">UNIDAD-1</option><option value="1" data-id="1675">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar25" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar25" name="subTotalMostrar25" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal25" name="subTotal25" type="hidden" value="" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar25" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar25" name="isvProductoMostrar25" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto25" name="isvProducto25" type="hidden" value="" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar25" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar25" name="totalMostrar25" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total25" name="total25" type="hidden" value="" required="">


                                                    </div>

                                                    <input id="idBodega25" name="idBodega25" type="hidden" value="8">
                                                    <input id="idSeccion25" name="idSeccion25" type="hidden" value="93">
                                                    <input id="restaInventario25" name="restaInventario25" type="hidden" value="">
                                                    <input id="isv25" name="isv25" type="hidden" value="15">



                                </div>

                                <div id="26" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(26)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto26" name="idProducto26" type="hidden" value="1453">

                                                            <div style="width:100%">
                                                                <label for="nombre26" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre26" name="nombre26" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1453 - DESTRUCTORA DE PAPEL 12 HOJAS H1001 STANDARD WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 A 1" placeholder="bodega-seccion" id="bodega26" name="bodega26" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio26" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio26" name="precio26" value="1,714.71" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="1,714.71" onchange="calcularTotales(precio26,cantidad26,15,unidad26,26,restaInventario26)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad26" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad26" name="cantidad26" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio26,cantidad26,15,unidad26,26,restaInventario26)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad26" id="unidad26" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio26,cantidad26,15,unidad26,26,restaInventario26)">
                                                                    <option selected="" value="1" data-id="454"> UNIDAD-1</option><option value="1" data-id="1673">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar26" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar26" name="subTotalMostrar26" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal26" name="subTotal26" type="hidden" value="" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar26" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar26" name="isvProductoMostrar26" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto26" name="isvProducto26" type="hidden" value="" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar26" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar26" name="totalMostrar26" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total26" name="total26" type="hidden" value="" required="">


                                                    </div>

                                                    <input id="idBodega26" name="idBodega26" type="hidden" value="8">
                                                    <input id="idSeccion26" name="idSeccion26" type="hidden" value="82">
                                                    <input id="restaInventario26" name="restaInventario26" type="hidden" value="">
                                                    <input id="isv26" name="isv26" type="hidden" value="15">



                                </div>

                                <div id="27" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(27)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto27" name="idProducto27" type="hidden" value="1222">

                                                            <div style="width:100%">
                                                                <label for="nombre27" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre27" name="nombre27" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1222 - CARTULINA SENCILLA VERDE LAGON ANCHOR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 3 B 3" placeholder="bodega-seccion" id="bodega27" name="bodega27" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio27" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio27" name="precio27" value="2.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="2.50" onchange="calcularTotales(precio27,cantidad27,15,unidad27,27,restaInventario27)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad27" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad27" name="cantidad27" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio27,cantidad27,15,unidad27,27,restaInventario27)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad27" id="unidad27" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio27,cantidad27,15,unidad27,27,restaInventario27)">
                                                                    <option selected="" value="100" data-id="223"> RESMA-100</option><option value="1" data-id="1442"> PLIEGO-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar27" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar27" name="subTotalMostrar27" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal27" name="subTotal27" type="hidden" value="250.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar27" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar27" name="isvProductoMostrar27" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto27" name="isvProducto27" type="hidden" value="37.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar27" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar27" name="totalMostrar27" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total27" name="total27" type="hidden" value="287.500" required="">


                                                    </div>

                                                    <input id="idBodega27" name="idBodega27" type="hidden" value="3">
                                                    <input id="idSeccion27" name="idSeccion27" type="hidden" value="25">
                                                    <input id="restaInventario27" name="restaInventario27" type="hidden" value="100">
                                                    <input id="isv27" name="isv27" type="hidden" value="15">



                                </div>

                                <div id="28" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(28)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto28" name="idProducto28" type="hidden" value="2223">

                                                            <div style="width:100%">
                                                                <label for="nombre28" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre28" name="nombre28" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2223 - PAPEL TABLOIDE BLANCO REPORT 11X17 75G">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega28" name="bodega28" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio28" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio28" name="precio28" value="269.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="269.50" onchange="calcularTotales(precio28,cantidad28,15,unidad28,28,restaInventario28)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad28" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad28" name="cantidad28" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio28,cantidad28,15,unidad28,28,restaInventario28)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad28" id="unidad28" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio28,cantidad28,15,unidad28,28,restaInventario28)">
                                                                    <option selected="" value="1" data-id="2445"> RESMA-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar28" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar28" name="subTotalMostrar28" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal28" name="subTotal28" type="hidden" value="269.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar28" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar28" name="isvProductoMostrar28" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto28" name="isvProducto28" type="hidden" value="40.425" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar28" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar28" name="totalMostrar28" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total28" name="total28" type="hidden" value="309.925" required="">


                                                    </div>

                                                    <input id="idBodega28" name="idBodega28" type="hidden" value="5">
                                                    <input id="idSeccion28" name="idSeccion28" type="hidden" value="37">
                                                    <input id="restaInventario28" name="restaInventario28" type="hidden" value="1">
                                                    <input id="isv28" name="isv28" type="hidden" value="15">



                                </div>

                                <div id="29" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(29)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto29" name="idProducto29" type="hidden" value="2233">

                                                            <div style="width:100%">
                                                                <label for="nombre29" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre29" name="nombre29" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2233 - TINTA PARA SELLO ROLL ON 60 ML  WR0LL60 COLOR NEGRO WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 A 1" placeholder="bodega-seccion" id="bodega29" name="bodega29" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio29" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio29" name="precio29" value="24.72" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="24.72" onchange="calcularTotales(precio29,cantidad29,15,unidad29,29,restaInventario29)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad29" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad29" name="cantidad29" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio29,cantidad29,15,unidad29,29,restaInventario29)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad29" id="unidad29" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio29,cantidad29,15,unidad29,29,restaInventario29)">
                                                                    <option selected="" value="1" data-id="2456">BOTE-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar29" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar29" name="subTotalMostrar29" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal29" name="subTotal29" type="hidden" value="24.720" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar29" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar29" name="isvProductoMostrar29" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto29" name="isvProducto29" type="hidden" value="3.708" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar29" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar29" name="totalMostrar29" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total29" name="total29" type="hidden" value="28.428" required="">


                                                    </div>

                                                    <input id="idBodega29" name="idBodega29" type="hidden" value="7">
                                                    <input id="idSeccion29" name="idSeccion29" type="hidden" value="42">
                                                    <input id="restaInventario29" name="restaInventario29" type="hidden" value="1">
                                                    <input id="isv29" name="isv29" type="hidden" value="15">



                                </div>

                                <div id="30" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(30)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto30" name="idProducto30" type="hidden" value="2234">

                                                            <div style="width:100%">
                                                                <label for="nombre30" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre30" name="nombre30" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2234 - CLORO LIQUIDO NEPTUNO">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega30" name="bodega30" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio30" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio30" name="precio30" value="36.40" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="36.40" onchange="calcularTotales(precio30,cantidad30,0,unidad30,30,restaInventario30)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad30" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad30" name="cantidad30" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio30,cantidad30,0,unidad30,30,restaInventario30)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad30" id="unidad30" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio30,cantidad30,0,unidad30,30,restaInventario30)">
                                                                    <option selected="" value="1" data-id="2457"> GALON-1</option><option value="1" data-id="2458">GALON-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar30" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar30" name="subTotalMostrar30" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal30" name="subTotal30" type="hidden" value="36.400" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar30" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar30" name="isvProductoMostrar30" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto30" name="isvProducto30" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar30" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar30" name="totalMostrar30" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total30" name="total30" type="hidden" value="36.400" required="">


                                                    </div>

                                                    <input id="idBodega30" name="idBodega30" type="hidden" value="5">
                                                    <input id="idSeccion30" name="idSeccion30" type="hidden" value="37">
                                                    <input id="restaInventario30" name="restaInventario30" type="hidden" value="1">
                                                    <input id="isv30" name="isv30" type="hidden" value="0">



                                </div>

                                <div id="31" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(31)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto31" name="idProducto31" type="hidden" value="2235">

                                                            <div style="width:100%">
                                                                <label for="nombre31" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre31" name="nombre31" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2235 - DESINFECTANTE PARA PISOS OLOR CLEAN">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega31" name="bodega31" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio31" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio31" name="precio31" value="46.80" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="46.80" onchange="calcularTotales(precio31,cantidad31,0,unidad31,31,restaInventario31)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad31" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad31" name="cantidad31" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio31,cantidad31,0,unidad31,31,restaInventario31)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad31" id="unidad31" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio31,cantidad31,0,unidad31,31,restaInventario31)">
                                                                    <option selected="" value="1" data-id="2459"> GALON-1</option><option value="1" data-id="2460">GALON-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar31" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar31" name="subTotalMostrar31" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal31" name="subTotal31" type="hidden" value="46.800" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar31" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar31" name="isvProductoMostrar31" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto31" name="isvProducto31" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar31" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar31" name="totalMostrar31" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total31" name="total31" type="hidden" value="46.800" required="">


                                                    </div>

                                                    <input id="idBodega31" name="idBodega31" type="hidden" value="5">
                                                    <input id="idSeccion31" name="idSeccion31" type="hidden" value="37">
                                                    <input id="restaInventario31" name="restaInventario31" type="hidden" value="1">
                                                    <input id="isv31" name="isv31" type="hidden" value="0">



                                </div>

                                <div id="32" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(32)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto32" name="idProducto32" type="hidden" value="2236">

                                                            <div style="width:100%">
                                                                <label for="nombre32" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre32" name="nombre32" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2236 - TINTA PARA SELLO ROLL ON COLOR NEGRO AZOR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 E 3" placeholder="bodega-seccion" id="bodega32" name="bodega32" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio32" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio32" name="precio32" value="24.72" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="24.72" onchange="calcularTotales(precio32,cantidad32,15,unidad32,32,restaInventario32)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad32" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad32" name="cantidad32" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio32,cantidad32,15,unidad32,32,restaInventario32)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad32" id="unidad32" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio32,cantidad32,15,unidad32,32,restaInventario32)">
                                                                    <option selected="" value="1" data-id="2461"> BOTE-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar32" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar32" name="subTotalMostrar32" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal32" name="subTotal32" type="hidden" value="24.720" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar32" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar32" name="isvProductoMostrar32" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto32" name="isvProducto32" type="hidden" value="3.708" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar32" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar32" name="totalMostrar32" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total32" name="total32" type="hidden" value="28.428" required="">


                                                    </div>

                                                    <input id="idBodega32" name="idBodega32" type="hidden" value="8">
                                                    <input id="idSeccion32" name="idSeccion32" type="hidden" value="104">
                                                    <input id="restaInventario32" name="restaInventario32" type="hidden" value="1">
                                                    <input id="isv32" name="isv32" type="hidden" value="15">



                                </div>

                                <div id="33" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(33)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto33" name="idProducto33" type="hidden" value="2238">

                                                            <div style="width:100%">
                                                                <label for="nombre33" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre33" name="nombre33" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2238 - DETERGENTE LARIANSA CON AROMA 9KGS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega33" name="bodega33" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio33" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio33" name="precio33" value="243.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="243.00" onchange="calcularTotales(precio33,cantidad33,15,unidad33,33,restaInventario33)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad33" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad33" name="cantidad33" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio33,cantidad33,15,unidad33,33,restaInventario33)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad33" id="unidad33" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio33,cantidad33,15,unidad33,33,restaInventario33)">
                                                                    <option selected="" value="1" data-id="2463"> FARDO-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar33" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar33" name="subTotalMostrar33" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal33" name="subTotal33" type="hidden" value="243.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar33" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar33" name="isvProductoMostrar33" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto33" name="isvProducto33" type="hidden" value="36.450" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar33" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar33" name="totalMostrar33" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total33" name="total33" type="hidden" value="279.450" required="">


                                                    </div>

                                                    <input id="idBodega33" name="idBodega33" type="hidden" value="5">
                                                    <input id="idSeccion33" name="idSeccion33" type="hidden" value="37">
                                                    <input id="restaInventario33" name="restaInventario33" type="hidden" value="1">
                                                    <input id="isv33" name="isv33" type="hidden" value="15">



                                </div>

                                <div id="34" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(34)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto34" name="idProducto34" type="hidden" value="2326">

                                                            <div style="width:100%">
                                                                <label for="nombre34" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre34" name="nombre34" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2326 - PIZARRA MAGNETICA BLANCA CON MARCO 60CMX90CM PZ6090A SYSABE SISLO">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 A 1" placeholder="bodega-seccion" id="bodega34" name="bodega34" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio34" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio34" name="precio34" value="350.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="350.00" onchange="calcularTotales(precio34,cantidad34,15,unidad34,34,restaInventario34)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad34" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad34" name="cantidad34" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio34,cantidad34,15,unidad34,34,restaInventario34)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad34" id="unidad34" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio34,cantidad34,15,unidad34,34,restaInventario34)">
                                                                    <option selected="" value="1" data-id="2561"> UNIDAD-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar34" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar34" name="subTotalMostrar34" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal34" name="subTotal34" type="hidden" value="350.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar34" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar34" name="isvProductoMostrar34" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto34" name="isvProducto34" type="hidden" value="52.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar34" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar34" name="totalMostrar34" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total34" name="total34" type="hidden" value="402.500" required="">


                                                    </div>

                                                    <input id="idBodega34" name="idBodega34" type="hidden" value="8">
                                                    <input id="idSeccion34" name="idSeccion34" type="hidden" value="82">
                                                    <input id="restaInventario34" name="restaInventario34" type="hidden" value="1">
                                                    <input id="isv34" name="isv34" type="hidden" value="15">



                                </div>

                                <div id="35" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(35)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto35" name="idProducto35" type="hidden" value="2035">

                                                            <div style="width:100%">
                                                                <label for="nombre35" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre35" name="nombre35" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2035 - PAPEL TOALLA JUMBO ROLL DE 240 MTS HOMEPALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 E1" placeholder="bodega-seccion" id="bodega35" name="bodega35" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio35" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio35" name="precio35" value="109.95" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="109.95" onchange="calcularTotales(precio35,cantidad35,15,unidad35,35,restaInventario35)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad35" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad35" name="cantidad35" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio35,cantidad35,15,unidad35,35,restaInventario35)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad35" id="unidad35" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio35,cantidad35,15,unidad35,35,restaInventario35)">
                                                                    <option selected="" value="1" data-id="1036"> ROLLO-1</option><option value="12" data-id="2255"> CAJA-12</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar35" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar35" name="subTotalMostrar35" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal35" name="subTotal35" type="hidden" value="109.950" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar35" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar35" name="isvProductoMostrar35" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto35" name="isvProducto35" type="hidden" value="16.492" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar35" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar35" name="totalMostrar35" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total35" name="total35" type="hidden" value="126.442" required="">


                                                    </div>

                                                    <input id="idBodega35" name="idBodega35" type="hidden" value="6">
                                                    <input id="idSeccion35" name="idSeccion35" type="hidden" value="41">
                                                    <input id="restaInventario35" name="restaInventario35" type="hidden" value="1">
                                                    <input id="isv35" name="isv35" type="hidden" value="15">



                                </div>

                                <div id="36" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(36)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto36" name="idProducto36" type="hidden" value="2036">

                                                            <div style="width:100%">
                                                                <label for="nombre36" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre36" name="nombre36" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2036 - PAPEL TOALLA INTERDOBLADA HOMEPALS (16 PAQUETES)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 E1" placeholder="bodega-seccion" id="bodega36" name="bodega36" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio36" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio36" name="precio36" value="51.94" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="51.94" onchange="calcularTotales(precio36,cantidad36,15,unidad36,36,restaInventario36)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad36" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad36" name="cantidad36" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio36,cantidad36,15,unidad36,36,restaInventario36)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad36" id="unidad36" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio36,cantidad36,15,unidad36,36,restaInventario36)">
                                                                    <option selected="" value="1" data-id="1037"> PAQUETE-1</option><option value="16" data-id="2256"> CAJA-16</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar36" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar36" name="subTotalMostrar36" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal36" name="subTotal36" type="hidden" value="51.940" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar36" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar36" name="isvProductoMostrar36" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto36" name="isvProducto36" type="hidden" value="7.791" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar36" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar36" name="totalMostrar36" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total36" name="total36" type="hidden" value="59.731" required="">


                                                    </div>

                                                    <input id="idBodega36" name="idBodega36" type="hidden" value="6">
                                                    <input id="idSeccion36" name="idSeccion36" type="hidden" value="41">
                                                    <input id="restaInventario36" name="restaInventario36" type="hidden" value="1">
                                                    <input id="isv36" name="isv36" type="hidden" value="15">



                                </div>

                                <div id="37" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(37)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto37" name="idProducto37" type="hidden" value="2038">

                                                            <div style="width:100%">
                                                                <label for="nombre37" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre37" name="nombre37" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2038 - PAPEL TOALLA CH PARA DISPENSADOR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 4 A 1" placeholder="bodega-seccion" id="bodega37" name="bodega37" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio37" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio37" name="precio37" value="113.94" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="113.94" onchange="calcularTotales(precio37,cantidad37,15,unidad37,37,restaInventario37)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad37" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad37" name="cantidad37" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio37,cantidad37,15,unidad37,37,restaInventario37)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad37" id="unidad37" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio37,cantidad37,15,unidad37,37,restaInventario37)">
                                                                    <option selected="" value="1" data-id="1039"> ROLLO-1</option><option value="6" data-id="2258"> CAJA-6</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar37" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar37" name="subTotalMostrar37" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal37" name="subTotal37" type="hidden" value="113.940" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar37" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar37" name="isvProductoMostrar37" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto37" name="isvProducto37" type="hidden" value="17.091" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar37" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar37" name="totalMostrar37" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total37" name="total37" type="hidden" value="131.031" required="">


                                                    </div>

                                                    <input id="idBodega37" name="idBodega37" type="hidden" value="4">
                                                    <input id="idSeccion37" name="idSeccion37" type="hidden" value="29">
                                                    <input id="restaInventario37" name="restaInventario37" type="hidden" value="1">
                                                    <input id="isv37" name="isv37" type="hidden" value="15">



                                </div>

                                <div id="38" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(38)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto38" name="idProducto38" type="hidden" value="1332">

                                                            <div style="width:100%">
                                                                <label for="nombre38" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre38" name="nombre38" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1332 - CUADERNO COSIDO OFF ROAD 4X4 200 PAG GRANDE OFI-NOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 H1" placeholder="bodega-seccion" id="bodega38" name="bodega38" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio38" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio38" name="precio38" value="22.30" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="22.30" onchange="calcularTotales(precio38,cantidad38,0,unidad38,38,restaInventario38)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad38" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad38" name="cantidad38" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio38,cantidad38,0,unidad38,38,restaInventario38)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad38" id="unidad38" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio38,cantidad38,0,unidad38,38,restaInventario38)">
                                                                    <option selected="" value="1" data-id="333">POR DEFECTO-1</option><option value="1" data-id="1552">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar38" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar38" name="subTotalMostrar38" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal38" name="subTotal38" type="hidden" value="22.300" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar38" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar38" name="isvProductoMostrar38" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto38" name="isvProducto38" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar38" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar38" name="totalMostrar38" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total38" name="total38" type="hidden" value="22.300" required="">


                                                    </div>

                                                    <input id="idBodega38" name="idBodega38" type="hidden" value="6">
                                                    <input id="idSeccion38" name="idSeccion38" type="hidden" value="144">
                                                    <input id="restaInventario38" name="restaInventario38" type="hidden" value="1">
                                                    <input id="isv38" name="isv38" type="hidden" value="0">



                                </div>

                                <div id="39" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(39)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto39" name="idProducto39" type="hidden" value="1430">

                                                            <div style="width:100%">
                                                                <label for="nombre39" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre39" name="nombre39" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1430 - UNICO CORTO DE 400 PAGINAS WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 B 1" placeholder="bodega-seccion" id="bodega39" name="bodega39" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio39" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio39" name="precio39" value="44.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="44.50" onchange="calcularTotales(precio39,cantidad39,0,unidad39,39,restaInventario39)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad39" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad39" name="cantidad39" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio39,cantidad39,0,unidad39,39,restaInventario39)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad39" id="unidad39" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio39,cantidad39,0,unidad39,39,restaInventario39)">
                                                                    <option selected="" value="1" data-id="431">UNIDAD-1</option><option value="1" data-id="1650">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar39" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar39" name="subTotalMostrar39" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal39" name="subTotal39" type="hidden" value="44.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar39" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar39" name="isvProductoMostrar39" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto39" name="isvProducto39" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar39" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar39" name="totalMostrar39" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total39" name="total39" type="hidden" value="44.500" required="">


                                                    </div>

                                                    <input id="idBodega39" name="idBodega39" type="hidden" value="6">
                                                    <input id="idSeccion39" name="idSeccion39" type="hidden" value="38">
                                                    <input id="restaInventario39" name="restaInventario39" type="hidden" value="1">
                                                    <input id="isv39" name="isv39" type="hidden" value="0">



                                </div>

                                <div id="40" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(40)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto40" name="idProducto40" type="hidden" value="1432">

                                                            <div style="width:100%">
                                                                <label for="nombre40" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre40" name="nombre40" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1432 - CUADERNO UNICO CORTO PLASTIFICADO 400PAG GENIAL">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 E 1" placeholder="bodega-seccion" id="bodega40" name="bodega40" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio40" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio40" name="precio40" value="36.40" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="36.40" onchange="calcularTotales(precio40,cantidad40,0,unidad40,40,restaInventario40)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad40" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad40" name="cantidad40" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio40,cantidad40,0,unidad40,40,restaInventario40)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad40" id="unidad40" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio40,cantidad40,0,unidad40,40,restaInventario40)">
                                                                    <option selected="" value="1" data-id="433">UNIDAD-1</option><option value="1" data-id="1652">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar40" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar40" name="subTotalMostrar40" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal40" name="subTotal40" type="hidden" value="36.400" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar40" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar40" name="isvProductoMostrar40" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto40" name="isvProducto40" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar40" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar40" name="totalMostrar40" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total40" name="total40" type="hidden" value="36.400" required="">


                                                    </div>

                                                    <input id="idBodega40" name="idBodega40" type="hidden" value="8">
                                                    <input id="idSeccion40" name="idSeccion40" type="hidden" value="102">
                                                    <input id="restaInventario40" name="restaInventario40" type="hidden" value="1">
                                                    <input id="isv40" name="isv40" type="hidden" value="0">



                                </div>

                                <div id="41" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(41)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto41" name="idProducto41" type="hidden" value="1433">

                                                            <div style="width:100%">
                                                                <label for="nombre41" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre41" name="nombre41" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1433 - UNICO LARGO DE 200 HOJAS, 400 PAGINAS PLASTIFICADO WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 3 B 3" placeholder="bodega-seccion" id="bodega41" name="bodega41" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio41" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio41" name="precio41" value="82.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="82.50" onchange="calcularTotales(precio41,cantidad41,0,unidad41,41,restaInventario41)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad41" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad41" name="cantidad41" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio41,cantidad41,0,unidad41,41,restaInventario41)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad41" id="unidad41" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio41,cantidad41,0,unidad41,41,restaInventario41)">
                                                                    <option selected="" value="1" data-id="434">UNIDAD-1</option><option value="30" data-id="1653"> CAJA-30</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar41" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar41" name="subTotalMostrar41" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal41" name="subTotal41" type="hidden" value="82.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar41" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar41" name="isvProductoMostrar41" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto41" name="isvProducto41" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar41" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar41" name="totalMostrar41" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total41" name="total41" type="hidden" value="82.500" required="">


                                                    </div>

                                                    <input id="idBodega41" name="idBodega41" type="hidden" value="3">
                                                    <input id="idSeccion41" name="idSeccion41" type="hidden" value="25">
                                                    <input id="restaInventario41" name="restaInventario41" type="hidden" value="1">
                                                    <input id="isv41" name="isv41" type="hidden" value="0">



                                </div>

                                <div id="42" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(42)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto42" name="idProducto42" type="hidden" value="1463">

                                                            <div style="width:100%">
                                                                <label for="nombre42" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre42" name="nombre42" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1463 - DISPENSADOR DE GEL MANUAL (SD934B) COLOR NEGRO HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 G3" placeholder="bodega-seccion" id="bodega42" name="bodega42" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio42" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio42" name="precio42" value="375.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="375.00" onchange="calcularTotales(precio42,cantidad42,15,unidad42,42,restaInventario42)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad42" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad42" name="cantidad42" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio42,cantidad42,15,unidad42,42,restaInventario42)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad42" id="unidad42" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio42,cantidad42,15,unidad42,42,restaInventario42)">
                                                                    <option selected="" value="1" data-id="464">POR DEFECTO-1</option><option value="1" data-id="1683">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar42" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar42" name="subTotalMostrar42" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal42" name="subTotal42" type="hidden" value="375.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar42" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar42" name="isvProductoMostrar42" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto42" name="isvProducto42" type="hidden" value="56.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar42" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar42" name="totalMostrar42" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total42" name="total42" type="hidden" value="431.250" required="">


                                                    </div>

                                                    <input id="idBodega42" name="idBodega42" type="hidden" value="6">
                                                    <input id="idSeccion42" name="idSeccion42" type="hidden" value="125">
                                                    <input id="restaInventario42" name="restaInventario42" type="hidden" value="1">
                                                    <input id="isv42" name="isv42" type="hidden" value="15">



                                </div>

                                <div id="43" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(43)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto43" name="idProducto43" type="hidden" value="1464">

                                                            <div style="width:100%">
                                                                <label for="nombre43" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre43" name="nombre43" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1464 - DISPENSADOR DE GEL MANUAL DE ACERO INOXIDABLE (SD-950-1) HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 D1" placeholder="bodega-seccion" id="bodega43" name="bodega43" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio43" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio43" name="precio43" value="480.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="480.00" onchange="calcularTotales(precio43,cantidad43,15,unidad43,43,restaInventario43)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad43" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad43" name="cantidad43" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio43,cantidad43,15,unidad43,43,restaInventario43)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad43" id="unidad43" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio43,cantidad43,15,unidad43,43,restaInventario43)">
                                                                    <option selected="" value="1" data-id="465">UNIDAD-1</option><option value="1" data-id="1684">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar43" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar43" name="subTotalMostrar43" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal43" name="subTotal43" type="hidden" value="480.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar43" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar43" name="isvProductoMostrar43" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto43" name="isvProducto43" type="hidden" value="72.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar43" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar43" name="totalMostrar43" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total43" name="total43" type="hidden" value="552.000" required="">


                                                    </div>

                                                    <input id="idBodega43" name="idBodega43" type="hidden" value="6">
                                                    <input id="idSeccion43" name="idSeccion43" type="hidden" value="122">
                                                    <input id="restaInventario43" name="restaInventario43" type="hidden" value="1">
                                                    <input id="isv43" name="isv43" type="hidden" value="15">



                                </div>

                                <div id="44" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(44)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto44" name="idProducto44" type="hidden" value="1467">

                                                            <div style="width:100%">
                                                                <label for="nombre44" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre44" name="nombre44" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1467 - DISPENSADOR DE JABON LIQUIDO 500ML CH 22X8.3X8CM COLOR BLANCO">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 G3" placeholder="bodega-seccion" id="bodega44" name="bodega44" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio44" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio44" name="precio44" value="118.27" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="118.27" onchange="calcularTotales(precio44,cantidad44,15,unidad44,44,restaInventario44)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad44" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad44" name="cantidad44" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio44,cantidad44,15,unidad44,44,restaInventario44)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad44" id="unidad44" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio44,cantidad44,15,unidad44,44,restaInventario44)">
                                                                    <option selected="" value="1" data-id="468">UNIDAD-1</option><option value="1" data-id="1687">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar44" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar44" name="subTotalMostrar44" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal44" name="subTotal44" type="hidden" value="118.270" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar44" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar44" name="isvProductoMostrar44" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto44" name="isvProducto44" type="hidden" value="17.740" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar44" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar44" name="totalMostrar44" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total44" name="total44" type="hidden" value="136.010" required="">


                                                    </div>

                                                    <input id="idBodega44" name="idBodega44" type="hidden" value="6">
                                                    <input id="idSeccion44" name="idSeccion44" type="hidden" value="125">
                                                    <input id="restaInventario44" name="restaInventario44" type="hidden" value="1">
                                                    <input id="isv44" name="isv44" type="hidden" value="15">



                                </div>

                                <div id="45" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(45)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto45" name="idProducto45" type="hidden" value="1468">

                                                            <div style="width:100%">
                                                                <label for="nombre45" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre45" name="nombre45" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1468 - DISPENSADOR DE PAPEL HIGIENICO (PD532B) COLOR NEGRO HOME PALS">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 D1" placeholder="bodega-seccion" id="bodega45" name="bodega45" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio45" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio45" name="precio45" value="251.25" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="251.25" onchange="calcularTotales(precio45,cantidad45,15,unidad45,45,restaInventario45)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad45" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad45" name="cantidad45" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio45,cantidad45,15,unidad45,45,restaInventario45)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad45" id="unidad45" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio45,cantidad45,15,unidad45,45,restaInventario45)">
                                                                    <option selected="" value="1" data-id="469">UNIDAD-1</option><option value="1" data-id="1688">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar45" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar45" name="subTotalMostrar45" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal45" name="subTotal45" type="hidden" value="251.250" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar45" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar45" name="isvProductoMostrar45" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto45" name="isvProducto45" type="hidden" value="37.688" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar45" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar45" name="totalMostrar45" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total45" name="total45" type="hidden" value="288.938" required="">


                                                    </div>

                                                    <input id="idBodega45" name="idBodega45" type="hidden" value="6">
                                                    <input id="idSeccion45" name="idSeccion45" type="hidden" value="122">
                                                    <input id="restaInventario45" name="restaInventario45" type="hidden" value="1">
                                                    <input id="isv45" name="isv45" type="hidden" value="15">



                                </div>

                                <div id="46" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(46)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto46" name="idProducto46" type="hidden" value="1145">

                                                            <div style="width:100%">
                                                                <label for="nombre46" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre46" name="nombre46" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1145 - BOLSA MANILA T/EXTRA LEGAL DVALENCIA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 D 1" placeholder="bodega-seccion" id="bodega46" name="bodega46" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio46" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio46" name="precio46" value="3.90" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="3.90" onchange="calcularTotales(precio46,cantidad46,15,unidad46,46,restaInventario46)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad46" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad46" name="cantidad46" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio46,cantidad46,15,unidad46,46,restaInventario46)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad46" id="unidad46" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio46,cantidad46,15,unidad46,46,restaInventario46)">
                                                                    <option selected="" value="1" data-id="146"> UNIDAD-1</option><option value="1" data-id="1365">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar46" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar46" name="subTotalMostrar46" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal46" name="subTotal46" type="hidden" value="3.900" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar46" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar46" name="isvProductoMostrar46" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto46" name="isvProducto46" type="hidden" value="0.585" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar46" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar46" name="totalMostrar46" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total46" name="total46" type="hidden" value="4.485" required="">


                                                    </div>

                                                    <input id="idBodega46" name="idBodega46" type="hidden" value="7">
                                                    <input id="idSeccion46" name="idSeccion46" type="hidden" value="57">
                                                    <input id="restaInventario46" name="restaInventario46" type="hidden" value="1">
                                                    <input id="isv46" name="isv46" type="hidden" value="15">



                                </div>

                                <div id="47" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(47)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto47" name="idProducto47" type="hidden" value="1452">

                                                            <div style="width:100%">
                                                                <label for="nombre47" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre47" name="nombre47" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1452 - DESODORANTE URINARIO H1006 PEQUEÑO COLOR BLANCO WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 H 1" placeholder="bodega-seccion" id="bodega47" name="bodega47" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio47" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio47" name="precio47" value="65.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="65.00" onchange="calcularTotales(precio47,cantidad47,15,unidad47,47,restaInventario47)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad47" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad47" name="cantidad47" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio47,cantidad47,15,unidad47,47,restaInventario47)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad47" id="unidad47" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio47,cantidad47,15,unidad47,47,restaInventario47)">
                                                                    <option selected="" value="1" data-id="453"> UNIDAD-1</option><option value="1" data-id="1672">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar47" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar47" name="subTotalMostrar47" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal47" name="subTotal47" type="hidden" value="65.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar47" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar47" name="isvProductoMostrar47" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto47" name="isvProducto47" type="hidden" value="9.750" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar47" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar47" name="totalMostrar47" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total47" name="total47" type="hidden" value="74.750" required="">


                                                    </div>

                                                    <input id="idBodega47" name="idBodega47" type="hidden" value="7">
                                                    <input id="idSeccion47" name="idSeccion47" type="hidden" value="77">
                                                    <input id="restaInventario47" name="restaInventario47" type="hidden" value="1">
                                                    <input id="isv47" name="isv47" type="hidden" value="15">



                                </div>

                                <div id="48" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(48)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto48" name="idProducto48" type="hidden" value="1560">

                                                            <div style="width:100%">
                                                                <label for="nombre48" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre48" name="nombre48" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1560 - FOLDER PLASTICO CON VENA BS-1511 A4 BENSSINI">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 A 1" placeholder="bodega-seccion" id="bodega48" name="bodega48" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio48" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio48" name="precio48" value="3.80" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="3.80" onchange="calcularTotales(precio48,cantidad48,15,unidad48,48,restaInventario48)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad48" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad48" name="cantidad48" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio48,cantidad48,15,unidad48,48,restaInventario48)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad48" id="unidad48" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio48,cantidad48,15,unidad48,48,restaInventario48)">
                                                                    <option selected="" value="1" data-id="561"> UNIDAD-1</option><option value="1" data-id="1780">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar48" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar48" name="subTotalMostrar48" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal48" name="subTotal48" type="hidden" value="3.800" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar48" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar48" name="isvProductoMostrar48" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto48" name="isvProducto48" type="hidden" value="0.570" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar48" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar48" name="totalMostrar48" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total48" name="total48" type="hidden" value="4.370" required="">


                                                    </div>

                                                    <input id="idBodega48" name="idBodega48" type="hidden" value="8">
                                                    <input id="idSeccion48" name="idSeccion48" type="hidden" value="82">
                                                    <input id="restaInventario48" name="restaInventario48" type="hidden" value="1">
                                                    <input id="isv48" name="isv48" type="hidden" value="15">



                                </div>

                                <div id="49" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(49)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto49" name="idProducto49" type="hidden" value="1562">

                                                            <div style="width:100%">
                                                                <label for="nombre49" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre49" name="nombre49" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1562 - FOLDER DE COLOR PASTEL T/CARTA AMARILLO OFINOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 F 1" placeholder="bodega-seccion" id="bodega49" name="bodega49" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio49" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio49" name="precio49" value="134.81" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="134.81" onchange="calcularTotales(precio49,cantidad49,15,unidad49,49,restaInventario49)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad49" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad49" name="cantidad49" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio49,cantidad49,15,unidad49,49,restaInventario49)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad49" id="unidad49" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio49,cantidad49,15,unidad49,49,restaInventario49)">
                                                                    <option selected="" value="1" data-id="563"> RESMA-1</option><option value="1" data-id="1782">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar49" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar49" name="subTotalMostrar49" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal49" name="subTotal49" type="hidden" value="134.810" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar49" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar49" name="isvProductoMostrar49" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto49" name="isvProducto49" type="hidden" value="20.221" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar49" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar49" name="totalMostrar49" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total49" name="total49" type="hidden" value="155.031" required="">


                                                    </div>

                                                    <input id="idBodega49" name="idBodega49" type="hidden" value="6">
                                                    <input id="idSeccion49" name="idSeccion49" type="hidden" value="40">
                                                    <input id="restaInventario49" name="restaInventario49" type="hidden" value="1">
                                                    <input id="isv49" name="isv49" type="hidden" value="15">



                                </div>

                                <div id="50" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(50)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto50" name="idProducto50" type="hidden" value="1563">

                                                            <div style="width:100%">
                                                                <label for="nombre50" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre50" name="nombre50" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1563 - FOLDER DE COLOR PASTEL T/CARTA AZUL OFINOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 F 1" placeholder="bodega-seccion" id="bodega50" name="bodega50" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio50" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio50" name="precio50" value="134.81" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="134.81" onchange="calcularTotales(precio50,cantidad50,15,unidad50,50,restaInventario50)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad50" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad50" name="cantidad50" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio50,cantidad50,15,unidad50,50,restaInventario50)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad50" id="unidad50" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio50,cantidad50,15,unidad50,50,restaInventario50)">
                                                                    <option selected="" value="1" data-id="564"> RESMA-1</option><option value="1" data-id="1783">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar50" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar50" name="subTotalMostrar50" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal50" name="subTotal50" type="hidden" value="134.810" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar50" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar50" name="isvProductoMostrar50" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto50" name="isvProducto50" type="hidden" value="20.221" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar50" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar50" name="totalMostrar50" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total50" name="total50" type="hidden" value="155.031" required="">


                                                    </div>

                                                    <input id="idBodega50" name="idBodega50" type="hidden" value="6">
                                                    <input id="idSeccion50" name="idSeccion50" type="hidden" value="40">
                                                    <input id="restaInventario50" name="restaInventario50" type="hidden" value="1">
                                                    <input id="isv50" name="isv50" type="hidden" value="15">



                                </div>

                                <div id="51" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(51)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto51" name="idProducto51" type="hidden" value="1564">

                                                            <div style="width:100%">
                                                                <label for="nombre51" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre51" name="nombre51" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1564 - FOLDER DE COLOR PASTEL T/CARTA ROSADO OFINOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 F 1" placeholder="bodega-seccion" id="bodega51" name="bodega51" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio51" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio51" name="precio51" value="134.81" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="134.81" onchange="calcularTotales(precio51,cantidad51,15,unidad51,51,restaInventario51)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad51" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad51" name="cantidad51" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio51,cantidad51,15,unidad51,51,restaInventario51)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad51" id="unidad51" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio51,cantidad51,15,unidad51,51,restaInventario51)">
                                                                    <option selected="" value="1" data-id="565"> RESMA-1</option><option value="1" data-id="1784">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar51" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar51" name="subTotalMostrar51" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal51" name="subTotal51" type="hidden" value="134.810" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar51" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar51" name="isvProductoMostrar51" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto51" name="isvProducto51" type="hidden" value="20.221" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar51" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar51" name="totalMostrar51" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total51" name="total51" type="hidden" value="155.031" required="">


                                                    </div>

                                                    <input id="idBodega51" name="idBodega51" type="hidden" value="6">
                                                    <input id="idSeccion51" name="idSeccion51" type="hidden" value="40">
                                                    <input id="restaInventario51" name="restaInventario51" type="hidden" value="1">
                                                    <input id="isv51" name="isv51" type="hidden" value="15">



                                </div>

                                <div id="52" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(52)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto52" name="idProducto52" type="hidden" value="1565">

                                                            <div style="width:100%">
                                                                <label for="nombre52" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre52" name="nombre52" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1565 - FOLDER DE COLOR PASTEL T/CARTA VERDE OFINOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 F 1" placeholder="bodega-seccion" id="bodega52" name="bodega52" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio52" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio52" name="precio52" value="134.82" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="134.82" onchange="calcularTotales(precio52,cantidad52,15,unidad52,52,restaInventario52)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad52" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad52" name="cantidad52" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio52,cantidad52,15,unidad52,52,restaInventario52)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad52" id="unidad52" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio52,cantidad52,15,unidad52,52,restaInventario52)">
                                                                    <option selected="" value="1" data-id="566"> RESMA-1</option><option value="1" data-id="1785">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar52" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar52" name="subTotalMostrar52" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal52" name="subTotal52" type="hidden" value="134.820" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar52" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar52" name="isvProductoMostrar52" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto52" name="isvProducto52" type="hidden" value="20.223" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar52" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar52" name="totalMostrar52" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total52" name="total52" type="hidden" value="155.043" required="">


                                                    </div>

                                                    <input id="idBodega52" name="idBodega52" type="hidden" value="6">
                                                    <input id="idSeccion52" name="idSeccion52" type="hidden" value="40">
                                                    <input id="restaInventario52" name="restaInventario52" type="hidden" value="1">
                                                    <input id="isv52" name="isv52" type="hidden" value="15">



                                </div>

                                <div id="53" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(53)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto53" name="idProducto53" type="hidden" value="1161">

                                                            <div style="width:100%">
                                                                <label for="nombre53" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre53" name="nombre53" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1161 - BOLSA PLASTICA PARA BASURA (25 UND) 24X32 NEGRA VANGUARDIA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 D 1" placeholder="bodega-seccion" id="bodega53" name="bodega53" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio53" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio53" name="precio53" value="18.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="18.00" onchange="calcularTotales(precio53,cantidad53,15,unidad53,53,restaInventario53)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad53" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad53" name="cantidad53" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio53,cantidad53,15,unidad53,53,restaInventario53)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad53" id="unidad53" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio53,cantidad53,15,unidad53,53,restaInventario53)">
                                                                    <option selected="" value="1" data-id="162">POR DEFECTO-1</option><option value="1" data-id="1381">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar53" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar53" name="subTotalMostrar53" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal53" name="subTotal53" type="hidden" value="18.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar53" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar53" name="isvProductoMostrar53" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto53" name="isvProducto53" type="hidden" value="2.700" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar53" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar53" name="totalMostrar53" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total53" name="total53" type="hidden" value="20.700" required="">


                                                    </div>

                                                    <input id="idBodega53" name="idBodega53" type="hidden" value="7">
                                                    <input id="idSeccion53" name="idSeccion53" type="hidden" value="57">
                                                    <input id="restaInventario53" name="restaInventario53" type="hidden" value="1">
                                                    <input id="isv53" name="isv53" type="hidden" value="15">



                                </div>

                                <div id="54" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(54)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto54" name="idProducto54" type="hidden" value="1625">

                                                            <div style="width:100%">
                                                                <label for="nombre54" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre54" name="nombre54" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1625 - LANILLA LN011 VERDE OSCURO">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 E1" placeholder="bodega-seccion" id="bodega54" name="bodega54" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio54" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio54" name="precio54" value="4.76" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="4.76" onchange="calcularTotales(precio54,cantidad54,15,unidad54,54,restaInventario54)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad54" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad54" name="cantidad54" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio54,cantidad54,15,unidad54,54,restaInventario54)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad54" id="unidad54" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio54,cantidad54,15,unidad54,54,restaInventario54)">
                                                                    <option selected="" value="1" data-id="626">UNIDAD-1</option><option value="1" data-id="1845">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar54" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar54" name="subTotalMostrar54" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal54" name="subTotal54" type="hidden" value="4.760" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar54" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar54" name="isvProductoMostrar54" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto54" name="isvProducto54" type="hidden" value="0.714" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar54" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar54" name="totalMostrar54" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total54" name="total54" type="hidden" value="5.474" required="">


                                                    </div>

                                                    <input id="idBodega54" name="idBodega54" type="hidden" value="6">
                                                    <input id="idSeccion54" name="idSeccion54" type="hidden" value="41">
                                                    <input id="restaInventario54" name="restaInventario54" type="hidden" value="1">
                                                    <input id="isv54" name="isv54" type="hidden" value="15">



                                </div>

                                <div id="55" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(55)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto55" name="idProducto55" type="hidden" value="1626">

                                                            <div style="width:100%">
                                                                <label for="nombre55" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre55" name="nombre55" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1626 - LANILLA LN012 ROJO">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 E1" placeholder="bodega-seccion" id="bodega55" name="bodega55" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio55" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio55" name="precio55" value="4.75" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="4.75" onchange="calcularTotales(precio55,cantidad55,15,unidad55,55,restaInventario55)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad55" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad55" name="cantidad55" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio55,cantidad55,15,unidad55,55,restaInventario55)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad55" id="unidad55" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio55,cantidad55,15,unidad55,55,restaInventario55)">
                                                                    <option selected="" value="1" data-id="627">UNIDAD-1</option><option value="1" data-id="1846">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar55" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar55" name="subTotalMostrar55" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal55" name="subTotal55" type="hidden" value="4.750" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar55" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar55" name="isvProductoMostrar55" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto55" name="isvProducto55" type="hidden" value="0.713" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar55" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar55" name="totalMostrar55" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total55" name="total55" type="hidden" value="5.463" required="">


                                                    </div>

                                                    <input id="idBodega55" name="idBodega55" type="hidden" value="6">
                                                    <input id="idSeccion55" name="idSeccion55" type="hidden" value="41">
                                                    <input id="restaInventario55" name="restaInventario55" type="hidden" value="1">
                                                    <input id="isv55" name="isv55" type="hidden" value="15">



                                </div>

                                <div id="56" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(56)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto56" name="idProducto56" type="hidden" value="1531">

                                                            <div style="width:100%">
                                                                <label for="nombre56" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre56" name="nombre56" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1531 - FOLDER DE COLOR (100 UND) T/CARTA AZUL ZAFIRO ARCOLOR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 E 2" placeholder="bodega-seccion" id="bodega56" name="bodega56" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio56" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio56" name="precio56" value="250.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="250.00" onchange="calcularTotales(precio56,cantidad56,15,unidad56,56,restaInventario56)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad56" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad56" name="cantidad56" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio56,cantidad56,15,unidad56,56,restaInventario56)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad56" id="unidad56" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio56,cantidad56,15,unidad56,56,restaInventario56)">
                                                                    <option selected="" value="1" data-id="532"> RESMA-1</option><option value="1" data-id="1751">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar56" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar56" name="subTotalMostrar56" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal56" name="subTotal56" type="hidden" value="250.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar56" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar56" name="isvProductoMostrar56" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto56" name="isvProducto56" type="hidden" value="37.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar56" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar56" name="totalMostrar56" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total56" name="total56" type="hidden" value="287.500" required="">


                                                    </div>

                                                    <input id="idBodega56" name="idBodega56" type="hidden" value="8">
                                                    <input id="idSeccion56" name="idSeccion56" type="hidden" value="103">
                                                    <input id="restaInventario56" name="restaInventario56" type="hidden" value="1">
                                                    <input id="isv56" name="isv56" type="hidden" value="15">



                                </div>

                                <div id="57" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(57)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto57" name="idProducto57" type="hidden" value="1532">

                                                            <div style="width:100%">
                                                                <label for="nombre57" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre57" name="nombre57" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1532 - FOLDER T/CARTA DE COLOR CAFE CLARO ARCOLOR">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 1 F 1" placeholder="bodega-seccion" id="bodega57" name="bodega57" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio57" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio57" name="precio57" value="225.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="225.00" onchange="calcularTotales(precio57,cantidad57,15,unidad57,57,restaInventario57)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad57" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad57" name="cantidad57" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio57,cantidad57,15,unidad57,57,restaInventario57)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad57" id="unidad57" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio57,cantidad57,15,unidad57,57,restaInventario57)">
                                                                    <option selected="" value="1" data-id="533"> RESMA-1</option><option value="1" data-id="1752">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar57" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar57" name="subTotalMostrar57" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal57" name="subTotal57" type="hidden" value="225.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar57" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar57" name="isvProductoMostrar57" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto57" name="isvProducto57" type="hidden" value="33.750" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar57" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar57" name="totalMostrar57" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total57" name="total57" type="hidden" value="258.750" required="">


                                                    </div>

                                                    <input id="idBodega57" name="idBodega57" type="hidden" value="6">
                                                    <input id="idSeccion57" name="idSeccion57" type="hidden" value="40">
                                                    <input id="restaInventario57" name="restaInventario57" type="hidden" value="1">
                                                    <input id="isv57" name="isv57" type="hidden" value="15">



                                </div>

                                <div id="58" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(58)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto58" name="idProducto58" type="hidden" value="2047">

                                                            <div style="width:100%">
                                                                <label for="nombre58" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre58" name="nombre58" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2047 - PAPER CLIPS NO.1 (100PCS) BS-1531 BENSSINI">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 H 1" placeholder="bodega-seccion" id="bodega58" name="bodega58" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio58" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio58" name="precio58" value="4.95" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="4.95" onchange="calcularTotales(precio58,cantidad58,15,unidad58,58,restaInventario58)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad58" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad58" name="cantidad58" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio58,cantidad58,15,unidad58,58,restaInventario58)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad58" id="unidad58" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio58,cantidad58,15,unidad58,58,restaInventario58)">
                                                                    <option selected="" value="1" data-id="1048"> CAJA-1</option><option value="1" data-id="2267">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar58" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar58" name="subTotalMostrar58" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal58" name="subTotal58" type="hidden" value="4.950" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar58" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar58" name="isvProductoMostrar58" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto58" name="isvProducto58" type="hidden" value="0.743" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar58" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar58" name="totalMostrar58" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total58" name="total58" type="hidden" value="5.692" required="">


                                                    </div>

                                                    <input id="idBodega58" name="idBodega58" type="hidden" value="7">
                                                    <input id="idSeccion58" name="idSeccion58" type="hidden" value="77">
                                                    <input id="restaInventario58" name="restaInventario58" type="hidden" value="1">
                                                    <input id="isv58" name="isv58" type="hidden" value="15">



                                </div>

                                <div id="59" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(59)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto59" name="idProducto59" type="hidden" value="1504">

                                                            <div style="width:100%">
                                                                <label for="nombre59" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre59" name="nombre59" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1504 - FASTENER METÁLICO NO.8  WEXFM8 A2015 50 SEP 80MM WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 3 A 1" placeholder="bodega-seccion" id="bodega59" name="bodega59" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio59" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio59" name="precio59" value="19.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="19.50" onchange="calcularTotales(precio59,cantidad59,15,unidad59,59,restaInventario59)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad59" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad59" name="cantidad59" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio59,cantidad59,15,unidad59,59,restaInventario59)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad59" id="unidad59" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio59,cantidad59,15,unidad59,59,restaInventario59)">
                                                                    <option selected="" value="1" data-id="505"> CAJA-1</option><option value="1" data-id="1724">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar59" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar59" name="subTotalMostrar59" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal59" name="subTotal59" type="hidden" value="19.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar59" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar59" name="isvProductoMostrar59" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto59" name="isvProducto59" type="hidden" value="2.925" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar59" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar59" name="totalMostrar59" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total59" name="total59" type="hidden" value="22.425" required="">


                                                    </div>

                                                    <input id="idBodega59" name="idBodega59" type="hidden" value="5">
                                                    <input id="idSeccion59" name="idSeccion59" type="hidden" value="37">
                                                    <input id="restaInventario59" name="restaInventario59" type="hidden" value="1">
                                                    <input id="isv59" name="isv59" type="hidden" value="15">



                                </div>

                                <div id="60" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(60)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto60" name="idProducto60" type="hidden" value="1588">

                                                            <div style="width:100%">
                                                                <label for="nombre60" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre60" name="nombre60" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1588 - GUANTES DE HULE COLOR AMARILLO CH">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 J1" placeholder="bodega-seccion" id="bodega60" name="bodega60" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio60" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio60" name="precio60" value="37.56" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="37.56" onchange="calcularTotales(precio60,cantidad60,15,unidad60,60,restaInventario60)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad60" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad60" name="cantidad60" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio60,cantidad60,15,unidad60,60,restaInventario60)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad60" id="unidad60" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio60,cantidad60,15,unidad60,60,restaInventario60)">
                                                                    <option selected="" value="1" data-id="589"> PAR-1</option><option value="1" data-id="1808">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar60" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar60" name="subTotalMostrar60" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal60" name="subTotal60" type="hidden" value="37.560" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar60" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar60" name="isvProductoMostrar60" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto60" name="isvProducto60" type="hidden" value="5.634" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar60" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar60" name="totalMostrar60" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total60" name="total60" type="hidden" value="43.194" required="">


                                                    </div>

                                                    <input id="idBodega60" name="idBodega60" type="hidden" value="7">
                                                    <input id="idSeccion60" name="idSeccion60" type="hidden" value="142">
                                                    <input id="restaInventario60" name="restaInventario60" type="hidden" value="1">
                                                    <input id="isv60" name="isv60" type="hidden" value="15">



                                </div>

                                <div id="61" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(61)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto61" name="idProducto61" type="hidden" value="2141">

                                                            <div style="width:100%">
                                                                <label for="nombre61" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre61" name="nombre61" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2141 - TABLERO DE MADERA T/CARTA TMW500 WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 F 1" placeholder="bodega-seccion" id="bodega61" name="bodega61" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio61" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio61" name="precio61" value="23.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="23.50" onchange="calcularTotales(precio61,cantidad61,15,unidad61,61,restaInventario61)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad61" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad61" name="cantidad61" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio61,cantidad61,15,unidad61,61,restaInventario61)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad61" id="unidad61" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio61,cantidad61,15,unidad61,61,restaInventario61)">
                                                                    <option selected="" value="1" data-id="1142">UNIDAD-1</option><option value="1" data-id="2361">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar61" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar61" name="subTotalMostrar61" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal61" name="subTotal61" type="hidden" value="23.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar61" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar61" name="isvProductoMostrar61" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto61" name="isvProducto61" type="hidden" value="3.525" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar61" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar61" name="totalMostrar61" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total61" name="total61" type="hidden" value="27.025" required="">


                                                    </div>

                                                    <input id="idBodega61" name="idBodega61" type="hidden" value="8">
                                                    <input id="idSeccion61" name="idSeccion61" type="hidden" value="107">
                                                    <input id="restaInventario61" name="restaInventario61" type="hidden" value="1">
                                                    <input id="isv61" name="isv61" type="hidden" value="15">



                                </div>

                                <div id="62" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(62)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto62" name="idProducto62" type="hidden" value="2353">

                                                            <div style="width:100%">
                                                                <label for="nombre62" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre62" name="nombre62" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2353 - CARTULINA IRIS COLOR RED PAPERLINE">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 A 1" placeholder="bodega-seccion" id="bodega62" name="bodega62" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio62" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio62" name="precio62" value="5.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="5.00" onchange="calcularTotales(precio62,cantidad62,15,unidad62,62,restaInventario62)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad62" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad62" name="cantidad62" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio62,cantidad62,15,unidad62,62,restaInventario62)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad62" id="unidad62" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio62,cantidad62,15,unidad62,62,restaInventario62)">
                                                                    <option selected="" value="1" data-id="2589"> PLIEGO-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar62" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar62" name="subTotalMostrar62" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal62" name="subTotal62" type="hidden" value="5.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar62" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar62" name="isvProductoMostrar62" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto62" name="isvProducto62" type="hidden" value="0.750" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar62" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar62" name="totalMostrar62" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total62" name="total62" type="hidden" value="5.750" required="">


                                                    </div>

                                                    <input id="idBodega62" name="idBodega62" type="hidden" value="7">
                                                    <input id="idSeccion62" name="idSeccion62" type="hidden" value="42">
                                                    <input id="restaInventario62" name="restaInventario62" type="hidden" value="1">
                                                    <input id="isv62" name="isv62" type="hidden" value="15">



                                </div>

                                <div id="63" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(63)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto63" name="idProducto63" type="hidden" value="2355">

                                                            <div style="width:100%">
                                                                <label for="nombre63" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre63" name="nombre63" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2355 - DETERGENTE DE 1 LIBRA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 2 A 1" placeholder="bodega-seccion" id="bodega63" name="bodega63" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio63" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio63" name="precio63" value="14.94" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="14.94" onchange="calcularTotales(precio63,cantidad63,15,unidad63,63,restaInventario63)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad63" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad63" name="cantidad63" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio63,cantidad63,15,unidad63,63,restaInventario63)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad63" id="unidad63" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio63,cantidad63,15,unidad63,63,restaInventario63)">
                                                                    <option selected="" value="1" data-id="2591"> LIBRA-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar63" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar63" name="subTotalMostrar63" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal63" name="subTotal63" type="hidden" value="14.940" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar63" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar63" name="isvProductoMostrar63" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto63" name="isvProducto63" type="hidden" value="2.241" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar63" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar63" name="totalMostrar63" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total63" name="total63" type="hidden" value="17.181" required="">


                                                    </div>

                                                    <input id="idBodega63" name="idBodega63" type="hidden" value="7">
                                                    <input id="idSeccion63" name="idSeccion63" type="hidden" value="42">
                                                    <input id="restaInventario63" name="restaInventario63" type="hidden" value="1">
                                                    <input id="isv63" name="isv63" type="hidden" value="15">



                                </div>

                                <div id="64" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(64)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto64" name="idProducto64" type="hidden" value="2118">

                                                            <div style="width:100%">
                                                                <label for="nombre64" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre64" name="nombre64" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2118 - SEPARADORES PARA CARPETAS POINTER T/CARTA (5 DIVISIONES) A05">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 E 3" placeholder="bodega-seccion" id="bodega64" name="bodega64" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio64" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio64" name="precio64" value="12.60" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="12.60" onchange="calcularTotales(precio64,cantidad64,15,unidad64,64,restaInventario64)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad64" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad64" name="cantidad64" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio64,cantidad64,15,unidad64,64,restaInventario64)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad64" id="unidad64" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio64,cantidad64,15,unidad64,64,restaInventario64)">
                                                                    <option selected="" value="1" data-id="1119"> PAQUETE-1</option><option value="1" data-id="2338">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar64" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar64" name="subTotalMostrar64" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal64" name="subTotal64" type="hidden" value="12.600" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar64" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar64" name="isvProductoMostrar64" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto64" name="isvProducto64" type="hidden" value="1.890" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar64" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar64" name="totalMostrar64" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total64" name="total64" type="hidden" value="14.490" required="">


                                                    </div>

                                                    <input id="idBodega64" name="idBodega64" type="hidden" value="8">
                                                    <input id="idSeccion64" name="idSeccion64" type="hidden" value="104">
                                                    <input id="restaInventario64" name="restaInventario64" type="hidden" value="1">
                                                    <input id="isv64" name="isv64" type="hidden" value="15">



                                </div>

                                <div id="65" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(65)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto65" name="idProducto65" type="hidden" value="2033">

                                                            <div style="width:100%">
                                                                <label for="nombre65" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre65" name="nombre65" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2033 - PAPEL TERMICO 3 1/8 BLANCO OFI-NOTA">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="BODEGA LA JOYA A 1" placeholder="bodega-seccion" id="bodega65" name="bodega65" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio65" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio65" name="precio65" value="19.40" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="19.40" onchange="calcularTotales(precio65,cantidad65,15,unidad65,65,restaInventario65)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad65" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad65" name="cantidad65" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio65,cantidad65,15,unidad65,65,restaInventario65)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad65" id="unidad65" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio65,cantidad65,15,unidad65,65,restaInventario65)">
                                                                    <option selected="" value="1" data-id="1034"> ROLLO-1</option><option value="75" data-id="2253"> CAJA-75</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar65" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar65" name="subTotalMostrar65" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal65" name="subTotal65" type="hidden" value="19.400" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar65" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar65" name="isvProductoMostrar65" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto65" name="isvProducto65" type="hidden" value="2.910" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar65" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar65" name="totalMostrar65" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total65" name="total65" type="hidden" value="22.310" required="">


                                                    </div>

                                                    <input id="idBodega65" name="idBodega65" type="hidden" value="9">
                                                    <input id="idSeccion65" name="idSeccion65" type="hidden" value="130">
                                                    <input id="restaInventario65" name="restaInventario65" type="hidden" value="1">
                                                    <input id="isv65" name="isv65" type="hidden" value="15">



                                </div>

                                <div id="66" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(66)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto66" name="idProducto66" type="hidden" value="1285">

                                                            <div style="width:100%">
                                                                <label for="nombre66" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre66" name="nombre66" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1285 - CORRECTOR EN CINTA CTB07 WEX TPW610">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="CENTRAL 1 B 1" placeholder="bodega-seccion" id="bodega66" name="bodega66" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio66" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio66" name="precio66" value="17.50" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="17.50" onchange="calcularTotales(precio66,cantidad66,15,unidad66,66,restaInventario66)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad66" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad66" name="cantidad66" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio66,cantidad66,15,unidad66,66,restaInventario66)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad66" id="unidad66" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio66,cantidad66,15,unidad66,66,restaInventario66)">
                                                                    <option selected="" value="1" data-id="286">UNIDAD-1</option><option value="1" data-id="1505">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar66" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar66" name="subTotalMostrar66" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal66" name="subTotal66" type="hidden" value="17.500" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar66" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar66" name="isvProductoMostrar66" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto66" name="isvProducto66" type="hidden" value="2.625" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar66" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar66" name="totalMostrar66" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total66" name="total66" type="hidden" value="20.125" required="">


                                                    </div>

                                                    <input id="idBodega66" name="idBodega66" type="hidden" value="8">
                                                    <input id="idSeccion66" name="idSeccion66" type="hidden" value="87">
                                                    <input id="restaInventario66" name="restaInventario66" type="hidden" value="1">
                                                    <input id="isv66" name="isv66" type="hidden" value="15">



                                </div>

                                <div id="67" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(67)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto67" name="idProducto67" type="hidden" value="2267">

                                                            <div style="width:100%">
                                                                <label for="nombre67" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre67" name="nombre67" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="2267 - CUADERNO UNICO CORTO 200 PAG WEX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 5 B 1" placeholder="bodega-seccion" id="bodega67" name="bodega67" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio67" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio67" name="precio67" value="23.00" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="23.00" onchange="calcularTotales(precio67,cantidad67,0,unidad67,67,restaInventario67)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad67" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad67" name="cantidad67" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio67,cantidad67,0,unidad67,67,restaInventario67)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad67" id="unidad67" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio67,cantidad67,0,unidad67,67,restaInventario67)">
                                                                    <option selected="" value="1" data-id="2498"> UNIDAD-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar67" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar67" name="subTotalMostrar67" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal67" name="subTotal67" type="hidden" value="23.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar67" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar67" name="isvProductoMostrar67" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto67" name="isvProducto67" type="hidden" value="0.000" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar67" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar67" name="totalMostrar67" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total67" name="total67" type="hidden" value="23.000" required="">


                                                    </div>

                                                    <input id="idBodega67" name="idBodega67" type="hidden" value="1">
                                                    <input id="idSeccion67" name="idSeccion67" type="hidden" value="1">
                                                    <input id="restaInventario67" name="restaInventario67" type="hidden" value="1">
                                                    <input id="isv67" name="isv67" type="hidden" value="0">



                                </div>

                                <div id="68" class="row no-gutters">
                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <div class="d-flex">

                                                            <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(68)"><i class="fa-regular fa-rectangle-xmark"></i>
                                                            </button>

                                                            <input id="idProducto68" name="idProducto68" type="hidden" value="1978">

                                                            <div style="width:100%">
                                                                <label for="nombre68" class="sr-only">Nombre del producto</label>
                                                                <input type="text" placeholder="Nombre del producto" id="nombre68" name="nombre68" class="form-control" data-parsley-required="" "="" autocomplete="off" readonly="" value="1978 - PAPEL CREPE SYSABE COLOR AZUL ELECTRICO">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">cantidad</label>
                                                        <input type="text" value="ANEXO 4 B 4" placeholder="bodega-seccion" id="bodega68" name="bodega68" class="form-control" autocomplete="off" readonly="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="precio68" class="sr-only">Precio</label>
                                                        <input type="number" placeholder="Precio Unidad" id="precio68" name="precio68" value="4.24" class="form-control" data-parsley-required="" step="any" autocomplete="off" min="4.24" onchange="calcularTotales(precio68,cantidad68,15,unidad68,68,restaInventario68)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="cantidad68" class="sr-only">cantidad</label>
                                                        <input type="number" placeholder="Cantidad" id="cantidad68" name="cantidad68" class="form-control" min="1" data-parsley-required="" autocomplete="off" onchange="calcularTotales(precio68,cantidad68,15,unidad68,68,restaInventario68)">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                        <label for="" class="sr-only">unidad</label>
                                                        <select class="form-control" name="unidad68" id="unidad68" data-parsley-required="" style="height:35.7px;" onchange="calcularTotales(precio68,cantidad68,15,unidad68,68,restaInventario68)">
                                                                    <option selected="" value="1" data-id="979"> PLIEGO-1</option><option value="1" data-id="2198">POR DEFECTO DOS-1</option>
                                                        </select>


                                                    </div>




                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="subTotalMostrar68" class="sr-only">Sub Total</label>
                                                        <input type="text" placeholder="Sub total producto" id="subTotalMostrar68" name="subTotalMostrar68" class="form-control" autocomplete="off" readonly="">

                                                        <input id="subTotal68" name="subTotal68" type="hidden" value="4.240" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="isvProductoMostrar68" class="sr-only">ISV</label>
                                                        <input type="text" placeholder="ISV" id="isvProductoMostrar68" name="isvProductoMostrar68" class="form-control" autocomplete="off" readonly="">

                                                            <input id="isvProducto68" name="isvProducto68" type="hidden" value="0.636" required="">
                                                    </div>

                                                    <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="totalMostrar68" class="sr-only">Total</label>
                                                        <input type="text" placeholder="Total del producto" id="totalMostrar68" name="totalMostrar68" class="form-control" autocomplete="off" readonly="">

                                                            <input id="total68" name="total68" type="hidden" value="4.876" required="">


                                                    </div>

                                                    <input id="idBodega68" name="idBodega68" type="hidden" value="4">
                                                    <input id="idSeccion68" name="idSeccion68" type="hidden" value="36">
                                                    <input id="restaInventario68" name="restaInventario68" type="hidden" value="1">
                                                    <input id="isv68" name="isv68" type="hidden" value="15">



                                </div>
                                </div>
                            {{-- <div class="table-responsive">
                                <table id="tbl_productos_venta" class="table table-striped table-bordered table-hover">
                                    <thead class="">
                                        <tr>
                                            <th><label class="sr-only">Total</label>
                                                <input type="number" placeholder="Total del producto" class="form-control"
                                                    min="1"  autocomplete="off" style="min-width: 100px">
                                            </th>
                                            <th><label class="sr-only">Total</label>
                                                <input type="number" placeholder="Total del producto" class="form-control"
                                                    min="1" disabled autocomplete="off" style="min-width: 100px">
                                            </th>
                                            <th><label class="sr-only">Total</label>
                                                <input type="number" placeholder="Total del producto" class="form-control"
                                                    min="1" disabled autocomplete="off" style="min-width: 100px">
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div> --}}









                            <hr>
                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="subTotalGeneralMostrar">Sub Total L.<span class="text-danger">*</span></label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="text"  placeholder="Sub total " id="subTotalGeneralMostrar"
                                        name="subTotalGeneralMostrar" class="form-control"  data-parsley-required
                                        autocomplete="off" readonly>

                                        <input id="subTotalGeneral" name="subTotalGeneral" type="hidden" value="" required>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="isvGeneralMostrar">ISV L.<span class="text-danger">*</span></label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="text"  placeholder="ISV " id="isvGeneralMostrar" name="isvGeneralMostrar"
                                        class="form-control" data-parsley-required autocomplete="off"
                                        readonly>
                                        <input id="isvGeneral" name="isvGeneral" type="hidden" value="" required>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="totalGeneralMostrar">Total L.<span class="text-danger">*</span></label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="text"  placeholder="Total  " id="totalGeneralMostrar"
                                        name="totalGeneralMostrar" class="form-control" data-parsley-required
                                        autocomplete="off" readonly>

                                        <input id="totalGeneral" name="totalGeneral" type="hidden" value="" required>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <button id="btn_venta_coorporativa" class="btn  btn-primary float-left m-t-n-xs"><strong>
                                            Realizar Venta</strong></button>
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
            var arregloIdInputs = [1,2,3,4,5];
            var retencionEstado = false; // true  aplica retencion, false no aplica retencion;

            window.onload = obtenerTipoPago;
            var public_path = "{{ asset('catalogo/') }}";
            var diasCredito = 0;



            $('#vendedor').select2({
                ajax:{
                    url:'/ventas/corporativo/vendedores',
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



            $('#seleccionarCliente').select2({
                ajax: {
                    url: '/ventas/lista/clientes',
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




                $('#seleccionarProducto').select2({
                    ajax: {
                        url: '/ventas/listar',
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

            function prueba(){

                var element = document.getElementById('botonAdd');
                element.classList.remove("d-none");

            }

            function obtenerBodegas(id){

                document.getElementById('bodega').innerHTML="<option  selected disabled>--Seleccione una bodega--</option>";
                let idProducto = id;
                $('#bodega').select2({
                ajax: {
                    url: '/ventas/listar/bodegas/'+idProducto,
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public',
                            page: params.page || 1,
                            idProducto: idProducto
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    }
                }
            });

            }


            function obtenerTipoPago() {

                axios.get('/ventas/tipo/pago')
                    .then(response => {

                        let tipoDePago = response.data.tipos;
                        let numeroVenta = response.data.numeroVenta.numero;

                        let htmlPagos = '  <option value="" selected disabled >--Seleccione una opcion--</option>';

                        tipoDePago.forEach(element => {

                            htmlPagos += `
                            <option value="${element.id}" >${element.descripcion}</option>
                            `
                        });

                        document.getElementById('tipoPagoVenta').innerHTML = htmlPagos;
                        document.getElementById("numero_venta").value = numeroVenta;


                    })
                    .catch(err => {
                        console.log(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: "Ha ocurrido un error al obtener los tipos de pago"
                        })
                    })

            }

            function obtenerImagenes() {
                let id = document.getElementById('seleccionarProducto').value;

                document.getElementById("bodega").disabled = false;
                let htmlImagenes = '';
                axios.post('/producto/listar/imagenes', {
                        id: id,

                    })
                    .then(response => {

                        let imagenes = response.data.imagenes;

                        if (imagenes.length == 0) {

                            console.log("entro")
                            htmlImagenes += `
                            <div class="carousel-item active " >
                                <img  class="d-block  img-size" src="${public_path+'/'+'noimage.png'}" alt="noimage.png"  >
                            </div>`

                            document.getElementById('bloqueImagenes').innerHTML = htmlImagenes;

                            var element = document.getElementById('botonAdd');
                            element.classList.remove("d-none");

                        } else {
                            imagenes.forEach(element => {

                                if (element.contador == 1) {
                                    htmlImagenes += `
                            <div class="carousel-item active " >
                                <img class="d-block  img-size" src="${public_path+'/'+element.url_img}" alt="imagen ${element.contador}"  >
                            </div>`
                                } else {

                                    htmlImagenes += `
                            <div class="carousel-item  " >
                                <img class="d-block  img-size" src="${public_path+'/'+element.url_img}" alt="imagen ${element.contador}"  >
                            </div>`

                                }

                            });

                            document.getElementById('bloqueImagenes').innerHTML = htmlImagenes;


                        }

                        var element = document.getElementById('botonAdd');
                        element.classList.add("d-none");

                        let a = document.getElementById("detalleProducto");
                        let url = "/producto/detalle/"+id;
                        a.href = url;
                        a.classList.remove("d-none");

                        return;



                    })
                    .catch(err => {

                        console.log(err);

                    })

                    obtenerBodegas(id);
            }

            function agregarProductoCarrito() {
                let idProducto = document.getElementById('seleccionarProducto').value;

                let data = $("#bodega").select2('data')[0];
                let bodega = data.bodegaSeccion;
                let idBodega = data.idBodega;
                let idSeccion = data.id


                axios.post('/ventas/datos/producto', {
                        idProducto : idProducto,

                    })
                    .then(response => {

                        let flag = false;
                        arregloIdInputs.forEach( idInpunt =>{
                            let idProductoFila = document.getElementById("idProducto"+idInpunt).value;
                            let idSeccionFila = document.getElementById("idSeccion"+idInpunt).value;



                            if( idProducto==idProductoFila && idSeccion==idSeccionFila && !flag){
                                flag = true;
                            }

                        })

                        if(flag){
                            Swal.fire({

                            icon: 'warning',
                            title: 'Advertencia!',
                            html: `
                            <p class="text-left">
                                La sección de bodega y producto ha sido agregada anteriormente.<br><br>
                                Por favor verificar la sección de bodega y producto sea distinto a los ya existentes en la lista de venta.<br><br>
                                De ser necesario aumentar la cantidad de producto en la lista de productos seleccionados para la venta.
                            </p>`
                        })

                        return;
                        }

                        let producto = response.data.producto;
                        let precio_base = new Intl.NumberFormat('es-HN').format(producto.precio_base);

                        let arrayUnidades = response.data.unidades;


                        numeroInputs += 1;

                        //     let arraySecciones  = response.data.secciones;
                        // htmlSelectSeccion ="<option selected disabled>--seccion--</option>";

                        // arraySecciones.forEach(seccion => {
                        //     htmlSelectSeccion += `<option values="${seccion.id}" >${seccion.descripcion}</option>`
                        // });

                        htmlSelectUnidades = ""
                        arrayUnidades.forEach(unidad => {
                            if(unidad.valor_defecto == 1){
                                htmlSelectUnidades += `<option selected value="${unidad.id}" data-id="${unidad.idUnidadVenta}">${unidad.nombre}</option>`;
                            }else{
                                htmlSelectUnidades += `<option  value="${unidad.id}" data-id="${unidad.idUnidadVenta}">${unidad.nombre}</option>`;
                            }

                        });


                        html = `
                        <div id='${numeroInputs}' class="row no-gutters">
                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div class="d-flex">

                                                    <button class="btn btn-danger" type="button" style="display: inline" onclick="eliminarInput(${numeroInputs})"><i
                                                            class="fa-regular fa-rectangle-xmark"></i>
                                                    </button>

                                                    <input id="idProducto${numeroInputs}" name="idProducto${numeroInputs}" type="hidden" value="${producto.id}">

                                                    <div style="width:100%">
                                                        <label for="nombre${numeroInputs}" class="sr-only">Nombre del producto</label>
                                                        <input type="text" placeholder="Nombre del producto" id="nombre${numeroInputs}"
                                                            name="nombre${numeroInputs}" class="form-control"
                                                            data-parsley-required "
                                                            autocomplete="off"
                                                            readonly
                                                            value='${producto.nombre}'

                                                            >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                <label for="" class="sr-only">cantidad</label>
                                                <input type="text" value="${bodega}" placeholder="bodega-seccion" id="bodega${numeroInputs}"
                                                    name="bodega${numeroInputs}" class="form-control"
                                                    autocomplete="off"  readonly  >
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                <label for="precio${numeroInputs}" class="sr-only">Precio</label>
                                                <input type="number" placeholder="Precio Unidad" id="precio${numeroInputs}"
                                                    name="precio${numeroInputs}" value="${producto.precio_base}" class="form-control"  data-parsley-required step="any"
                                                    autocomplete="off" min="${producto.precio_base}" onchange="calcularTotales(precio${numeroInputs},cantidad${numeroInputs},${producto.isv},unidad${numeroInputs},${numeroInputs},restaInventario${numeroInputs})">
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                <label for="cantidad${numeroInputs}" class="sr-only">cantidad</label>
                                                <input type="number" placeholder="Cantidad" id="cantidad${numeroInputs}"
                                                    name="cantidad${numeroInputs}" class="form-control" min="1" data-parsley-required
                                                    autocomplete="off" onchange="calcularTotales(precio${numeroInputs},cantidad${numeroInputs},${producto.isv},unidad${numeroInputs},${numeroInputs},restaInventario${numeroInputs})">
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                                <label for="" class="sr-only">unidad</label>
                                                <select class="form-control" name="unidad${numeroInputs}" id="unidad${numeroInputs}"
                                                    data-parsley-required style="height:35.7px;"
                                                    onchange="calcularTotales(precio${numeroInputs},cantidad${numeroInputs},${producto.isv},unidad${numeroInputs},${numeroInputs},restaInventario${numeroInputs})">
                                                            ${htmlSelectUnidades}
                                                </select>


                                            </div>




                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <label for="subTotalMostrar${numeroInputs}" class="sr-only">Sub Total</label>
                                                <input type="text" placeholder="Sub total producto" id="subTotalMostrar${numeroInputs}"
                                                    name="subTotalMostrar${numeroInputs}" class="form-control"
                                                    autocomplete="off"
                                                    readonly >

                                                <input id="subTotal${numeroInputs}" name="subTotal${numeroInputs}" type="hidden" value="" required>
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <label for="isvProductoMostrar${numeroInputs}" class="sr-only">ISV</label>
                                                <input type="text" placeholder="ISV" id="isvProductoMostrar${numeroInputs}"
                                                    name="isvProductoMostrar${numeroInputs}" class="form-control"
                                                    autocomplete="off"
                                                    readonly >

                                                    <input id="isvProducto${numeroInputs}" name="isvProducto${numeroInputs}" type="hidden" value="" required>
                                            </div>

                                            <div class="form-group col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <label for="totalMostrar${numeroInputs}" class="sr-only">Total</label>
                                                <input type="text" placeholder="Total del producto" id="totalMostrar${numeroInputs}"
                                                    name="totalMostrar${numeroInputs}" class="form-control"
                                                    autocomplete="off"
                                                    readonly >

                                                    <input id="total${numeroInputs}" name="total${numeroInputs}" type="hidden" value="" required>


                                            </div>

                                            <input id="idBodega${numeroInputs}" name="idBodega${numeroInputs}" type="hidden" value="${idBodega}">
                                            <input id="idSeccion${numeroInputs}" name="idSeccion${numeroInputs}" type="hidden" value="${idSeccion}">
                                            <input id="restaInventario${numeroInputs}" name="restaInventario${numeroInputs}" type="hidden" value="">
                                            <input id="isv${numeroInputs}" name="isv${numeroInputs}" type="hidden" value="${producto.isv}">



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

            function calcularTotales(idPrecio, idCantidad, isvProducto, idUnidad,id ,idRestaInventario) {


                valorInputPrecio = idPrecio.value;
                valorInputCantidad = idCantidad.value;
                valorSelectUnidad = idUnidad.value;

                if (valorInputPrecio && valorInputCantidad) {

                    let subTotal = valorInputPrecio * (valorInputCantidad*valorSelectUnidad);
                    let isv = subTotal * (isvProducto / 100);
                    let total = subTotal + subTotal * (isvProducto / 100);

                    document.getElementById('total' + id).value = total.toFixed(3);
                    document.getElementById('totalMostrar' + id).value = new Intl.NumberFormat('es-HN',{style: 'currency', currency: 'HNL', minimumFractionDigits: 2,}).format(total)

                    document.getElementById('subTotal' + id).value = subTotal.toFixed(3);
                    document.getElementById('subTotalMostrar' + id).value = new Intl.NumberFormat('es-HN',{style: 'currency', currency: 'HNL', minimumFractionDigits: 2,}).format(subTotal)


                    document.getElementById('isvProducto' + id).value = isv.toFixed(3);
                    document.getElementById('isvProductoMostrar' + id).value = new Intl.NumberFormat('es-HN',{style: 'currency', currency: 'HNL', minimumFractionDigits: 2,}).format(isv)


                    idRestaInventario.value = valorInputCantidad*valorSelectUnidad;
                    this.totalesGenerales();



                }


                return 0;


            }

            function totalesGenerales() {

                //console.log(arregloIdInputs);

                if (numeroInputs == 0) {
                    return;
                }



                let totalGeneralValor = new Number(0);
                let totalISV = new Number(0);
                let subTotalGeneralValor = new Number(0);


                for (let i = 0; i < arregloIdInputs.length; i++) {
                    subTotalGeneralValor += new Number(document.getElementById('subTotal' + arregloIdInputs[i]).value);
                    totalISV += new Number(document.getElementById('isvProducto' + arregloIdInputs[i]).value);
                    totalGeneralValor += new Number(document.getElementById('total' + arregloIdInputs[i]).value);

                }

                document.getElementById('subTotalGeneral').value = subTotalGeneralValor.toFixed(3);
                document.getElementById('subTotalGeneralMostrar').value = new Intl.NumberFormat('es-HN',{style: 'currency', currency: 'HNL', minimumFractionDigits: 2,}).format(subTotalGeneralValor)

                document.getElementById('isvGeneral').value = totalISV.toFixed(3);
                document.getElementById('isvGeneralMostrar').value = new Intl.NumberFormat('es-HN',{style: 'currency', currency: 'HNL', minimumFractionDigits: 2,}).format(totalISV)

                document.getElementById('totalGeneral').value = totalGeneralValor.toFixed(3);
                document.getElementById('totalGeneralMostrar').value =  new Intl.NumberFormat('es-HN',{style: 'currency', currency: 'HNL', minimumFractionDigits: 2,}).format(totalGeneralValor)





                return 0;


            }

            function validarFechaPago() {

                let tipoPago;

                tipoPago = document.getElementById('tipoPagoVenta').value;

                if (tipoPago == 2) {

                   // document.getElementById('fecha_vencimiento').value = "empty";
                    document.getElementById('fecha_vencimiento').readOnly = false;
                    this.sumarDiasCredito();

                } else {
                    document.getElementById('fecha_vencimiento').value = "{{ date('Y-m-d') }}";

                    document.getElementById('fecha_vencimiento').readOnly = true;

                }

                return 0;


            }

            function obtenerDatosCliente(){
                let idCliente = document.getElementById("seleccionarCliente").value;
                axios.post("/ventas/datos/cliente",{id:idCliente})
                .then(
                    response =>{

                        let data = response.data.datos;

                        if(data.id==1){
                            document.getElementById("nombre_cliente_ventas").readOnly=false;
                            document.getElementById("nombre_cliente_ventas").value='';

                            document.getElementById("rtn_ventas").readOnly=false;
                            document.getElementById("rtn_ventas").value='';
                            let selectBox = document.getElementById("tipoPagoVenta");
                            selectBox.remove(2);

                        }else{
                            document.getElementById("nombre_cliente_ventas").readOnly=true;
                            document.getElementById("rtn_ventas").readOnly=true;

                            document.getElementById("nombre_cliente_ventas").value=data.nombre;
                            document.getElementById("rtn_ventas").value=data.rtn;
                            obtenerTipoPago();
                            diasCredito = data.dias_credito;
                        }



                    }
                )
                .catch(err=>{

                          console.log(err);
                            Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: "Ha ocurrido un error al obtener los datos del cliente"
                        })


                })

            }


            $(document).on('submit', '#crear_venta',
                function(event) {
                    event.preventDefault();
                    guardarVenta();
                });

            function guardarVenta(){

                document.getElementById("btn_venta_coorporativa").disabled=true;

                var data = new FormData($('#crear_venta').get(0));
                console.log("imprimiento sólo data");
                console.log(data);
                let longitudArreglo = arregloIdInputs.length;
                for (var i = 0; i < longitudArreglo; i++) {


                    let name = "unidad"+arregloIdInputs[i];
                    let nameForm = "idUnidadVenta"+arregloIdInputs[i];

                    let e = document.getElementById(name);
                    let idUnidadVenta = e.options[e.selectedIndex].getAttribute("data-id");

                    data.append(nameForm,idUnidadVenta)
                }
                let text = "["+arregloIdInputs.toString()+"]";
                data.append("arregloIdInputs", text);

                data.append("numeroInputs", numeroInputs);

                // let seleccionarCliente = document.getElementById('seleccionarCliente').value;
                // data.append("seleccionarCliente", seleccionarCliente);
                const formDataObj = {};
                console.log("disque hecha json");
                    data.forEach((value, key) => (formDataObj[key] = value));
                    console.log(formDataObj);


                    const options = {
                        headers: {"content-type": "application/json"}
                        }
                axios.post('/ventas/corporativo/guardar', formDataObj,options )
                    .then(response => {
                        let data = response.data;



                        if(data.idFactura ==0 ){
                           // console.log("entro")

                            Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            html: data.text,
                             })
                             document.getElementById("btn_venta_coorporativa").disabled=false;
                        return;

                        }

                        Swal.fire({
                            confirmButtonText:'Cerrar',
                            confirmButtonColor: '#5A6268',
                            icon: data.icon,
                            title: data.title,
                            html: data.text
                        })


                        document.getElementById('bloqueImagenes').innerHTML = '';
                        document.getElementById('divProductos').innerHTML='';

                        document.getElementById("crear_venta").reset();
                        $('#crear_venta').parsley().reset();

                        var element = document.getElementById('detalleProducto');
                            element.classList.add("d-none");
                            element.href="";

                        document.getElementById("seleccionarCliente").innerHTML='<option value="" selected disabled>--Seleccionar un cliente--</option>';

                        document.getElementById('seleccionarProducto').innerHTML='<option value="" selected disabled>--Seleccione un producto--</option>';
                        document.getElementById('bodega').innerHTML='<option value="" selected disabled>--Seleccione un producto--</option>';
                        document.getElementById("bodega").disabled = true;



                        let element2 = document.getElementById('detalleProducto');
                            element2.classList.add("d-none");


                        arregloIdInputs = [];
                        numeroInputs = 0;
                        retencionEstado=false;

                        document.getElementById('numero_venta').value=data.numeroVenta;
                        document.getElementById("btn_venta_coorporativa").disabled=false;

                    })
                    .catch(err => {
                        document.getElementById("btn_venta_coorporativa").disabled=false;
                        let data = err.response.data;
                        console.log(err);
                        Swal.fire({
                            icon: data.icon,
                            title: data.title,
                            text: data.text
                        })
                    })
            }

            function sumarDiasCredito(){
                tipoPago = document.getElementById('tipoPagoVenta').value;

                if(tipoPago==2){

                    let fechaEmision = document.getElementById("fecha_emision").value;
                    let date = new Date(fechaEmision);
                   date.setDate(date.getDate() + diasCredito);
                   let suma=date.toISOString().split('T')[0];
                   //console.log( diasCredito);

                    document.getElementById("fecha_vencimiento").value= suma;

                }
            }


        </script>
    @endpush
</div>
