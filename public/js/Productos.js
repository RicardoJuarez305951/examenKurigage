$(document).ready(function() {
    $('a.confirm-delete').on('click', function(e) {
        e.preventDefault(); 
        var confirmAction = confirm("¿Estás seguro de que deseas borrar este producto?");

        if (confirmAction) {
            window.location.href = $(this).attr('href');
        } else {
            alert("Acción cancelada.");
        }
    });
});

$(document).ready(function() {
    $('a.confirm-edit').on('click', function(e) {
        e.preventDefault(); 
        var confirmAction = confirm("¿Estás seguro de que deseas editar este producto?");

        if (confirmAction) {
            window.location.href = $(this).attr('href');
        } else {
            alert("Acción cancelada.");
        }
    });
});

$(document).ready(function() {
    $('a.confirm-return').on('click', function(e) {
        e.preventDefault(); 
        var confirmAction = confirm("¿Estás seguro de que quieres regresar?");

        if (confirmAction) {
            window.location.href = $(this).attr('href');
        }
    });
});

$(document).ready(function() {
    $('button.confirm-export').on('click', function(e) {
        e.preventDefault(); 
        var confirmAction = confirm("¿Estás seguro de que quieres exportar la tabla a Excel?");

        if (confirmAction) {
            window.location.href = $(this).attr('href');
        }
    });
});

