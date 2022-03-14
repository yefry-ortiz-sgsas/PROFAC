<div>

    @push('styles')
        <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
            rel="stylesheet">
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Proveedores</h2>
           
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
                <a href="#" class="btn add-btn btn-primary" data-toggle="modal" data-target="#modal_proveedores_crear" ><i class="fa fa-plus"></i> Registrar Proveedor</a> 
            </div> 
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="tbl_proveedoresListar" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th># de Bodega</th>
                                        <th>Codigo</th>
                                        <th>Dirreción</th>
                                        <th>Encargado</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
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
 




          <div id="modal_proveedores_crear" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success">Regitro de Proveedores</h5></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="proveedorCreacionForm"name="proveedorCreacionForm" data-parsley-validate>
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="row" id="row_datos">
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Código:</label>
                                    <input class="form-control" required type="text" id="codigo_prov" name="codigo_prov" data-parsley-required>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label focus-label">Nombre del proveedor</label>
                                    <input class="form-control" required type="text" id="nombre_prov" name="nombre_prov" data-parsley-required>
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label focus-label">Dirección</label>
                                    <textarea name="direccion_prov" placeholder="Escriba aquí..." required id="direccion_prov" cols="30" rows="3" class="form-group form-control" data-parsley-required></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Contácto</label>
                                    <input  class="form-control" required type="text" id="contacto_prov" name="contacto_prov" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Teléfono</label>
                                    <input class="form-group form-control" required type="text" name="telefono_prov" id="telefono_prov" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Teléfono 2</label>
                                    <input class="form-group form-control" type="text" name="telefono_prov_2" id="telefono_prov_2" >
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Correo electrónico</label>
                                    <input class="form-group form-control" type="text" name="correo_prov" id="correo_prov" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Correo electrónico 2</label>
                                    <input class="form-group form-control" type="text" name="correo_prov_2" id="correo_prov_2" >
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">RTN</label>
                                    <input class="form-group form-control" required type="text" name="rtn_prov" id="rtn_prov" data-parsley-required>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">País</label>
                                    <select class="form-group form-control" name="pais_prov" id="pais_prov">
                                        <option selected >Seleccione una opción</option>
                                        <option value="1">opción 1</option>
                                        <option value="2">opción 2</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Departamento</label>
                                    <select class="form-group form-control" name="depto_prov" id="depto_prov">
                                        <option selected >Seleccione una opción</option>
                                        <option value="1">opción 1</option>
                                        <option value="2">opción 2</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Municipio</label>
                                    <select class="form-group form-control" name="municipio_prov" id="municipio_prov">
                                        <option selected >Seleccione una opción</option>
                                        <option value="1">opción 1</option>
                                        <option value="2">opción 2</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Giro de Negocio</label>
                                    <select class="form-group form-control" name="giro_neg_prov" id="giro_neg_prov" required>
                                        <option selected >Seleccione una opción</option>
                                        <option value="1">Comercial</option>
                                        <option value="2">Privado</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Categoría</label>
                                    <select class="form-group form-control" name="categoria_prov" id="categoria_prov" required>
                                        <option selected >Seleccione una opción</option>
                                        <option value="1">Mayorísta</option>
                                        <option value="2">Unitario</option>
                                    </select>
                                </div>
    
                                <div class="col-md-4">
                                    <label class="col-form-label focus-label">Retención del 1%</label>
                                    <select class="form-group form-control" name="retencion_prov" id="retencion_prov" required>
                                        <option selected >Seleccione una opción</option>
                                        <option value="1">opción 1</option>
                                        <option value="2">opción 2</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary float-left m-t-n-xs"
                                    form="proveedorCreacionForm" ><strong>Crear
                                        Bodega</strong></button>
                    </div>
    
                </div>
            </div>
        </div>
    



    </div>

    @push('scripts')
        <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>


        <script>
            $(document).ready(function() {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>

        <script src="{{ asset('js/js_proyecto/proveedores.js') }}"></script>
    @endpush

</div>
