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
                                        <th>Retencion 1%</th>
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
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Código:</label>
                                    <input class="form-control" required type="text" id="codigo_cliente" name="codigo_cliente"
                                        data-parsley-required>
                                </div>
                                <div class="col-md-8">
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
                                    <label class="col-form-label focus-label">Longitud</label>
                                    <input class="form-group form-control" required type="text" name="longitud_cliente"
                                        id="longitud_cliente" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Latitud</label>
                                    <input class="form-group form-control" required type="text" name="latitud_cliente"
                                        id="latitud_clientee" data-parsley-required>
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
                                    <label class="col-form-label focus-label">Contácto</label>
                                    <input class="form-control" required type="text" id="contacto_cliente"
                                        name="contacto_cliente" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Teléfono</label>
                                    <input class="form-group form-control" required type="text" name="telefono_cliente"
                                        id="telefono_cliente" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Teléfono 2</label>
                                    <input class="form-group form-control" type="text" name="telefono_cliente_2"
                                        id="telefono_cliente_2">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">País</label>
                                    <select class="form-group form-control" name="pais_cliente" id="pais_cliente"
                                        onchange="obtenerDepartamentos()">
                                        <option selected disabled>---Seleccione un país---</option>
                                        {{-- @foreach ($paises as $pais)
                                            <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                                        @endforeach --}}

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Departamento</label>
                                    <select class="form-group form-control" name="depto_cliente" id="depto_cliente"
                                        onchange="obtenerMunicipios()">
                                        <option selected disabled>---Seleccione un Departamento---</option>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Municipio</label>
                                    <select class="form-group form-control" name="municipio_cliente" id="municipio_cliente"
                                        data-parsley-required>
                                        <option selected disabled>---Seleccione un municipio---</option>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Tipo de Personalidad </label>
                                    <select class="form-group form-control" name="giro_neg_cliente" id="giro_neg_cliente"
                                        data-parsley-required>
                                        <option disabled selected>---Seleccione una opción---</option>
                                       {{--  @foreach ($tipoPersonalidad as $user)
                                            <option value="{{ $user->id }}">{{ $user->nombre }}</option>
                                        @endforeach --}}

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Categoría</label>
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
                                    <input class="" type="file" id="foto_cliente" name="foto_cliente" accept="image/png, image/gif, image/jpeg" multiple>

                                </div>
                                <div class=" col-md-7">
                                    <img id="imagenPrevisualizacion" class="ancho-imagen">

                                </div>
                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary float-left m-t-n-xs"
                            form="clientesCreacionForm"><strong>Crear
                               Cliente</strong></button>
                    </div>

                </div>
            </div>
        </div>



</div>
