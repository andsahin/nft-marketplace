"use strict"; 
function formReset(id) { 
    document.getElementById(id).reset();
}


"use strict";
function sweetAlert(icon, title) { 
    Swal.fire({
        title: title,
        position: 'top-end', 
        icon:  icon,
        width: 400,
        height: 100,
        timer: 1500,
        showConfirmButton: false,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutRight'
        }
    })
}



