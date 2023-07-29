<div>
    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
    <div class="modal" id="modalCobro" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Seleccione un tipo de pago:</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-content">
                                <form class="form-control" id="formtipoCobro" name="formtipoCobro" >
                                <div class="row">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>Fecha de cierre:</b></label>
                                                <input type="text" readonly class="form-control" id="fechaCierreC" name="fechaCierreC" >
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>No. Factura:</b></label>
                                                <input type="text" readonly class="form-control" id="inputFactura" name="inputFactura" >
                                            </div>

                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>Seleccione un tipo de cobro</b></label>

                                                 <select id="selectTipoCierre" name="selectTipoCierre" class="form-control form-select form-select-lg">

                                                   <option class="form-control" value="EFECTIVO">EFECTIVO</option>
                                                   <option class="form-control"  value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option>
                                                   <option class="form-control" value="CHEQUE">CHEQUE</option>
                                                 </select>
                                            </div>
                                        </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <button id="btn_cobroCierre" class="btn  btn-dark btn-lg btn-block float-left m-t-n-xs">
                                            <strong>
                                                Registrar tipo de Cobro
                                            </strong>
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
             <nav aria-label="breadcrumb">


        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Módulo Contable</a></li>
          <li class="breadcrumb-item"><a>Cierre de caja</a></li>
          <li class="breadcrumb-item active" aria-current="page">Diario</li>
        </ol>
      </nav>
        </div>

    </div>






    <br>
    <div id="baner1" class="alert alert-secondary" role="alert">
        <h4 class="alert-heading">Cierre de caja.</h4>
        <h2 class="mb-0"> <b>Nota: </b> Se requiere de selección de fecha para mostrar la información.</h2>
    </div>

    <div id="baner2" style="display: none;" class="alert alert-success" role="alert">
        <h4 class="alert-heading">Cierre de caja.</h4>
        <h2 class="mb-0"> Revisión de facturas en la fecha seleccionada.</h2>
    </div>

    <div id="baner3" style="display: none;" class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Cierre de caja.</h4>
        <h2 class="mb-0"> La caja para esta fecha, está cerrada.</h2>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-12">
                                <label for="fecha" class="col-form-label focus-label">Fecha a revisar:<span class="text-danger">*</span></label>
                                <input class="form-group form-control" type="date" id="fecha" name="fecha" value="{{date('Y-m-01')}}">
                                <button class="btn btn-primary btn-lg btn-block" onclick="cargaConsulta()"><i class="fa-solid fa-paper-plane text-white"></i> Solicitar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert alert-success" role="alert">
            <h5> <b>Nota: </b> FACTURAS DE CONTADO.</h5>

        </div>
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Total Lps.</span>
            </div>
            <input value="0.00"  style="font-size: 18px" type="text"  id="totalContado" name="totalContado"  disabled class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_contado" class="table table-striped table-bordered table-hover border border-success">
                                <thead class="">
                                    <tr>
                                       {{--   <th>FECHA</th>
                                        <th>MES</th>  --}}
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                        <th>DOCUMENTO DE PAGO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tfoot>
                                        <tr>
                                            {{--  <th>FECHA</th>
                                            <th>MES</th>  --}}
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>VENDENDOR</th>
                                            <th>SUBTOTAL</th>
                                            <th>IMPUESTO DE VENTA</th>
                                            <th>TOTAL</th>
                                            <th>TIPO</th>
                                            <th>DOCUMENTO DE PAGO</th>
                                            <th>ACCIONES</th>
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
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert alert-warning" role="alert">
            <h5> <b>Nota: </b> FACTURAS DE CREDITO.</h5>
        </div>
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Total Lps.</span>
            </div>
            <input value="0.00"  style="font-size: 18px" type="text"  id="totalCredito" name="totalCredito"  disabled class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_credito" class="table table-striped table-bordered table-hover border border-warning">
                                <thead class="">
                                    <tr>
                                        {{--  <th>FECHA</th>
                                        <th>MES</th>  --}}
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tfoot>
                                        <tr>
                                            {{--  <th>FECHA</th>
                                            <th>MES</th>  --}}
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>VENDENDOR</th>
                                            <th>SUBTOTAL</th>
                                            <th>IMPUESTO DE VENTA</th>
                                            <th>TOTAL</th>
                                            <th>TIPO</th>
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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert alert-danger" role="alert">
            <h5> <b>Nota: </b> FACTURAS ANULADAS.</h5>
        </div>
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Total Lps.</span>
            </div>
            <input value="0.00"  style="font-size: 18px" type="text"  id="totalAnuladas" name="totalAnuladas"  disabled class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_anuladas" class="table table-striped table-bordered table-hover border border-danger">
                                <thead class="">
                                    <tr>
                                        {{--  <th>FECHA</th>
                                        <th>MES</th>  --}}
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                       {{--   <th>FECHA</th>
                                        <th>MES</th>  --}}
                                        <th>FACTURA</th>
                                        <th>CLIENTE</th>
                                        <th>VENDENDOR</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO DE VENTA</th>
                                        <th>TOTAL</th>
                                        <th>TIPO</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="wrapper wrapper-content animated fadeInRight" id="divcierre">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3>Datos extras de cierre de caja <i class="fa-solid fa-cart-shopping"></i></h3>
                    </div>
                    <div class="ibox-content">
                        <form class="form-control" id="cerrarCaja" name="cerrarCaja" >
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"> <b>Detalle un comentario sobre el cierre</b></label>
                                    <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="row">
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="exampleFormControlTextarea1"> <b>Total Facturas de Contado</b></label>
                                        <input type="text" readonly class="form-control" id="inputTotalContado" name="inputTotalContado" >
                                    </div>

                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="exampleFormControlTextarea1"> <b>Total Facturas de Credito</b></label>
                                        <input type="text" readonly class="form-control" id="inputTotalCredito" name="inputTotalCredito" >
                                    </div>

                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="exampleFormControlTextarea1" style="font-size: 14px;"> <b>Total Facturado</b></label>
                                        <input type="text" readonly class="form-control" id="inputTotalAnulado" name="inputTotalAnulado" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <button id="btn_cierreCaja" class="btn  btn-dark btn-lg btn-block float-left m-t-n-xs"><strong>Realizar Cierre</strong></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@push('scripts')

