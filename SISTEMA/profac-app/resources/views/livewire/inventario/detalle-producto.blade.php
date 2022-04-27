<div>
    @push('styles')
        <style>

            .img-width {
                    width: 20rem; 
                    height: 8rem;
                    margin: 0 auto;
                    
                }

                @media  (min-width: 350px) and (max-width: 768px) {

                    .img-width {
                    width: 20rem; 
                    height: 10rem;
                    margin: 0 auto;
                    
                }
                    
                }

                @media (min-width: 769px) {
                .img-width {
                    width: 45rem; 
                    height: 27rem;
                    margin: 0 auto;
                    
                }
            }



        </style>
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2> <strong> Producto </strong></h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Informacion Detallada</a>
                </li>
                <li class="breadcrumb-item">
                    <a> {{ $producto->nombre }}</a>
                </li>


            </ol>
        </div>

    </div>



</div>

<div class="row mt-6 wrapper white-bg animated fadeInRight  ">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3>Fotografías</h3>

            </div>
            <div class="ibox-content">

                <div id="carouselExampleBigIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">

                        @for ($i = 0; $i < count($imagenes); $i++)
                            @if ($i == 0)
                                <li data-target="#carouselExampleBigIndicators" data-slide-to="{{ $i }}"
                                    class="active"></li>
                            @else
                                <li data-target="#carouselExampleBigIndicators" data-slide-to="{{ $i }}"
                                    class=""></li>
                            @endif
                        @endfor

                    </ol>
                    <div class="carousel-inner ">


                        @foreach ($imagenes as $imagen)
                            @if ($imagen->contador == 1)
                                <div class="carousel-item active ">
                                    <img class="d-block img-width" src="{{ asset('catalogo/' . $imagen->url_img) }}"
                                        alt="imagen {{ $imagen->contador }}"
                                       >
                                </div>
                            @else
                                <div class="carousel-item ">
                                    <img class="d-block img-width" src="{{ asset('catalogo/' . $imagen->url_img) }}"
                                        alt="imagen {{ $imagen->contador }} "
                                       >
                                </div>
                            @endif
                        @endforeach


                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleBigIndicators" role="button"
                        data-slide="prev">
                        <span class="" aria-hidden="true"><i class="fa-solid fa-angle-left "
                                style="font-size: 5rem; color:#9C321A"></i></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleBigIndicators" role="button"
                        data-slide="next">
                        <span class="" aria-hidden="true"><i class="fa-solid fa-angle-right "
                                style="font-size: 5rem; color:#9C321A"></i></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row mt-2">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="wrapper wrapper-content animated fadeInRight">


            <div class="ibox mb-0">
                <div class="ibox-title">
                    <h3>Informacion General <i class="fa-solid fa-pen-to-square"></i></h3>
                </div>
                <div class="ibox-content"
                    style="height: 18.5rem;  display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Código interno:
                            </strong> {{ $producto->id }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Nombre de producto:
                            </strong> {{ $producto->nombre }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Descripción
                                :</strong> {{ $producto->descripcion }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Codigo
                                Estatal:</strong> {{ $producto->codigo_estatal }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Codigo de
                                Barra:</strong> {{ $producto->codigo_barra }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Categoría :</strong>
                            {{ $producto->categoria }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Unidad de
                                medida:</strong> {{ $producto->unidad_medida }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Fecha de
                                registro:</strong> {{ $producto->fecha_registro }}</small></p>
                        <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Registrado
                                por:</strong> {{ $producto->registrado_por }}</small></p>
                    </div>

                </div>
            </div>


        </div>
    </div>


    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="wrapper wrapper-content animated fadeInRight">


            <div class="ibox mb-0">
                <div class="ibox-title">
                    <h3>Precios e Impuestos <i class="fa-solid fa-sack-dollar"></i></h3>

                </div>
                <div class="ibox-content "
                    style="height: 18.5rem; display: flex; flex-direction: column; justify-content: space-between;  ">

                    <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Impuesto sobre la
                            venta </strong> {{ $producto->isv }}%</small></p>
                    <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Precio base de venta:
                        </strong> {{ $producto->precio_base }} Lps.</small></p>
                    @foreach ($precios as $precio)
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Precio
                                {{ $precio->contador }} de venta :</strong> {{ $precio->precio }} Lps</small></p>
                    @endforeach




                </div>
            </div>


        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight pt-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Disponibilidad de producto <i class="fa-solid fa-boxes-packing"></i> </h3>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table id="tbl_lotes_listar" class="table table-striped table-bordered table-hover">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Nombre de producto</th>
                                    <th>Departamento</th>
                                    <th>Municipio</th>
                                    <th>Bodega</th>
                                    <th>Dirección</th>
                                    <th>Seccion</th>
                                    <th>Numero</th>
                                    <th>Cantidad Disponible</th>
                                </tr>
                            </thead>   
                            <tbody>
                                @foreach ($lotes as $lote)
                                <tr>
                                    <td>{{ $lote->contador }}</td>
                                    <td>{{ $lote->id }}</td>
                                    <td>{{ $lote->nombre }}</td>
                                    <td>{{ $lote->departamento }}</td>
                                    <td>{{ $lote->municipio }}</td>
                                    <td>{{ $lote->bodega }}</td>
                                    <td>{{ $lote->direccion }}</td>
                                    <td>{{ $lote->seccion }}</td>
                                    <td>{{ $lote->numeracion }}</td>
                                    <td>{{ $lote->cantidad_disponible }}</td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tbl_lotes_listar').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [


                ],



            });
        })
    </script>
@endpush


</div>
