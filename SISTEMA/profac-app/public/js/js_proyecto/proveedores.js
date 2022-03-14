// $('#bodegaCreacion').submit(function(e){
//     console.log(e)
//     e.preventDefault();
//     crearBodega();
// });



// $(function () {
//     $('#bodegaCreacion').parsley().on('field:validated', function() {

//       var ok = $('.parsley-error').length === 0;
//       $('.bs-callout-info').toggleClass('hidden', !ok);
//       $('.bs-callout-warning').toggleClass('hidden', ok);
//     })

//     .on('form:submit', function() {
//       return false; // Don't submit form for this demo
//     });
//   });

console.log("llega el js");
$(document).on('submit', '#bodegaCreacion', function(event){
    event.preventDefault();

});

$(document).on('submit', '#proveedorCreacionForm', function(event){

    event.preventDefault();
    crearProveedores();

});

function crearBodega(){
    var data = new FormData($('#bodegaCreacion').get(0));

    $.ajax({
        type:"POST",
        url: "/bodega/crear",
        data: data,
        contentType: false,
        cache: false,
        processData:false,
        dataType:"json",
        success: function(data){


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log( jqXHR.responseJSON.message);
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: jqXHR.responseJSON.message
            })
        }
    })


}

function crearProveedores(){
    var data = new FormData($('#proveedorCreacionForm').get(0));

    $.ajax({
        type:"POST",
        url: "/proveedores/crear",
        data: data,
        contentType: false,
        cache: false,
        processData:false,
        dataType:"json",
        success: function(data){


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log( jqXHR.responseJSON.message);
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: jqXHR.responseJSON.message
            })
        }
    });
}
