<div>

    @push('styles')
        <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
            rel="stylesheet">
    @endpush

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h2 class="font-weight-normal">Bodega</h2>
                    {{-- <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div> --}}

                </div>

                <div class="ibox-content">
                    <form id="bodegaCreacion" data-parsley-validate>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
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
                                form="bodegaCreacion" ><strong>Crear
                                    Bodega</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content" style="">
                    <img src="{{ asset('img_profac/Estante de Bodega.png') }}" alt="" style="margin: 0 auto">
                </div>

            </div>

        </div>
    </div>

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

        <script src="{{ asset('js/js_proyecto/bodega.js') }}"></script>
    @endpush

</div>
