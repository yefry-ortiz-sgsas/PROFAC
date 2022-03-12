<div>

    @push('styles')
        <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
            rel="stylesheet">
    @endpush

    <div id="modal_hacer_despido" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success">Ficha de despido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_despido" data-parsley-validate>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="row" id="row_datos">
                            <div class="col-12">
                                <label class="col-form-label focus-label">Buscar Colaborador <span class="text-danger">*</span></label>
                                <select class="js-data-example-ajax form-control" required style="width: 742px; height:40px;" name="empleado_id" id="empleado_id">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label focus-label">Identidad</label>
                                <input disabled class="form-control" type="text" id="identidad_empleado" name="identidad_empleado" >
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label focus-label">Código de Contrato</label>
                                <input disabled class="form-control" type="text" id="codigo_contrato_empleado" name="codigo_contrato_empleado" >
                                <input type="hidden" id="id_contrato" name="id_contrato" >
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label focus-label">Puesto Asignado</label>
                                <input disabled class="form-control" type="text" id="puesto_empleado" name="puesto_empleado" >
                            </div>
                            <div class="col-md-12">
                                <label class="col-form-label focus-label">Fecha de activación de despido</label>
                                <input  class="form-control" required type="date" id="fecha_despido" name="fecha_despido" >
                            </div>
                            <div class="col-md-12">
                                <label class="col-form-label focus-label">Motivo del despido</label>
                                <textarea required class="form-group form-control" name="motivo_despido" id="motivo_despido" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="text-center submit-section" >
                            <button  class="btn btn-success submit-btn ">Continuar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h2 class="font-weight-normal">Proveedores</h2>

                </div>

                {{-- <div class="ibox-content">
                    <form id="bodegaCreacion" data-parsley-validate>
                        <div class="row">

                            <div class="col-sm-6 b-r">
                                <h4>Información general <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </h4>
                                <br>



                                <div class="form-group">
                                    <label for="bodega">Nombre de bodega</label>
                                    <input id="bodega" name="bodega" type="text" placeholder="Nombre de bodega"
                                        class="form-control " data-parsley-required>
                                </div>

                                <div class="form-group">
                                    <label for="direccionBodega">Dirección</label>
                                    <input id="direccionBodega" name="direccionBodega" type="text"
                                        placeholder="Direccion de bodega" class="form-control" data-parsley-required>
                                </div>

                                <div>
                                    <label for="encargadoBodega">Encargado de bodega</label>
                                    <select id="encargadoBodega" name="encargadoBodega" class="form-control m-b"
                                        name="account" data-parsley-required>
                                        <option value="0" selected disabled>Seleccione un encargado</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach

                                    </select>

                                </div>




                            </div>

                            <div class="col-sm-6">
                                <h4>Segmentacion de bodega <i class="fa fa-cubes" aria-hidden="true"></i></h4>
                                <br>

                                <div class="form-group">
                                    <label for="bodegaNumEstant">Número de estantes</label>
                                    <input id="bodegaNumEstant" name="bodegaNumEstant" type="number"
                                        placeholder="Ingresé el número de estantes" class="form-control" min="0"
                                        max="10" data-parsley-required>
                                </div>


                                <div class="form-group">
                                    <label for="bodegaNumRepisa">Número de repisas por estante</label>
                                    <input id="bodegaNumRepisa" name="bodegaNumRepisa" type="number"
                                        placeholder="Ingresé el número de estantes" class="form-control" min="0"
                                        max="10" data-parsley-required>
                                </div>

                                <div class="form-group">
                                    <label for="bodegaNumSec">Número de secciones por repisa</label>
                                    <input id="bodegaNumSec" name="bodegaNumSec" type="number"
                                        placeholder="Ingresé el número de secciones" class="form-control"
                                        data-parsley-required max="10" min="0">
                                </div>


                            </div>



                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-sm btn-primary float-left m-t-n-xs"
                                form="bodegaCreacion"><strong>Crear
                                    Bodega</strong></button>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>


    </div>
    {{--<div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content" style="">
                        <img src="{{ asset('img_profac/Estante de Bodega.png') }}" alt="" style="margin: 0 auto">
                    </div>

                </div>

            </div>
        </div> --}}

    <div>

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
