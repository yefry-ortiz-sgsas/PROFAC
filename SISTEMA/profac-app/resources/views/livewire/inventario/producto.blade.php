<div>
    @push("style")
    <style>
        @media (max-width: 600px) {
            .ancho-imagen {
                max-width: 200px;
            }
            }

         @media (min-width: 601px ) and (max-width:900px){
            .ancho-imagen {
                max-width: 600px;
            }
            }  
        
            @media (min-width: 901px) {
            .ancho-imagen {
                max-width: 800px;
            }
            }  
    </style>


    @endpush
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Productos</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Listar</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Registrar</a>
                </li>

            </ol>
        </div>

       
            <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
                <div style="margin-top: 1.5rem">
                    <a href="#" class="btn add-btn btn-primary" data-toggle="modal" data-target="#modal_producto_crear"><i
                            class="fa fa-plus"></i> Registrar Producto</a>
                </div>
            </div>

      
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_productosListar" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Cod</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>ISV</th>
                                        <th>Cateogria</th>
                                        <th>Unidad de Medida</th>
                                        <th>Existencia</th>
                                        <th>Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>


                    </div>
                </div>
            </div>

            <!-- Modal para editar Bodega-->
            <div class="modal fade" id="modal_producto_crear" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Registro de Productos</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    
                            <div class="modal-body">
                                <form id="crearProductoForm" name="crearProductoForm" data-parsley-validate>
                                    {{-- <input type="hidden" name="_token" value="{!! csrf_token() !!}"> --}}
                                    <div class="row" id="row_datos">
                                        <div class="col-md-12">
                                            <label for="nombre_producto" class="col-form-label focus-label">Nombre del producto:</label>
                                            <input class="form-control" required type="text" id="nombre_producto" name="nombre_producto"
                                                data-parsley-required>
                                        </div>
      
                                        <div class="col-md-12">
                                            <label for="descripcion_producto" class="col-form-label focus-label">Descripción  del producto</label>
                                            <textarea  placeholder="Escriba aquí..." required id="descripcion_producto" name ="descripcion_producto" cols="30" rows="3"
                                                class="form-group form-control" data-parsley-required></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="isv_producto" class="col-form-label focus-label">ISV en %:</label>
                                            <select class="form-group form-control" name="isv_producto" id="isv_producto" data-parsley-required>
                                              
                                                <option value="0">Excento de impuestos</option>
                                                <option value="15" selected>15% de ISV</option>
                                                <option value="18">18% de ISV</option>
                                                
                                                        
            
                                            </select>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cod_barra_producto" class="col-form-label focus-label">Codigo de barra:</label>
                                            <input class="form-group form-control"  type="number" name="cod_barra_producto"
                                                id="cod_barra_producto"  min="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cod_estatal_producto" class="col-form-label focus-label">Codigo Estatal:</label>
                                            <input class="form-group form-control" type="number" name="cod_estatal_producto"
                                                id="cod_estatal_producto" min="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="precio1" class="col-form-label focus-label">Precio de venta 1:</label>
                                            <input class="form-group form-control" min="1" type="number" name="precio[]" id="precio1"
                                                data-parsley-required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-form-label focus-label" for="precio2">Precio de venta 2:</label>
                                            <input class="form-group form-control" min="1" type="number" name="precio[]"
                                                id="precio2">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="precio3" class="col-form-label focus-label">Precio de venta 3:</label>
                                            <input class="form-group form-control" required min="1" type="number" name="precio[]"
                                                id="precio3" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="categoria_producto" class="col-form-label focus-label">Categoria de producto</label>
                                            <select class="form-group form-control" name="categoria_producto" id="categoria_producto"
                                                onchange="obtenerDepartamentos()" data-parsley-required>
                                                <option selected disabled>---Seleccione una categoria---</option>
                                                @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->descripcion }}</option>
                                                @endforeach
           
            
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="unidad_producto" class="col-form-label focus-label">Selecciones una unidad de medida</label>
                                            <select class="form-group form-control" name="unidad_producto" id="unidad_producto"
                                                onchange="obtenerMunicipios()" data-parsley-required>
                                                <option selected disabled>---Seleccione una unidad---</option>
                                                @foreach ($unidades as $unidad)
                                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}-{{ $unidad->simbolo }}</option>
                                                @endforeach
            
                                            </select>
                                        </div>
      
                                        
            
                                        <div class="col-md-5">
                                            <label for="foto_producto" class="col-form-label focus-label">Fotografía: </label>                                         
                                            <input  class="" type="file" id="foto_producto" name="foto_producto" accept="image/png, image/gif, image/jpeg">
                                            
                                        </div>
                                        <div class=" col-md-7">
                                            <img id="imagenPrevisualizacion" class="ancho-imagen">

                                        </div>
                                    </div>
                                </form>

                            </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" form="crearProductoForm" class="btn btn-primary" >Guardar producto</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        {{-- Care about people's approval and you will be their prisoner. --}}




    </div>
    @push('scripts')
            
        <script>

        const $foto_producto = document.querySelector("#foto_producto"),
        $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

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

        $(document).on('submit', '#crearProductoForm', function(event) {

            event.preventDefault();
            guardarProducto();

        });

        function guardarProducto(){

            var data = new FormData($('#crearProductoForm').get(0));

            axios.post("/producto/registrar", data)
            .then( response => {

                console.log(response.data);

            })
            .catch( err =>{
                console.error(err);

            })

        }

        $(document).ready(function() {
            $('#tbl_productosListar').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                "ajax": "/producto/listar/productos",
                "columns": [{
                        data: 'codigo'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'descripcion'
                    },
                    {
                        data: 'ISV'
                    },
                    {
                        data: 'categoria'
                    },
                    {
                        data: 'unidad_medida'
                    },
                    {
                        data: 'existencia'
                    },
                    {
                        data: 'disponibilidad'
                    }
  
                ]


            });
        })
    
        </script>
    
    @endpush
</div>
