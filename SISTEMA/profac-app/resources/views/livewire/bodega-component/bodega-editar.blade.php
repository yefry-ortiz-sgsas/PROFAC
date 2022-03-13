<div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Lista de Bodegas</h2>
                <h4>Editar bodega</h4>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">

                        <table id="tbl_bodegaEditar" class="table ">
                            <thead class="">
                                <tr>
                                    <th># de Bodega</th>
                                    <th>Codigo</th>
                                    <th>Dirreción</th>
                                    <th>Encargado</th>                                   
                                    <th>Estado</th>                                   
                                    <th >Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
    
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>                
    {{-- Care about people's approval and you will be their prisoner. --}}
    <h1>editar bodega</h1>

    @push('scripts')

<script>   


   
        $('#tbl_bodegaEditar').DataTable({
    "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
       "serverSide": true,
    processing: true,
    "autoWidth": false,
    "ajax": "/bodega/listar/bodegas",
    "columns": [
        {data:'numero_bodega'},
        {data:'codigo'},
        {data:'direccion'},
        {data:'encargado'},
        {data:'estado_bodega'},
        {data:'opciones'},
        
 
    ]});

    
    



</script>
@endpush

</div>

