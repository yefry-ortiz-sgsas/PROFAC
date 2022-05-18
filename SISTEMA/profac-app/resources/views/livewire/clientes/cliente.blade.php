<div>
    @push('styles')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
        rel="stylesheet">
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Clientes</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Lista</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Edicion</a>
                </li>

            </ol>
        </div>

        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem">
                <a href="#" class="btn add-btn btn-success" data-toggle="modal" data-target="#modal_clientes_crear"><i
                        class="fa fa-plus"></i> Registrar Cliente</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="tbl_ClientesLista" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Dirreción</th>
                                        <th>Contacto</th>
                                        <th>Correo</th>
                                        <th>RTN</th>                                       
                                        <th>Estado</th>
                                        <th>Acciones</th>
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


        <!---MODAL PARA CREAR CLIENTES----->
        <div id="modal_clientes_crear" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success">Regitro de Clientes</h5>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="clientesCreacionForm" name="clientesCreacionForm" data-parsley-validate>
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="row" id="row_datos">
     
                                <div class="col-md-12">
                                    <label class="col-form-label focus-label">Nombre del cliente</label>
                                    <input class="form-control" required type="text" id="nombre_cliente" name="nombre_cliente"
                                        data-parsley-required>
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label focus-label">Dirección</label>
                                    <textarea name="direccion_cliente" placeholder="Escriba aquí..." required id="direccion_cliente" cols="30" rows="3"
                                        class="form-group form-control" data-parsley-required></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">RTN</label>
                                    <input class="form-group form-control" required type="text" name="rtn_cliente"
                                        id="rtn_cliente" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Correo electrónico</label>
                                    <input class="form-group form-control" type="text" name="correo_cliente" id="correo_cliente"
                                        data-parsley-required>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Teléfono del cliente</label>
                                    <input class="form-group form-control" type="text" name="correo_cliente" id="correo_cliente"
                                        data-parsley-required>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label focus-label">Contácto 1</label>
                                    <input class="form-control" required type="text" id="contacto[]"
                                        name="contacto[]" data-parsley-required>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label focus-label">Teléfono 1</label>
                                    <input class="form-group form-control" required type="text" name="telefono[]"led 900900
                                        id="telefono[]" data-parsley-required>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label focus-label">Contácto 2</label>
                                    <input class="form-control" required type="text" id="contacto[]"
                                        name="contacto[]" data-parsley-required>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label focus-label">Teléfono 2</label>
                                    <input class="form-group form-control" required type="text" name="telefono[]"
                                        id="telefono[]" data-parsley-required>
                                </div>
 

                                <div class="col-md-6">
                                    <label class="col-form-label focus-label">Longitud</label>
                                    <input class="form-group form-control"  type="text" name="longitud_cliente"
                                        id="longitud_cliente" >
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label focus-label">Latitud</label>
                                    <input class="form-group form-control"  type="text" name="latitud_cliente"
                                        id="latitud_clientee" >
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Pais</label>
                                    <select class="form-group form-control" name="pais_cliente" id="pais_cliente"
                                    onchange="obtenerDepartamentos()">
                                        <option selected disabled>---Seleccione un pais---</option>

                                    </select>
                                </div>
                              


                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Departamento</label>
                                    <select class="form-group form-control" name="departamento_cliente" id="departamento_cliente"
                                        onchange="obtenerMunicipios()">
                                        <option selected disabled>---Seleccione un departamento---</option>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Municipio</label>
                                    <select class="form-group form-control" name="municipio_cliente" id="municipio_cliente"
                                        data-parsley-required >
                                        <option selected disabled>---Seleccione un municipio---</option>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Tipo de Personalidad </label>
                                    <select class="form-group form-control" name="tipo_personalidad" id="tipo_personalidad"
                                        data-parsley-required>
                                        <option disabled selected>---Seleccione una opción---</option>
                                       {{--  @foreach ($tipoPersonalidad as $user)
                                            <option value="{{ $user->id }}">{{ $user->nombre }}</option>
                                        @endforeach --}}

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Tipo de cliente</label>
                                    <select class="form-group form-control" name="categoria_cliente" id="categoria_cliente"
                                        data-parsley-required>
                                        <option selected disabled>---Seleccione una opción---</option>
                                        {{-- @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Vendedor</label>
                                    <select class="form-group form-control" name="vendedor_cliente" id="vendedor_cliente"
                                        data-parsley-required>
                                        <option selected disabled>---Seleccione una opción---</option>
                                        {{-- @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="foto_cliente" class="col-form-label focus-label">Fotografía: </label>
                                    <input class="" type="file" id="foto_cliente" name="foto_cliente" accept="image/png, image/gif, image/jpeg, image/jpg" multiple>

                                </div>
                                <div class=" col-md-7">
                                    <img id="imagenPrevisualizacion" class="ancho-imagen">

                                </div>
                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary float-left mt-4"
                            form="clientesCreacionForm"><strong>Crear
                               Cliente</strong></button>
                    </div>

                </div>
            </div>
        </div>

@push('scripts')
<script>

$(document).ready(function() {
    obtenerpaiss();
    tipoPersonalidad();
    tipoCliente();
    vendedor();
})

        function obtenerpaiss() {
                  
            axios.get('/cliente/pais')
                .then(function(response) {

                    let array = response.data.listaPais;
                    let html = "<option selected disabled>---Seleccione un pais---</option>";

                    array.forEach(pais => {

                        html +=
                            `
                    <option value="${ pais.id }">${pais.nombre}</option>   
                   `
                    });

                    document.getElementById("pais_cliente").innerHTML = html;


                })
                .catch(function(error) {
                    // handle error
                    console.log(error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: "Ha ocurrido un error al obtener la lista de paises"
                    })
                })



        }

        function obtenerDepartamentos(){
           
            let id = document.getElementById('pais_cliente').value;
           // console.log(id)

            axios.post('/cliente/departamento',{id:id})
            .then(function(response) {

                let array = response.data.listaDeptos;
                let html = "<option selected disabled>---Seleccione un departamento---</option>";

                array.forEach(departamento => {

                    html +=
                        `
                <option value="${ departamento.id }">${departamento.nombre}</option>   
                `
                });

                document.getElementById("departamento_cliente").innerHTML = html;


                })
                .catch(function(error) {
                // handle error
                console.log(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: "Ha ocurrido un error al obtener los departamentos"
                })
                })


        }

        function obtenerMunicipios(){
            let id = document.getElementById('departamento_cliente').value;

            axios.post('/cliente/municipio', {id:id})
            .then(function(response) {
            let array = response.data.listaMunicipios;
            let html = "<option selected disabled>---Seleccione un municipio---</option>";

            array.forEach(municipio => {

                html +=
                    `
            <option value="${ municipio.id }">${municipio.nombre}</option>   
            `
            });

            document.getElementById("municipio_cliente").innerHTML = html;


            })
            .catch(function(error) {
            // handle error
            console.log(error);

            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: "Ha ocurrido un error al obtener los municipios"
            })
            })

        }

        function tipoPersonalidad(){
           

            axios.get('/cliente/tipo/personalidad')
            .then(function(response) {
            let array = response.data.tipoPersonalidad;
            let html = "<option selected disabled>---Seleccione una opción---</option>";

            array.forEach(tipo => {

                html +=
                    `
            <option value="${ tipo.id }">${tipo.nombre}</option>   
            `
            });

            document.getElementById("tipo_personalidad").innerHTML = html;


            })
            .catch(function(error) {
            // handle error
            console.log(error);

            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: "Ha ocurrido un error al obtener el tipo de personalidad"
            })
            })

        }

        //

        function tipoCliente(){
           

           axios.get('/cliente/tipo/cliente')
           .then(function(response) {
           let array = response.data.tipoCliente;
           let html = "<option selected disabled>---Seleccione una opción---</option>";

           array.forEach(tipo => {

               html +=
                   `
           <option value="${ tipo.id }">${tipo.descripcion}</option>   
           `
           });

           document.getElementById("categoria_cliente").innerHTML = html;


           })
           .catch(function(error) {
           // handle error
           console.log(error);

           Swal.fire({
               icon: 'error',
               title: 'Error...',
               text: "Ha ocurrido un error al obtener el tipo de cliente"
           })
           })

       }

       function vendedor(){
           

           axios.get('/cliente/lista/vendedores')
           .then(function(response) {
           let array = response.data.vendedor;
           let html = "<option selected disabled>---Seleccione una opción---</option>";

           array.forEach(vendedor => {

               html +=
                   `
           <option value="${ vendedor.id }">${vendedor.name}</option>   
           `
           });

           document.getElementById("vendedor_cliente").innerHTML = html;


           })
           .catch(function(error) {
           // handle error
           console.log(error);

           Swal.fire({
               icon: 'error',
               title: 'Error...',
               text: "Ha ocurrido un error al obtener el vendedor"
           })
           })

       }
        

</script>
@endpush

</div>
