$(document).ready(function () {
    $('#curp').on('input', function() {
        console.log('Input detectado:', $(this).val());
        if ($(this).val().trim().length !== 18) {
            console.log('error')
            $('#btn-registrar').prop('disabled', true);
            $('#curp-validada').val(0);
        }
    });


$('#validarCurp').click(()=>{
    validarCurp();
})



function validarCurp() {
    const curp = $('#curp').val().trim().toUpperCase();
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const btnRegistrar = $('#btn-registrar');

    btnRegistrar.prop('disabled', true);
    $('#curp-validada').val(0);

    $('#spinner-container').removeClass('d-none');

    // Validación de longitud de CURP
    if (curp.length !== 18) {
        Swal.fire('CURP inválida', 'El CURP debe tener 18 caracteres.', 'warning');
        return;
    }

    // Enviar la solicitud AJAX
    $.ajax({
        url: "/validar-curp",  // Ruta correcta del backend
        type: "POST",
        data: JSON.stringify({ curp: curp }),  // Asegúrate de que solo se envíe el JSON
        contentType: "application/json",  // Importante: esto le dice al backend que los datos son JSON
        headers: {
            "X-CSRF-TOKEN": csrfToken  // Asegúrate de que el token CSRF sea correcto
        },
        success: function(data) {

            $('#spinner-container').addClass('d-none');

            if (data.error) {
                Swal.fire('CURP registrada', data.error, 'error');
            } else if (data.nombres) {
                // Si la CURP es válida, completar los campos y habilitar el botón
                const nombreCompleto = `${data.nombres} ${data.primer_apellido} ${data.segundo_apellido}`;
                $('#name').val(nombreCompleto);
                $('#curp-validada').val(1);
                btnRegistrar.prop('disabled', false);

                Swal.fire('CURP válida', 'Datos cargados automáticamente.', 'success');
            }
        },
        error: function(xhr, status, error) {

            $('#spinner-container').addClass('d-none');

            Swal.fire({
                icon: 'error',  // Tipo de icono
                title: '¡Error de validación!',
                html: 'Ocurrió un error al validar la CURP: <br> <strong>' + (xhr.responseJSON.message || 'Por favor, intente nuevamente más tarde.' + '</strong>'),
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33',
                showCloseButton: true,
                padding: '2em',
            });
        }
    });
}




});