<script>

    $('#divcierre').css('display','none');
    $('#divcierre').hide();
    $('#btn_cierreCaja').css('display','none');

    $('#btn_cierreCaja').hide();

    function cargaConsulta(){
        $('#baner1').css('display','none');

        $('#baner2').css('display','none');

        $('#baner3').css('display','none');

        $("#tbl_contado").dataTable().fnDestroy();
        $("#tbl_credito").dataTable().fnDestroy();
        $("#tbl_anuladas").dataTable().fnDestroy();

        var fecha = document.getElementById('fecha').value;

        /*LLENADO DE LAS DISTINTAS TABLAS*/

        $('#tbl_contado').DataTable({
            "paging": true,
            "language": {
                "url": "//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"
            },
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [

                {
                    extend: 'excel',
                    title: 'Facuracion_dia',
                    className:'btn btn-success'
                }
            ],
            "ajax": "/contado/"+fecha,
            "columns": [
                /*{
                    data: 'fecha'
                },
                {
                    data: 'mes'
                },*/
                {
                    data: 'factura'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'vendedor'
                },
                {
                    data: 'subtotal'
                },

                {
                    data: 'imp_venta'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tipo',
                    render: function (data, type, row) {


                        if(data === 'CLIENTE B'){
                            return "<span class='badge badge-primary'>"+data+"</span>";
                        }else if(data === 'CLIENTE A'){
                            return "<span class='badge badge-info'>"+data+"</span>";
                        }


                    }
                },
                {
                    data: 'PagoMediante',
                    render: function (data, type, row) {


                        if(data === 'SIN ASIGNAR'){
                            return "<span class='badge badge-warning'>"+data+"</span>";
                        }else {
                            return "<span class='badge badge-success'>"+data+"</span>";
                        }


                    }
                },
                {
                    data: 'acciones'
                },

            ],initComplete: function () {
                var r = $('#tbl_contado tfoot tr');
                r.find('th').each(function(){
                  $(this).css('padding', 8);
                });
                $('#tbl_contado thead').append(r);
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

        $('#tbl_credito').DataTable({
            "paging": true,
            "language": {
                "url": "//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"
            },
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [

                {
                    extend: 'excel',
                    title: 'Facuracion_dia',
                    className:'btn btn-success'
                }
            ],
            "ajax": "/credito/"+fecha,
            "columns": [
                /*{
                    data: 'fecha'
                },
                {
                    data: 'mes'
                },*/
                {
                    data: 'factura'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'vendedor'
                },
                {
                    data: 'subtotal'
                },

                {
                    data: 'imp_venta'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tipo',
                    render: function (data, type, row) {


                        if(data === 'CLIENTE B'){
                            return "<span class='badge badge-primary'>"+data+"</span>";
                        }else if(data === 'CLIENTE A'){
                            return "<span class='badge badge-info'>"+data+"</span>";
                        }


                    }
                },
            ],initComplete: function () {
                var r = $('#tbl_credito tfoot tr');
                r.find('th').each(function(){
                  $(this).css('padding', 8);
                });
                $('#tbl_credito thead').append(r);
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

        $('#tbl_anuladas').DataTable({
            "paging": true,
            "language": {
                "url": "//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"
            },
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [

                {
                    extend: 'excel',
                    title: 'Facuracion_dia',
                    className:'btn btn-success'
                }
            ],
            "ajax": "/anuladas/"+fecha,
            "columns": [
                /*{
                    data: 'fecha'
                },
                {
                    data: 'mes'
                },*/
                {
                    data: 'factura'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'vendedor'
                },
                {
                    data: 'subtotal'
                },

                {
                    data: 'imp_venta'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tipo',
                    render: function (data, type, row) {


                        if(data === 'CLIENTE B'){
                            return "<span class='badge badge-primary'>"+data+"</span>";
                        }else if(data === 'CLIENTE A'){
                            return "<span class='badge badge-info'>"+data+"</span>";
                        }


                    }
                },
            ],initComplete: function () {
                var r = $('#tbl_anuladas tfoot tr');
                r.find('th').each(function(){
                  $(this).css('padding', 8);
                });
                $('#tbl_anuladas thead').append(r);
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

        /*====================================*/



        cargarTotales();



    }

    function cargarTotales(){

        var fecha1 = document.getElementById('fecha').value;

        axios.get("/carga/totales/"+fecha1)
        .then(response => {

            $('#totalContado').val(response.data.totalContado);
            $('#totalCredito').val(response.data.totalCredito);
            $('#totalAnuladas').val(response.data.totalAnulado);




            $('#inputTotalContado').val(response.data.totalContado);
            $('#inputTotalCredito').val(response.data.totalCredito);
            $('#inputTotalAnulado').val(response.data.totalAnulado);

            var existencia = response.data.banderaCierre;

            if(existencia === 0){

                $('#baner2').css('display','block');
                $('#divcierre').css('display','block');
                $('#divcierre').show();
                $('#btn_cierreCaja').css('display','block');
                $('#btn_cierreCaja').show();
            }else{

                $('#baner3').css('display','block');
            }


        })
        .catch(err => {
            let data = err.response.data;
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text
            })
            console.error(err);

        });
    }

    $(document).on('submit', '#cerrarCaja', function(event) {

        $('#divcierre').css('display','none');
        $('#divcierre').hide();
        $('#btn_cierreCaja').css('display','none');
        $('#btn_cierreCaja').hide();
        event.preventDefault();
        guardarCierre();
    });

    function guardarCierre(){
        var fechaFacturas = document.getElementById('fecha').value;
        var data = new FormData($('#cerrarCaja').get(0));

        axios.post("/cierre/guardar/"+fechaFacturas, data)
            .then(response => {
                $('#cerrarCaja').parsley().reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Exito!',
                    text: "Ha realizado el cierre de caja con exito."
                });
                location. reload()

        })
        .catch(err => {
            let data = err.response.data;
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text
            })
            console.error(err);

        })
    }

    function cargarInputFactura(factura, PagoMediante){
       // $('#myModalExito').modal('show'); // abrir
        //$('#myModalExito').modal('hide'); // cerrar

        var fechaFacturas1 = document.getElementById('fecha').value;
        //console.log(factura);
        $('#fechaCierreC').val(fechaFacturas1);
        $('#inputFactura').val(factura);

        obj = document.getElementById("selectTipoCierre");
        newSel = '<option class="form-control"  selected  value="'+PagoMediante+'">'+PagoMediante+' - Actuál</option><option class="form-control" value="EFECTIVO">EFECTIVO</option><option class="form-control"  value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option><option class="form-control" value="CHEQUE">CHEQUE</option>';
        obj.innerHTML = newSel;


        $('#modalCobro').modal('show');

    }

    $(document).on('submit', '#formtipoCobro', function(event) {
        event.preventDefault();
        guardarTipoCobro();
    });

    function guardarTipoCobro(){

       let factura = document.getElementById('inputFactura').value;
        var data = new FormData($('#formtipoCobro').get(0));
        //console.log(data);
        //$('#formtipoCobro').parsley().reset();
        document.getElementById("fechaCierreC").value = "";
        document.getElementById("inputFactura").value = "";
        const limpiar = () => {
            for (let i = document.querySelector("#selectTipoCierre").options.length; i >= 0; i--) {
                document.querySelector("#selectTipoCierre").remove(i);
            }
          };
        $('#modalCobro').modal('hide');

        axios.post("/registro/tipoC", data)
            .then(response => {

                $('#tbl_contado').DataTable().ajax.reload();

                let data = response.data;
                /*Swal.fire({
                    icon: 'success',
                    title: 'Exito!',
                    text: "Se ha registrado el tipo de cobro para la factura # "+factura
                });*/
                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text
                })


        })
        .catch(err => {
            let data = err.response.data;
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text
            })
            console.error(err);

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
