<div>
        <!---MODAL PARA CREAR MARCA----->
        <div id="modal_marcas_crear" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success">Regitro de Marcass</h5>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="proveedorCreacionForm" name="proveedorCreacionForm" data-parsley-validate>
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="row" id="row_datos">
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Nombre:</label>
                                    <input class="form-control" required type="text" id="nombre_marca" name="nombre_marca"
                                        data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Usuario:</label>
                                    <input disabled class="form-group form-control" type="text"  value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary float-left m-t-n-xs"
                            form="proveedorCreacionForm"><strong>Ingresar Marca</strong></button>
                    </div>
                </div>
            </div>
        </div>

        <!------MODAL PARA EDITAR MARCA--->
        <div id="modal_marcas_editar" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success">Edición de Marcas</h5>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="proveedorCreacionForm" name="proveedorCreacionForm" data-parsley-validate>
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="row" id="row_datos">
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Nombre:</label>
                                    <input class="form-control" required type="text" id="nombre_marca_edit" name="nombre_marca_edit"
                                        data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Usuario:</label>
                                    <input class="form-group form-control" type="text" >
                                </div>
                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary float-left m-t-n-xs"
                            form="proveedorCreacionForm"><strong>Editar Marca</strong></button>
                    </div>
                </div>
            </div>
        </div>

        @push('styles')
        <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
            rel="stylesheet">
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Marcas de Producto</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Lista</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Registro</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Edición</a>
                </li>

            </ol>
        </div>

        <div class="col-lg-4 col-xl-2 col-md-4 col-sm-4">
            <div style="margin-top: 1.5rem">
                <a href="#" class="btn add-btn btn-primary" data-toggle="modal" data-target="#modal_marcas_crear"><i
                        class="fa fa-plus"></i> Registrar Marca</a>
            </div>
        </div>
</div>
