<div>
    @push('styles')
    <style>
        .text-success-custom{
            color: #18A689!important;
        }
    </style>
    @endpush

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-xl-10 col-md-8 col-sm-8">
            <h2>Datlle de Venta</h2>
            <ol class="breadcrumb"> 
                <li class="breadcrumb-item">
                    <a>Detalle de Venta</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="wrapper wrapper-content animated fadeInRight">
    
    
                <div class="ibox mb-0">
                    <div class="ibox-title">
                        <h3 class="text-success"><i class="fa-solid fa-list-check "></i> Informacion de venta</h3>
                    </div>
                    <div class="ibox-content"
                        style="height: 18.5rem;  display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Codigo: 
                                </strong> {{$detalleVenta->id}} </p>
                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Número de factura: 
                                </strong> {{$detalleVenta->numero_factura}}  </p>

                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Cliente: 
                            </strong> {{$detalleVenta->nombre_cliente}} </p>
                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> RTN: 
                            </strong> {{$detalleVenta->rtn}} </p>
                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Fecha de emisión:</strong> {{$detalleVenta->fecha_emision}} 
                                </p>
                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Fecha de vencimiento:</strong> {{$detalleVenta->fecha_vencimiento}}</p>
                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Estado de Factura: </strong> {{$detalleVenta->estado_venta}}</p>
                            <p class="mt-2 mb-2"> <strong> <i class="fa-solid fa-caret-right"></i> Venta realizada por: </strong> {{$detalleVenta->name}}</p>

                        </div>
    
                    </div>
                </div>
    
    
            </div>
        </div>
    
    
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="wrapper wrapper-content animated fadeInRight">
    
    
                <div class="ibox mb-0">
                    <div class="ibox-title">
                        <h3 class="text-success"><i class="fa-solid fa-sack-dollar"></i>Datos de Facturacion</h3>
    
                    </div>
                    <div class="ibox-content "
                        style="height: 18.5rem; display: flex; flex-direction: column; justify-content: space-between;  ">
                          
                        
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Número de Factura CAI: 
                            </strong> {{$detalleVenta->cai}}  </p>
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Número de inicio: </strong> {{$detalleVenta->numero_inicial}} </p>     
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Número final: </strong> {{$detalleVenta->numero_final}} </p>  
   
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Fecha limite de emision: </strong> {{$detalleVenta->fecha_limite_emision}} </p>  
                    

    
    
                    </div>
                </div>
    
    
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="wrapper wrapper-content animated fadeInRight">
    
    
                <div class="ibox mb-0">
                    <div class="ibox-title">
                        <h3 class="text-success"><i class="fa-solid fa-sack-dollar"></i>Importes</h3>
    
                    </div>
                    <div class="ibox-content "
                        style="height: 18.5rem; display: flex; flex-direction: column; justify-content: space-between;  ">
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Tipo de pago </strong>  Lps.</p>
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Tipo de cliente: </strong> </p>                       
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Comision del vendedor: </strong> Lps.</p>  
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Sub total: </strong> Lps.</p>  
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> ISV: </strong> Lps.</p>  
                        <p class="mt-2 mb-2 d-block"> <strong> <i class="fa-solid fa-caret-right"></i> Total: </strong> Lps.</p>  

    
    
                    </div>
                </div>
    
    
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3 class="text-success"><i class="fa-solid fa-rectangle-list"></i> Lista de compra </h3>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="tbl_productos_compra" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>N° Compra</th>
                                        <th>ID Producto</th>
                                        <th>Nombre</th>
                                        <th>Precio Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Sub Total</th>
                                        <th>ISV</th>
                                        <th>Total</th>
                                        <th>Fecha de vencimiento</th>
                                        <th>Estado en bodega</th>
                                        

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
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3 class="text-success"><i class="fa-solid fa-cash-register"></i> Pagos Realizados</h3>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="tbl_pagos_lista" class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>N° Factura</th>
                                        <th>N° Compra</th>
                                        <th>Monto Lps.</th>
                                        <th>Fecha</th>
                                        <th>Registrado por:</th>
                                        <th>Registrado en sistema:</th>                                      
                                       
                                    </tr>
                                </thead>  
                                <tbody>                                   
    
                                </tbody>
                            </table>
    
                        </div>

                        <div class="d-flex d-flex justify-content-between mt-4" >
                            <div >
                                <h3>Pendiente de Pago: <span class="text-danger"> Lps.</span> </h3>

                            </div>
                            <div >
                                <h3>Total Pagado: <span class="text-success"> Lps.</span></h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    <script>


    </script>

    @endpush
</div>

