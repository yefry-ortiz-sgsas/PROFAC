<div>
    @push("styles")
    <style>

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
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <label for="seleccionarProveedor" class="col-form-label focus-label">Seleccionar
                                        Proveedor:</label>
                                    <select id="seleccionarProveedor" class="form-group form-control" style="">
                                        <option value="" selected disabled>--Seleccionar un proveedor--</option>
                                    </select>

                                    


                                </div>

                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <label for="isv_producto" class="col-form-label focus-label">Seleccionar tipo de
                                        pago:</label>
                                    <select class="form-group form-control " name="tipoPago" id="tipoPago"   data-parsley-required>
                                    </select>

                                </div>


                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">

                                        <label for="nombre_producto" class="col-form-label focus-label">Nombre del
                                            producto:</label>
                                        <input class="form-control" type="date" id="nombre_producto"
                                            name="nombre_producto" value="{{ date('Y-m-d') }}" data-parsley-required>

                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4		
                                ">

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <select id="seleccionarProdcuto" class="form-group form-control" style="">
                                                <option value="" selected disabled>--Seleccione un producto--</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-4">
                                            <button class="btn-rounded btn btn-success">Añadir producto a compra <i class="fa-solid fa-circle-plus"></i></button>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">

                                    {{-- <div id="carouselExampleBigIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                
                                            @for ($i = 0; $i < count($imagenes); $i++)
                                              @if($i == 0)      
                                                <li data-target="#carouselExampleBigIndicators" data-slide-to="{{ $i }}" class="active"></li>                        
                                                  
                                              @else
                                                <li data-target="#carouselExampleBigIndicators" data-slide-to="{{ $i }}" class=""></li>
                                                  
                                              @endif
                
                                            @endfor
                
                                        </ol>
                                        <div class="carousel-inner " style="margin-left: 12rem">
                
                
                                            @foreach ($imagenes as $imagen)
                
                                                @if ($imagen->contador == 1)
                
                                                    <div class="carousel-item active " >
                                                        <img class="d-block  " src="{{ asset('catalogo/'.$imagen->url_img) }}" alt="imagen {{$imagen->contador}}" style="width: 45rem; height: 27rem; " >
                                                    </div>
                
                                                @else
                
                                                    <div class="carousel-item ">
                                                        <img class="d-block " src="{{ asset('catalogo/'.$imagen->url_img) }}" alt="imagen {{$imagen->contador}} " style="width: 45rem; height: 27rem; " >
                                                    </div>
                
                                                @endif
                
                
                                            @endforeach
                
                
                                        </div>
                                        <a class="carousel-control-prev"  href="#carouselExampleBigIndicators" role="button"
                                            data-slide="prev" >
                                            <span class="" aria-hidden="true"  ><i class="fa-solid fa-angle-left " style="font-size: 5rem; color:#9C321A" ></i></span>
                                            <span class="sr-only" >Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleBigIndicators" role="button"
                                            data-slide="next">
                                            <span class="" aria-hidden="true"><i class="fa-solid fa-angle-right " style="font-size: 5rem; color:#9C321A"></i></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div> --}}

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
            this.obtenerTipoPago();
            function obtenerTipoPago(){
                

                axios.get('/producto/tipo/pagos')
                    .then( response => {

                        let tipoDePago = response.data;

                        let htmlPagos ='';

                        tipoDePago.forEach(element => {

                            htmlPagos += `
                            <option value="${element.id}" >${element.descripcion}</option>                                      
                            `                            
                        }
                        );

                        document.getelementbyid('tipoPago').innerhtml = htmlPagos;
                        return;
                    })
                    .catch( err => {
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


        </script>
    @endpush
</div>
