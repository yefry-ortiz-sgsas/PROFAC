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
            <h2>Cierre de caja</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a >Histórico de cierre de caja diaria</a>
                </li>


            </ol>
        </div>
       {{--   /cajaChica/excel/general  --}}
    </div>
{{--      <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-12">
                                <label for="fecha" class="col-form-label focus-label">Precione para descargar un reporte de cierre de caja completo, sin filtros<span class="text-danger">*</span></label>

                                <a href="/cajaChica/excel/general" class="btn btn-info"><i class="fa fa-plus"></i> Solicitar Reporte</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert alert-info" role="alert">
            <h5> <b>Nota: Se enlista los cierres de cajas realizados, con su respectivo reporte independiente.</h5>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="tbl_bitacoracierre" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Cod Cierre</th>
                                        <th>Dia Cerrado</th>
                                        <th>Usuario</th>
                                        <th>Comentario</th>
                                        <th>Estado de cierre</th>
                                        <th>Monto Total Contado</th>
                                        <th>Monto Total Credito</th>
                                        <th>Monto Total Acumulado</th>
                                        <th>Fecha del registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cod Cierre</th>
                                            <th>Dia Cerrado</th>
                                            <th>Usuario</th>
                                            <th>Comentario</th>
                                            <th>Estado de cierre</th>
                                            <th>Monto Total Contado</th>
                                            <th>Monto Total Credito</th>
                                            <th>Monto Total Acumulado</th>
                                            <th>Fecha del registro</th>
                                            <th>Acciones</th>
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
    tblHistorico();
 function tblHistorico(){
    $("#tbl_bitacoracierre").dataTable().fnDestroy();
    $('#tbl_bitacoracierre').DataTable({
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
        "ajax": "/cargar/historico",
        "columns": [

            {
                data: 'id'
            },
            {
                data: 'fechaCierre'
            },
            {
                data: 'user_cierre_id'
            },
            {
                data: 'comentario'
            },
            {
                data: 'estado_cierre',
                render: function (data, type, row) {


                    if(data === 1){
                        return "<span class='badge badge-primary'>CERRADO</span>";
                    }


                }
            },

            {
                data: 'totalContado'
            },
            {
                data: 'totalCredito'
            },
            {
                data: 'totalAnulado'
            },
            {
                data: 'created_at'
            },
            {
                data: 'acciones'
            }
        ],initComplete: function () {
            var r = $('#tbl_bitacoracierre tfoot tr');
            r.find('th').each(function(){
              $(this).css('padding', 8);
            });
            $('#tbl_bitacoracierre thead').append(r);
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
