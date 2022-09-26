<div>
    @push('styles')
    <style>


    </style>
@endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Facturar Orden De Entrega</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                
                    
                    <a>Cliente Corporativo</a>
                    
                    
                
                </li>
                {{-- <li class="breadcrumb-item">
                    <a data-toggle="modal" data-target="#modal_producto_crear">Registrar</a>
                </li> --}}

            </ol>
        </div>
    </div> 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3>Datos de Comprobante <i class="fa-solid fa-cart-shopping"></i></h3>
                    </div>
                    <div class="ibox-content">
                        <form onkeydown="return event.key != 'Enter';" autocomplete="off" id="crear_venta" name="crear_venta" data-parsley-validate>
                            <div class="row mt-4">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label for="seleccionarCliente" class="col-form-label focus-label">Seleccionar
                                        Cliente:<span class="text-danger">*</span> </label>
                                    <select id="seleccionarCliente" name="seleccionarCliente" class="form-group form-control" style=""
                                        data-parsley-required readonly>                                      
                                        <option value="" selected >--data--</option>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label class="col-form-label focus-label">Nombre del cliente:<span class="text-danger">*</span></label>
                                    <input class="form-control" required type="text" id="nombre_cliente_ventas" name="nombre_cliente_ventas" value=""
                                        data-parsley-required readonly>

                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label class="col-form-label focus-label">RTN:<span class="text-danger">*</span></label>
                                    <input class="form-control"  type="text" id="rtn_ventas" name="rtn_ventas" value=""
                                    readonly>

                                </div>





                            </div>
                        </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>                       
</div>
