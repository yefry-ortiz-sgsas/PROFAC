<div>
    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Cardex General</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Lista</a>
                </li>


            </ol>
        </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">


                            <div class="col-6 col-sm-6 col-md-6 ">
                                <label for="fecha_inicio" class="col-form-label focus-label">Fecha de inicio:<span class="text-danger">*</span></label>
                                <input class="form-group form-control" type="date" id="fecha_inicio" name="fecha_inicio" value="{{date('Y-m-01')}}">
                            </div>

                            <div class="col-6 col-sm-6 col-md-6">
                                <label for="fecha_final" class="col-form-label focus-label">Fecha final:<span class="text-danger">*</span></label>
                                <input class="form-group form-control" type="date" id="fecha_final" name="fecha_final" value="{{date('Y-m-t')}}">
                            </div>

                        </div>
                        <button class="btn btn-primary" onclick="cargaCardex()"><i class="fa-solid fa-paper-plane text-white"></i> Solicitar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_cardex" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Fecha de gestion</th>
                                        <th>Producto</th>
                                        <th>Codigo de producto</th>
                                        <th>Factura</th>
                                        <th>Ajuste</th>
                                        <th>Compra</th>
                                        <th>Comprobante de entrega</th>
                                        <th>Vale Tipo 1</th>
                                        <th>Vale Tipo 2</th>
                                        <th>Nota de credito</th>
                                        <th>Descripcion</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Cantidad</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Fecha de gestion</th>
                                            <th>Producto</th>
                                            <th>Codigo de producto</th>
                                            <th>Factura</th>
                                            <th>Ajuste</th>
                                            <th>Compra</th>
                                            <th>Comprobante de entrega</th>
                                            <th>Vale Tipo 1</th>
                                            <th>Vale Tipo 2</th>
                                            <th>Nota de credito</th>
                                            <th>Descripcion</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Cantidad</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </tfoot>
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




    function cargaCardex(){

        $("#tbl_cardex").dataTable().fnDestroy();

        var fecha_inicio = document.getElementById('fecha_inicio').value;
        var fecha_final = document.getElementById('fecha_final').value;

        $('#tbl_cardex').DataTable({
            "paging": false,
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
                    title: 'Cardex'
                },
                {
                    extend: 'pdf',
                    title: 'Cardex'
                },

                {
                    extend: 'print',
                    title: '',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            "ajax": "/listado/cardex/general/"+fecha_inicio+"/"+fecha_final,
            "columns": [
                {
                    data: 'fechaIngreso'
                },
                {
                    data: 'producto'
                },
                {
                    data: 'codigoProducto'
                },
                {
                    data: 'doc_factura'
                },
                {
                    data: 'doc_ajuste'
                },
                {
                    data: 'detalleCompra'
                },

                {
                    data: 'comprobante_entrega'
                },
                {
                    data: 'vale_tipo_1'
                },
                {
                    data: 'vale_tipo_2'
                },
                {
                    data: 'nota_credito'
                },

                {
                    data: 'descripcion'
                },
                {
                    data: 'origen'
                },
                {
                    data: 'destino'
                },
                {
                    data: 'cantidad'
                },
                {
                    data: 'usuario'
                },
            ],initComplete: function () {
                var r = $('#tbl_cardex tfoot tr');
                r.find('th').each(function(){
                  $(this).css('padding', 8);
                });
                $('#tbl_cardex thead').append(r);
                $('#search_0').css('text-align', 'center');
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            }


        });
    }
</script>

@endpush
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
