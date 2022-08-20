<div>
    <div class="row wrapper border-bottom white-bg page-heading d-flex align-items-center">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <h2>Registrar Devolución de Producto</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a >Nota de crédito</a>
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
                            <div class="col-12 col-sm-12 col-md-6">
                                <label for="cliente" class="col-form-label focus-label">Seleccionar
                                    Cliente:</label>
                                <select id="cliente" name="cliente" class="form-group form-control" style=""
                                    data-parsley-required >
                                    <option value="" selected disabled>--Seleccionar Cliente--</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <label for="factura" class="col-form-label focus-label">Seleccionar
                                    Factura:</label>
                                <select id="factura" name="factura" class="form-group form-control" style=""
                                    data-parsley-required >
                                    <option value="" selected disabled>--Seleccionar una Factura--</option>
                                </select>
                            </div>
                          
                        </div>
                        <button class="btn btn-primary"><i class="fa-solid fa-paper-plane text-white"></i> Solicitar Factura</button>
                    </div>
                </div>
            </div>            
        </div>    
    </div>    

    <div class="wrapper wrapper-content animated fadeInRight pb-0" >
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">

                    <div class="ibox-content">
                        <h3>Detalle de Factura</h3>

                            <form id="selec_nota_form" name="selec_nota_form" data-parsley-validate>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                    
                                    <div class="form-group">                                      
                                        <label for="codigo_factura">Código de factura:</label>
                                        <input type="text" name="codigo_factura" id="codigo_factura" class="form-control" readonly required>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-3">
                                    
                                    <div class="form-group">                                      
                                        <label for="fecha">Fecha de emisión: </label>
                                        <input type="date" name="fecha" id="fecha" class="form-control" readonly required>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-3">
                                    
                                    <div class="form-group">                                      
                                        <label for="tipo_pago">Tipo de factura:</label>
                                        <input type="text" name="tipo_pago" id="tipo_pago" class="form-control" readonly required>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-3">
                                    
                                    <div class="form-group">                                      
                                        <label for="tipo_venta">Tipo de venta:</label>
                                        <input type="text" name="tipo_venta" id="tipo_venta" class="form-control" readonly required>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4">
                                    
                                    <div class="form-group">                                      
                                        <label for="codigo_cliente">Código de cliente:</label>
                                        <input type="text" name="codigo_cliente" id="codigo_cliente" class="form-control" readonly required>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    
                                    <div class="form-group">                                      
                                        <label for="rtn">RTN:</label>
                                        <input type="text" name="rtn" id="rtn" class="form-control" readonly required>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    
                                    <div class="form-group">                                      
                                        <label for="nombre_cliente">Nombre de cliente:</label>
                                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" readonly required>
                                    </div>

                                </div>

       

                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4">
                                    
                                    <div class="form-group">                                      
                                        <label for="vendedor">Vendido por:</label>
                                        <input type="text" name="vendedor" id="vendedor" class="form-control" readonly required>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    
                                    <div class="form-group">                                      
                                        <label for="facturado">Facturado por:</label>
                                        <input type="text" name="facturado" id="facturado" class="form-control" readonly required>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    
                                    <div class="form-group">                                      
                                        <label for="fecha_registro">Registado en sistema:</label>
                                        <input type="text" name="fecha_registro" id="fecha_registro" class="form-control" readonly required>
                                    </div>

                                </div>

       

                            </div>
                            </form>

                            <table id="tbl_productos" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Bodega</th>
                                        <th>Precio Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Unidad de medida</th>
                                        <th>Sub total</th>
                                        <th>ISV</th>
                                        <th>Total</th>
                                        <th>Opciones</th>
                                        


                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            <br>
                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="subTotalGeneral">Sub Total L.<span class="text-danger">*</span></label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="number" step="any" placeholder="Sub total " id="subTotalGeneral"
                                        name="subTotalGeneral" class="form-control" min="0" data-parsley-required
                                        autocomplete="off" readonly>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="isvGeneral">ISV L.<span class="text-danger">*</span></label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="number" step="any" placeholder="ISV " id="isvGeneral" name="isvGeneral"
                                        class="form-control" min="0" data-parsley-required autocomplete="off"
                                        readonly>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                                    <label class="col-form-label" for="totalGeneral">Total L.<span class="text-danger">*</span></label>
                                </div>

                                <div class="form-group col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                                    <input type="number" step="any" placeholder="Total  " id="totalGeneral"
                                        name="totalGeneral" class="form-control" min="0" data-parsley-required
                                        autocomplete="off" readonly>
                                </div>
                            </div>



                          
                     
                      
                    </div>
                </div>
            </div>            
        </div>    
    </div>  


@push('scripts')

<script>
                $('#cliente').select2({
                ajax:{
                    url:'/nota/credito/clientes',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public',
                            page: params.page || 1
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    }

                }
            });
</script>

@endpush

</div>
