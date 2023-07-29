<div>
    @push('styles')
    <style>
        .a-none {
            pointer-events: none
        }
    </style>

    @endpush
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12
        ">
            <h2>Incidencias</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Bodega</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Compra</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3>Incidencias de bodega</h3>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="tbl_incidencia_bodega" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>N° de Factura</th>
                                        <th>Codigo de Producto</th>
                                        <th>Nombre de Producto</th>
                                        <th>Bodega</th>
                                        <th>Seccion</th>
                                        <th>Comentario de Incidencia</th>
                                        <th>Archivo</th>
                                        <th>Fecha de registro:</th>
                                        <th>Registrado Por:</th>

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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3>Incidencias de Compra</h3>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_incidencia_compra" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>N° de Factura</th>
                                        <th>Codigo de Producto</th>
                                        <th>Nombre de Producto</th>
                                        <th>Comentario de Incidencia</th>
                                        <th>Archivo</th>
                                        <th>Fecha de registro:</th>
                                        <th>Registrado Por:</th>

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


    @push('scripts')

        <script>
            var idCompra = {{ $idCompra}}
        $(document).ready(
            function() {



            $('#tbl_incidencia_bodega').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                pageLength: 10,
                responsive: true,
                "ajax": "/inventario/incidencia/bodega/"+idCompra,
                "columns": [
                                {
                                    data: 'numero_factura'
                                },
                                {
                                    data: 'cod_producto'
                                },
                                {
                                    data: 'nombre'
                                },
                                {
                                    data: 'bodega'
                                },
                                {
                                    data: 'seccion'
                                },
                                {
                                    data: 'descripcion'
                                },
                                {
                                    data: 'img'
                                },
                                {
                                    data: 'created_at'
                                },
                                {
                                    data: 'name'
                                }


                            ]


            });

            $('#tbl_incidencia_compra').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                pageLength: 10,
                responsive: true,
                "ajax": "/inventario/incidencia/compra/"+idCompra,
                "columns": [
                                {
                                    data: 'numero_factura'
                                },
                                {
                                    data: 'cod_producto'
                                },
                                {
                                    data: 'nombre'
                                },
                                {
                                    data: 'descripcion'
                                },
                                {
                                    data: 'img'
                                },
                                {
                                    data: 'created_at'
                                },
                                {
                                    data: 'name'
                                }


                            ]


            });

        }

        );
        </script>
    @endpush
</div>
<?php
    date_default_timezone_set('America/Tegucigalpa');
    $act_fecha=date("Y-m-d");
    $act_hora=date("H:i:s");
    $mes=date("m");
    $year=date("Y");
    $datetim=$act_fecha." ".$act_hora;
?>
<script>
    function mostrarHora() {
        var fecha = new Date(); // Obtener la fecha y hora actual
        var hora = fecha.getHours();
        var minutos = fecha.getMinutes();
        var segundos = fecha.getSeconds();

        // A単adir un 0 delante si los minutos o segundos son menores a 10
        minutos = minutos < 10 ? "0" + minutos : minutos;
        segundos = segundos < 10 ? "0" + segundos : segundos;

        // Mostrar la hora actual en el elemento con el id "reloj"
        document.getElementById("reloj").innerHTML = hora + ":" + minutos + ":" + segundos;
    }
    // Actualizar el reloj cada segundo
    setInterval(mostrarHora, 1000);
</script>
<div class="float-right">
    <?php echo "$act_fecha";  ?> <strong id="reloj"></strong>
</div>
<div>
    <strong>Copyright</strong> Distribuciones Valencia &copy; <?php echo "$year";  ?>
</div>
<p id="reloj"></p>
