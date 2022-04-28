<div>
    @push('styles')
    <style>
        .img-width {
            width: 20rem;
            height: 8rem;
            margin: 0 auto;

        }

        @media (min-width: 350px) and (max-width: 768px) {

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

        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem" mr-auto>
                <a href="#" class="btn add-btn btn-warning" data-toggle="modal" data-target="#modal_producto_editar"><i class="fa fa-plus"></i>Editar Producto</a>
            </div>
        </div>

        <div style="margin-top: 1.5rem; margin-left:auto; ">
            <a href="#" class="btn add-btn btn-info" data-toggle="modal" data-target="#modal_foto_producto"><i class="fa fa-plus"></i>Subir Fotografía</a>
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

                        @for ($i = 0; $i < count($imagenes); $i++) @if ($i==0) <li data-target="#carouselExampleBigIndicators" data-slide-to="{{ $i }}" class="active">
                            </li>
                            @else
                            <li data-target="#carouselExampleBigIndicators" data-slide-to="{{ $i }}" class=""></li>
                            @endif
                            @endfor

                    </ol>
                    <div class="carousel-inner ">
                        @php
                        $comillas = '"';
                        @endphp

                        @foreach ($imagenes as $imagen)
                        @if ($imagen->contador == 1)
                        <div class="carousel-item active row w-100 align-items-center">
                            <div class="col text-center">
                                <button class="btn btn-danger regular-button " onclick="eliminar({{ $comillas.$imagen->url_img.$comillas }})" type="button">Eliminar imagen</button>
                            </div><br>
                            <img class="d-block img-width" src="{{ asset('catalogo/' . $imagen->url_img) }}" alt="imagen {{ $imagen->contador }}">
                        </div>
                        @else
                        <div class="carousel-item row w-100 align-items-center">
                            <div class="col text-center">
                                <button class="btn btn-danger regular-button " onclick="eliminar({{ $comillas.$imagen->url_img.$comillas }})" type="button">Eliminar imagen</button>
                            </div>
                            <br>
                            <img class="d-block img-width" src="{{ asset('catalogo/' . $imagen->url_img) }}" alt="imagen {{ $imagen->contador }} ">
                        </div>
                        @endif
                        @endforeach


                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleBigIndicators" role="button" data-slide="prev">
                        <span class="" aria-hidden="true"><i class="fa-solid fa-angle-left " style="font-size: 5rem; color:#9C321A"></i></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleBigIndicators" role="button" data-slide="next">
                        <span class="" aria-hidden="true"><i class="fa-solid fa-angle-right " style="font-size: 5rem; color:#9C321A"></i></span>
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
                <div class="ibox-content" style="height: 18.5rem;  display: flex; flex-direction: column; justify-content: space-between;">
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
                <div class="ibox-content " style="height: 18.5rem; display: flex; flex-direction: column; justify-content: space-between;  ">

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


<div class="modal fade" id="modal_producto_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Editar inromación del producto</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="editarProductoForm" name="editarProductoForm" data-parsley-validate>
                    {{-- <input type="hidden" name="_token" value="{!! csrf_token() !!}"> --}}
                    <div class="row" id="row_datos">
                        <div class="col-md-12">
                            <input type="hidden" id="id_producto_edit" name="id_producto_edit" value="{{ $producto->id }}">
                            <label for="nombre_producto_edit" class="col-form-label focus-label">Nombre del producto:</label>
                            <input class="form-control" required type="text" id="nombre_producto_edit" name="nombre_producto_edit" data-parsley-required>
                        </div>

                        <div class="col-md-12">
                            <label for="descripcion_producto" class="col-form-label focus-label">Descripción del producto</label>
                            <textarea placeholder="Escriba aquí..." required id="descripcion_producto_edit" name="descripcion_producto_edit" cols="30" rows="3" class="form-group form-control" data-parsley-required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="isv_producto" class="col-form-label focus-label">ISV en %:</label>
                            <select class="form-group form-control" name="isv_producto_edit" id="isv_producto_edit" data-parsley-required>

                                <option value="0">Excento de impuestos</option>
                                <option value="15" selected>15% de ISV</option>
                                <option value="18">18% de ISV</option>



                            </select>

                        </div>
                        <div class="col-md-4">
                            <label for="cod_barra_producto" class="col-form-label focus-label">Codigo de barra:</label>
                            <input class="form-group form-control" type="number" name="cod_barra_producto_edit" id="cod_barra_producto_edit" min="0">
                        </div>
                        <div class="col-md-4">
                            <label for="cod_estatal_producto" class="col-form-label focus-label">Codigo Estatal:</label>
                            <input class="form-group form-control" type="number" name="cod_estatal_producto_edit" id="cod_estatal_producto_edit" min="0">
                        </div>
                        <div class="col-md-4">
                            <label for="precio1" class="col-form-label focus-label">Precio de venta base:</label>
                            <input class="form-group form-control" min="1" type="number" name="precioBase_edit" id="precioBase_edit" data-parsley-required>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label focus-label" for="precio2">Precio de venta 2:</label>
                            <input class="form-group form-control" min="1" type="number" name="precio_edit[]" id="precio2_edit">
                        </div>
                        <div class="col-md-4">
                            <label for="precio3" class="col-form-label focus-label">Precio de venta 3:</label>
                            <input class="form-group form-control" required min="1" type="number" name="precio_edit[]" id="precio3_edit">
                        </div>

                        <div class="col-md-6">
                            <label for="categoria_producto" class="col-form-label focus-label">Categoria de producto</label>
                            <select class="form-group form-control" name="categoria_producto_edit" id="categoria_producto_edit" data-parsley-required>
                                <option selected disabled>---Seleccione una categoria---</option>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->descripcion }}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="unidad_producto" class="col-form-label focus-label">Selecciones una unidad de medida</label>
                            <select class="form-group form-control" name="unidad_producto_edit" id="unidad_producto_edit" data-parsley-required>
                                <option selected disabled>---Seleccione una unidad---</option>
                                @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}-{{ $unidad->simbolo }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" form="editarProductoForm" class="btn btn-primary">Guardar producto</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="modalSpinnerLoading" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalSpinnerLoadingTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <h2 class="text-center">Espere un momento...</h2>
                <div class="loader">Loading...</div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_foto_producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Registro de Productos</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="foto_productoForm" name="foto_productoForm" data-parsley-validate>

                    <div class="row">
                        <div class="col-md-5">
                            <label for="foto_producto_edit" class="col-form-label focus-label">Fotografía: </label>
                            <input type="hidden" id="id_producto_edit_foto" name="id_producto_edit_foto" value="{{ $producto->id }}">
                            <input class="" type="file" id="foto_producto_edit" name="foto_producto_edit" accept="image/png, image/gif, image/jpeg" multiple>

                        </div>
                        <div class=" col-md-7">
                            <img id="imagenPrevisualizacion" class="ancho-imagen">

                        </div>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" form="foto_productoForm" class="btn btn-primary">Guardar Imgaen</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const $foto_producto = document.querySelector("#foto_producto_edit")
        , $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

    // Escuchar cuando cambie
    $foto_producto.addEventListener("change", () => {
        // Los archivos seleccionados, pueden ser muchos o uno
        const archivos = $foto_producto.files;
        // Si no hay archivos salimos de la función y quitamos la imagen
        if (!archivos || !archivos.length) {
            $imagenPrevisualizacion.src = "";
            return;
        }
        // Ahora tomamos el primer archivo, el cual vamos a previsualizar
        const primerArchivo = archivos[0];
        // Lo convertimos a un objeto de tipo objectURL
        const objectURL = URL.createObjectURL(primerArchivo);
        // Y a la fuente de la imagen le ponemos el objectURL
        $imagenPrevisualizacion.src = objectURL;
    });

    $(document).on('submit', '#foto_productoForm', function(event) {

        event.preventDefault();
        guardarFoto();

    });

    function guardarFoto() {
        $('#modal_foto_producto').modal('hide');
        $('#modalSpinnerLoading').modal('show');

        let data = new FormData($('#foto_productoForm').get(0));

        let totalfiles = document.getElementById('foto_producto_edit').files.length;
        for (var i = 0; i < totalfiles; i++) {
            data.append("files[]", document.getElementById('foto_producto_edit').files[i]);
        };

        console.log(data);
        axios.post('/ruta/imagen/edit', {"id":1})
            .then(response => {


                $('#modalSpinnerLoading').modal('hide');


                $('#foto_productoForm').parsley().reset();
                img = document.getElementById('imagenPrevisualizacion');
                img.src = "";
                document.getElementById("foto_productoForm").reset();
                $('#modal_foto_producto').modal('hide');


                Swal.fire({
                    icon: 'success'
                    , title: 'Exito!'
                    , text: "Imagen guardada con exito."
                });

                location.reload();

            })
            .catch(err => {
                console.error(err);

            })
    }

    $(document).ready(function() {

        var idProducto_edit = document.getElementById('id_producto_edit').value;
        obtenerDatosProductoEditar(idProducto_edit);

        $('#tbl_lotes_listar').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            }
            , pageLength: 10
            , responsive: true
            , dom: '<"html5buttons"B>lTfgitp'
            , buttons: [


            ],



        });
    });


    function obtenerDatosProductoEditar(id) {
        var idProducto = document.getElementById('id_producto_edit').value;
        axios.get("/producto/datos/" + idProducto)
            .then(response => {
                let datos = response.data;


                document.getElementById("nombre_producto_edit").value = datos.datosProducto.nombre;
                document.getElementById("descripcion_producto_edit").value = datos.datosProducto.descripcion;
                document.getElementById("isv_producto_edit").value = datos.datosProducto.isv;
                document.getElementById("isv_producto_edit").innerHTML += '<option selected value="' + datos.datosProducto.isv + '">' + datos.datosProducto.isv + ' % de ISV</option>';
                document.getElementById("cod_barra_producto_edit").value = datos.datosProducto.codigo_barra;
                document.getElementById("cod_estatal_producto_edit").value = datos.datosProducto.codigo_estatal;
                document.getElementById("precioBase_edit").value = datos.datosProducto.precio_base;
                document.getElementById("precio2_edit").value = datos.preciosProducto[1].precio;
                document.getElementById("precio3_edit").value = datos.preciosProducto[2].precio;

                $('#exampleModal').modal('show');

            });


    }

    $(document).on('submit', '#editarProductoForm', function(event) {

        event.preventDefault();
        editarProducto();

    });

    function editarProducto() {
        $('#modalSpinnerLoading').modal('show');

        var data = new FormData($('#editarProductoForm').get(0));

        axios.post("/producto/editar", data)
            .then(response => {
                $('#modalSpinnerLoading').modal('hide');


                $('#editarProductoForm').parsley().reset();
                document.getElementById("editarProductoForm").reset();
                $('#modal_producto_editar').modal('hide');

                Swal.fire({
                    icon: 'success'
                    , title: 'Exito!'
                    , text: "Producto Editado con exito."
                })

                location.reload();

            })
            .catch(err => {
                console.error(err);

            })

    }

    function eliminar(urlImagen) {
        //console.log("Esto es una URL --->     "+urlImagen)
        axios.post("/producto/eliminar", {
                "urlImagen": urlImagen
            })
            .then(response => {

                Swal.fire({
                    icon: 'success'
                    , title: 'Exito!'
                    , text: "Imagen eliminada con exito."
                })
                location.reload();

            })
            .catch(err => {
                console.error(err);

            });

    }

</script>
@endpush


</div>
