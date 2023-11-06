<div>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Aplicación de Pagos</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">/ Cuentas Por Cobrar</a>
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
                                <label for="cliente" class="col-form-label focus-label">Seleccionar Cliente:<span class="text-danger">*</span></label>
                                <select id="cliente" name="cliente" class="form-group form-control" style=""
                                    data-parsley-required >
                                    <option value="" selected disabled>--Seleccionar un Cliente--</option>
                                </select>
                            </div>

                            <div class="col-6 col-sm-6 col-md-6 " id="btnEC" name="btnEC" style="display: none">
                                <label for="cliente" class="alert alert-warning"> <b>Estado de cuenta</b> <span class="text-danger"></span></label>
                                <button class="btn btn-primary btn-block" onclick="pdfEstadoCuenta()"><i class="fa-solid fa-paper-plane text-white"></i> Visualizar </button>
                            </div>



                        </div>
                        <button class="btn btn-primary mt-2" onclick=" llamarTablas()"><i class="fa-solid fa-paper-plane text-white"></i> Solicitar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>




    {{--  MODAL DE RETENCION DE ISV  --}}
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
                                <form class="form-control" id="formEstadoRetencion" name="formEstadoRetencion" >
                                <div class="row">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>Código de Registro:</b></label>
                                                <input type="text" readonly class="form-control" id="codAplicPago" name="codAplicPago" >
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>Código de Factura:</b></label>
                                                <input type="text" readonly class="form-control" id="codigoFactura" name="codigoFactura" >
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>Monto de retención:</b></label>
                                                <input type="text" readonly class="form-control" id="montoRetencion" name="montoRetencion" >
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>Nota (Obligatoria):</b></label>
                                                <textarea class="form-control" id="comentario_retencion" name="comentario_retencion" cols="30" rows="10"></textarea>
                                            </div>


                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <label for="exampleFormControlTextarea1"> <b>Seleccione estado de retención</b></label>

                                                 <select id="selectTipoCierre" name="selectTipoCierre" class="form-control form-select form-select-lg">

                                                   <option class="form-control" value="1">SE APLICA AL SALDO</option>
                                                   <option class="form-control"  value="2">NO SE APLICA AL SALDO</option>
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
    {{--  FIN DEL MODAL DE RETENCION ISV  --}}






    <div class="wrapper wrapper-content animated fadeInRight">
        {{--  <div class="mb-2"  id="cuentas_excel">
            <!-- <a href="/ventas/cuentas_por_cobrar/excel_cuentas" class="btn-seconary"><i class="fa fa-plus"></i> Exportar Excel Cuentas Por Cobrar</a> -->
        </div>  --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_cuentas_facturas_cliente" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Codigo Pagos</th>
                                        <th>Código Factura</th>
                                        <th>Cargo de Factura</th>
                                        <th>ISV</th>
                                        <th>Notas de Crédito</th>
                                        <th>Notas de Débito</th>
                                        <th>Créditos/Abonos</th>
                                        <th>Cargo extra (+)</th>
                                        <th>Cargo Debita (-)</th>
                                        <th>Saldo</th>
                                        <th>Retencion</th>
                                        <th>Estado de Pago</th>
                                        <th>User de cierre</th>
                                        <th>Fecha de registro</th>
                                        <th>Ultima actualizacion</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Codigo Pagos</th>
                                            <th>Código Factura</th>
                                            <th>Cargo de Factura</th>
                                            <th>ISV</th>
                                            <th>Notas de Crédito</th>
                                            <th>Notas de Débito</th>
                                            <th>Créditos/Abonos</th>
                                            <th>Cargo extra (+)</th>
                                            <th>Cargo Debita (-)</th>
                                            <th>Saldo</th>
                                            <th>Retencion</th>
                                            <th>Estado de Pago</th>
                                            <th>User de cierre</th>
                                            <th>Fecha de registro</th>
                                            <th>Ultima actualizacion</th>
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

{{--      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="tbl_historico_saldos_cliente" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>No. Factura</th>
                                        <th>Orden de Compra</th>
                                        <th>Cliente</th>
                                        <th>Fecha Emision</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>Cargo</th>
                                        <th>Credito</th>
                                        <th>Notas Crédito</th>
                                        <th>Notas Débito</th>
                                        <th>Saldo</th>
                                        <th>Acumulado</th>
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
    </div>  --}}







</div>
@push('scripts')
<script>
        $('#btnEC').css('display','none');
        $('#btnEC').hide();

        $('#cliente').select2({
            ajax: {
                url: '/aplicacion/pagos/clientes',
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'public',
                        page: params.page || 1
                    }


                    return query;
                }
            }
        });

    function llamarTablas(){

        $("#tbl_cuentas_facturas_cliente").dataTable().fnDestroy();
        $("#tbl_historico_saldos_cliente").dataTable().fnDestroy();

        this.listarCuentasPorCobrar();
       //this.listarCuentasPorCobrarInteres();

    }

    function pdfEstadoCuenta(){

        var idClientepdf = document.getElementById('cliente').value;
        window.open('/cuentas_por_cobrar/pagos/estadoCuenta/imprimir/'+idClientepdf, '_blank');
    }

    function listarCuentasPorCobrar() {

        var idCliente = document.getElementById('cliente').value;
        $('#tbl_cuentas_facturas_cliente').DataTable({
                    "order": [0, 'desc'],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
                    pageLength: 10,
                    responsive: true,
                    dom: "Bfrtip",
                    buttons: [
                        {
                            extend: 'excel',
                            title: '-'+idCliente,
                            className: 'btn btn-success',
                            excelStyles: {
                                cells: "1",
                                style: {
                                    font:{
                                        name:'Arial',
                                        size: "16",
                                        color: 'FFFFFF',
                                        b: true
                                    },
                                    fill:{
                                        pattern: {
                                            color: 'ff7961'
                                        }
                                    }
                                }
                            }
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
                    "ajax": "/aplicacion/pagos/listar/"+idCliente,
                    "columns": [

                        {
                            data: 'codigoPago'
                        },
                        {
                            data: 'codigoFactura'
                        },
                        {
                            data: 'cargo'
                        },
                        {
                            data: 'notasCredito'
                        },
                        {
                            data: 'notasDebito'
                        },
                        {
                            data: 'abonosCargo'
                        },
                        {
                            data: 'movSuma'
                        },
                        {
                            data: 'movResta'
                        },
                        {
                            data: 'isv'
                        },
                        {
                            data: 'saldo'
                        },
                        {
                            data: 'estadoRetencion',
                            render: function (data, type, row) {


                                if(data === 1){
                                    return "<span class='badge badge-success'>SE APLICA</span>";
                                }else if(data === 2){
                                    return "<span class='badge badge-warnig'>NO SE APLICA</span>";
                                }


                            }
                        },
                        {
                            data: 'estado',
                            render: function (data, type, row) {


                                if(data === 1){
                                    return "<span class='badge badge-success'>ACTIVO</span>";
                                }else if(data === 2){
                                    return "<span class='badge badge-danger'>INACTIVO</span>";
                                }


                            }
                        },
                        {
                            data: 'usrCierre'
                        },
                        {
                            data: 'fechaRegistro'
                        },
                        {
                            data: 'ultimoRegistro'
                        },
                        {
                            data: 'acciones'
                        }


                    ],initComplete: function () {
                        var r = $('#tbl_cuentas_facturas_cliente tfoot tr');
                        r.find('th').each(function(){
                          $(this).css('padding', 8);
                        });
                        $('#tbl_cuentas_facturas_cliente thead').append(r);
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
                //$('#btnEC').css('display','block');
                //$('#btnEC').show();
    }


    //////////////////////////////////////////////////////////////////////////////////

    function listarCuentasPorCobrarInteres() {

        var idCliente = document.getElementById('cliente').value;
        $('#tbl_historico_saldos_cliente').DataTable({
                    "order": [0, 'desc'],
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
                    "ajax": "/aplicacion/pagos/listar/hitorico/"+idCliente,
                    "columns": [
                        {
                            data: 'numero_factura'
                        },
                        {
                            data: 'correlativo'
                        },
                        {
                            data: 'id_cliente'
                        },
                        {
                            data: 'cliente'
                        },
                        {
                            data: 'documento'
                        },
                        {
                            data: 'fecha_emision'
                        },
                        {
                            data: 'fecha_vencimiento'
                        },
                        {
                            data: 'cargo'
                        },
                        {
                            data: 'abonos'
                        },
                        {
                            data: 'dias'
                        },
                        {
                            data: 'interesInicia'
                        },
                        {
                            data: 'interesDiario'
                        },
                        {
                            data: 'acumulado'
                        }
                    ]


                });
    }

    //////////////////////////////////////////////////////////////////////////////////

    {{--  function mostrarExports() {

        var cliente = document.getElementById('cliente').value;

                let htmlSelect1 = ''

                htmlSelect1 =   `
                        <a href="/cuentas_por_cobrar/pagos/excel_cuentas/${cliente}" class="btn btn-primary"><i class="fa fa-plus"></i> Exportar Excel Cuentas Por Cobrar</a>

                                `

                document.getElementById('cuentas_excel').innerHTML = htmlSelect1;

                //////////////////////////////////////////////////////////////////////////////
                let htmlSelect2 = ''

                htmlSelect2 =   `
                        <a href="/cuentas_por_cobrar/pagos/excel_intereses/${cliente}" class="btn btn-primary"><i class="fa fa-plus"></i>Excel Cuentas Por Cobrar Intereses</a>

                                `

                document.getElementById('cuentas_excel_intereses').innerHTML = htmlSelect2;

    }  --}}


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
