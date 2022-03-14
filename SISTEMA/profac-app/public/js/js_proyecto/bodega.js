// $('#bodegaCreacion').submit(function(e){
    
//     e.preventDefault();
//     console.log('llego');
//     //crearBodega();
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


$(document).on('submit', '#bodegaCreacion', function(event){
       event.preventDefault();
    crearBodega();
    
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

            document.getElementById("bodegaCreacion").reset();
            Swal.fire({
                icon: 'success',
                title: 'Exito!',
                text: 'Exito al crear bodega.'
            })

            //console.log(data);
            

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log( jqXHR.responseJSON.message);
            Swal.fire({
                icon: 'warning',
                title: 'Error...',
                text: jqXHR.responseJSON.message
            })
        }
    })


}