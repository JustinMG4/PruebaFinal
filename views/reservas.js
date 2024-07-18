

// Codigo para abrir modal de nuevo pago y editar pago
const btnAbrirModalRes = document.querySelector('#btn-abrir-modal-res');
const btnCerrarModalRes = document.querySelector('#btn-cerrar-modal-res');
const modalReserva = document.querySelector('#modal_res');
const inputFechaEntrada = document.querySelector('#fecha_entrada');
const inputFechaSalida = document.querySelector('#fecha_salida');
const tablaLista = document.querySelector('#tabla_lista');
const btnCerrarModalDetalle = document.querySelector('#btn-cerrar-modal-D');
const modalDetalle = document.querySelector('#modal_detalle');


btnCerrarModalDetalle.addEventListener('click', () => {
    modalDetalle.close();
    location.reload();
} );



tablaLista.style.display = 'none';

function verificarYMostrarTabla() {
    if (inputFechaEntrada.value && inputFechaSalida.value) {
        tablaLista.style.display = 'block'; // Muestra la tabla
    } else {
        tablaLista.style.display = 'none'; // Sigue escondiendo la tabla
    }
}

// Inicialmente deshabilitar fecha_salida
inputFechaSalida.disabled = true;

btnAbrirModalRes.addEventListener('click', () => {
    const ahora = new Date();
    let mes = ahora.getMonth() + 1;
    let dia = ahora.getDate();

    mes = mes < 10 ? '0' + mes : mes;
    dia = dia < 10 ? '0' + dia : dia;

    const fechaMinima = `${ahora.getFullYear()}-${mes}-${dia}`;

    inputFechaEntrada.setAttribute('min', fechaMinima);

    modalReserva.showModal();
});

btnCerrarModalRes.addEventListener('click', () => {
    limpiarCampos();
    location.reload();
    modalReserva.close();
});

inputFechaEntrada.addEventListener('change', () => {
    if (inputFechaEntrada.value) {
        inputFechaSalida.disabled = false;
        inputFechaSalida.setAttribute('min', inputFechaEntrada.value);
        if (inputFechaSalida.value) {
            cargarTablaHabitaciones();
        }
    } else {
        inputFechaSalida.disabled = true;
    }
    verificarYMostrarTabla();
});

inputFechaSalida.addEventListener('change', () => {
    verificarYMostrarTabla();
    if (inputFechaEntrada.value) {
        cargarTablaHabitaciones();
    }
});

function limpiarCampos() {
    $("#id_huesped").val("");
    inputFechaEntrada.value = '';
    inputFechaSalida.value = '';
    tablaLista.style.display = 'none';
    $("#total").val('0');
    //limpiar el array
    habitacionesSeleccionadas = [];
    console.log("Habitaciones seleccionadas:", habitacionesSeleccionadas);

}

var habitacionesSeleccionadas = [];
var totalSubtotal = 0; // Variable para almacenar la suma total del subtotal

var cargarTablaHabitaciones = () => {
    if (!inputFechaEntrada.value || !inputFechaSalida.value) {
        alert("Por favor, selecciona las fechas de entrada y salida.");
        return;
    }

    var datos = {
        fechaInicio: inputFechaEntrada.value,
        fechaFin: inputFechaSalida.value
    };
    var fechaInicioDate = new Date(datos.fechaInicio);
    var fechaFinDate = new Date(datos.fechaFin);

    var diferenciaMilisegundos = fechaFinDate.getTime() - fechaInicioDate.getTime();
    var diferenciaDias = diferenciaMilisegundos / (1000 * 3600 * 24);
    var cantidadDias = Math.round(diferenciaDias);
    console.log("Cantidad de días:", cantidadDias);

    console.log("Datos enviados:", datos);

    $.ajax({
        url: '../controllers/habitacion.controller.php?op=habitacionesDisponibles', 
        type: 'POST',
        data: datos,
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            $("#cuerpoLista").empty();
            response.forEach(habitacion => {
                console.log("Habitación:", habitacion);
                var subtotal = cantidadDias * habitacion.precio;
                var fila = `<tr>
                                <td>${habitacion.numero}</td>
                                <td>${habitacion.tipo}</td>
                                <td>${habitacion.precio}</td>
                                <td>${subtotal}</td>
                                <td>
                                    <button type="button" class="btn-seleccionar" data-id="${habitacion.id_habitacion}" data-subtotal="${subtotal}" style="display:inline-block;">Seleccionar</button>
                                    <button type="button" class="btn-cancelar" data-id="${habitacion.id_habitacion}" style="display:none;">Cancelar</button>
                                </td>
                            </tr>`;
                $("#cuerpoLista").append(fila);
            });

            // Evento para el botón "Seleccionar"
            $(document).on('click', '.btn-seleccionar', function() {
                var id_habitacion = $(this).data('id');
                var subtotal = $(this).data('subtotal');
                habitacionesSeleccionadas.push({ id_habitacion, subtotal });
                totalSubtotal += subtotal; // Actualizar el total del subtotal
                console.log("Habitaciones seleccionadas:", habitacionesSeleccionadas);
                console.log("Total del subtotal:", totalSubtotal);
                $("#total").val(totalSubtotal);
                $(this).hide();
                $(this).siblings('.btn-cancelar').show();
                actualizarTotalSubtotal(); // Llamar a la función para actualizar el total en el DOM
            });

            // Evento para el botón "Cancelar"
            $(document).on('click', '.btn-cancelar', function() {
                var id_habitacion = $(this).data('id');
                var habitacion = habitacionesSeleccionadas.find(h => h.id_habitacion === id_habitacion);
                totalSubtotal -= habitacion.subtotal; // Actualizar el total del subtotal
                habitacionesSeleccionadas = habitacionesSeleccionadas.filter(h => h.id_habitacion !== id_habitacion);
                console.log("Habitaciones seleccionadas después de cancelar:", habitacionesSeleccionadas);
                console.log("Total del subtotal después de cancelar:", totalSubtotal);
                $("#total").val(totalSubtotal);
                $(this).hide();
                $(this).siblings('.btn-seleccionar').show();
                actualizarTotalSubtotal(); // Llamar a la función para actualizar el total en el DOM
            });
        },
        error: function() {
            alert("Error al cargar las habitaciones disponibles.");
        }
    });
};

function actualizarTotalSubtotal() {
    $("#totalSubtotal").text(`Total: ${totalSubtotal.toFixed(2)}`);
}


$(document).ready(() => {
    cargarTabla();
});

var cargarTabla = () => {
    var html = '';

    $.get("../controllers/reserva.controller.php?op=todos", (listaReserva) => {
        console.log(listaReserva);
        $.each(listaReserva, (i, reserva) => {
            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${reserva.apellido}</td>
                    <td>${reserva.fecha_entrada}</td>
                    <td>${reserva.fecha_salida}</td>
                    <td>${reserva.total}</td>
                    <td class="flex gap-10">
                        <div class="botones-centrados">
                            <button class="boton-celda" onclick="ver(${reserva.id_reservacion})">Ver</button>
                            <button class="boton-celda" onclick="eliminar(${reserva.id_reservacion})">Eliminar</button>
                        </div>
                    </td>
                </tr>
            `;
        });
        $("#cuerpoReserva").html(html);
    });
};
function init() {
    $("#frm_reserva").on('submit', function(e) {
        guardar(e);
        
    });
    
}

var ver = (idReserva) => {
    $.ajax({
        url: `../controllers/reserva.controller.php?op=uno&id=${idReserva}`,
        type: "GET",
        success: function (data) {
            $("#id_huespede").val(data.id_huesped); 
            $("#nombre").val(data.apellido);
            $("#entrada").val(data.fecha_entrada);
            $("#salida").val(data.fecha_salida);
            $("#totalD").val(data.total); 
           console.log(data.id_huesped);
            console.log(data.apellido);
            console.log(data.fecha_entrada);
            console.log(data.fecha_salida);
            console.log(data.total);
        },
        error: function () {
            
            Swal.fire({
                title: "Huesped",
                text: "Error al intentar obtener los datos del huesped", 
                icon: "error",

            });
        },
    });
    // Realizar una solicitud AJAX para obtener los detalles de la reservación
    $.ajax({
        url: '../controllers/detallereserva.controller.php?op=detalle', // URL del controlador para obtener los detalles
        type: 'POST',
        data: { id: idReserva },
        success: function(response) {
            // No necesitas parsear si la respuesta ya es un objeto
            if (typeof response === 'object') {
                var detalles = response;
            } else {
                try {
                    var detalles = JSON.parse(response);
                } catch (e) {
                    console.error("Error al parsear la respuesta JSON:", e);
                    alert("Error al cargar los detalles de la reservación.");
                    return;
                }
            }

            // Limpiar el contenido anterior del modal
            $('#cuerpoDetalle').empty();

            // Mostrar los detalles en el modal
            detalles.forEach(detalle => {
                var fila = `<tr>
                                <td>${detalle.numero}</td>
                                <td>${detalle.tipo}</td>
                                <td>${detalle.precio}</td>
                                <td>${detalle.subtotal}</td>
                            </tr>`;
                $('#cuerpoDetalle').append(fila); // Corrige el ID del elemento
            });

            // Abrir el modal
            modalDetalle.style.display = 'block';
        },
        error: function() {
            alert("Error al cargar los detalles de la reservación.");
        }
    });


};


function guardar(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    // Recoger los valores del formulario
    var id_huesped = $('#id_huesped').val();
    var totalReserva = totalSubtotal;
    var fecha_entrada = $('#fecha_entrada').val();
    var fecha_salida = $('#fecha_salida').val();
    
    // Datos a enviar
    var datos = {
        id_huesped: id_huesped,
        total: totalReserva,
        fecha_entrada: fecha_entrada,
        fecha_salida: fecha_salida,
    };

    console.log('Datos a enviar:', datos);
    // Enviar datos al servidor mediante AJAX
    $.ajax({
        url: '../controllers/reserva.controller.php?op=insertar', // La URL del servidor donde se enviarán los datos
        type: 'POST', // Método HTTP utilizado para la solicitud
        data: datos, // Los datos que se enviarán al servidor
        
        success: function(response) {
            // Manejar la respuesta del servidor
            console.log(response);
            guardarDetalleReserva(); // Llamar a guardarDetalleReserva después de insertar la reserva
            cargarTabla();
            location.reload();
            modalReserva.close();
            alert('Reserva agendada con éxito');
        },
        error: function(xhr, status) {
            // Manejar errores de la solicitud
            console.error('Error al agendar la reserva:', status);
        }
    });
}

function guardarDetalleReserva() {
    // Asumiendo que ultimaReserva() es una función asíncrona que devuelve el id de la última reserva
    ultimaReserva().then(id_reserva => {
        console.log('ID de reserva obtenido:', id_reserva);

        for (const habitacionesSe of habitacionesSeleccionadas) {
            console.log('Habitación seleccionada:', id_reserva, habitacionesSe.id_habitacion, habitacionesSe.subtotal);
            // Aquí iría el código para guardar los detalles de la reserva, posiblemente otra llamada AJAX
            $.ajax({
                url: '../controllers/detallereserva.controller.php?op=insertar',
                type: 'POST',
                data: {
                    id_reservacion: id_reserva,
                    id_habitacion: habitacionesSe.id_habitacion,
                    subtotal: habitacionesSe.subtotal
                },
                success: function(response) {
                    console.log('Detalle de reserva guardado:', response);
                    // Cualquier otra lógica necesaria después de guardar el detalle de la reserva
                },
                error: function() {
                    console.error('Error al guardar el detalle de la reserva');
                }
            });
        }
    }).catch(error => {
        console.error('Error al obtener el ID de la última reserva o al guardar detalles:', error);
    });
}

function ultimaReserva() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../controllers/reserva.controller.php?op=ultimo',
            type: 'GET',
            success: function(response) {
                resolve(response); // Resolver la promesa con la respuesta del servidor
            },
            error: function() {
                reject('Error al obtener el último id_pedido'); // Rechazar la promesa en caso de error
            }
        });
    });
}

var eliminar = (idReserva) => {
    console.log(idReserva);
    Swal.fire({
        title: "Reservacion",
        text: "¿Estas seguro de eliminar la reservacion?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `../controllers/reserva.controller.php?op=eliminar`,
                type: "POST",
                data: { id_reservacion: idReserva },
                success: (resultado)=> {
                    var resultadoMessage = resultado;
                    console.log(resultadoMessage);
                   if(resultado === resultadoMessage) {
                          cargarTabla();
                       Swal.fire({
                            title: "Reservacion",
                            text: "Reservacion eliminada correctamente",
                            icon: "success",
                          });
                   }else{
                       Swal.fire({
                           title: "Reservacion",
                           text: "Error al intentar eliminar la reservacion",
                           icon: "error",
                       });
                   }
                },
                error: ()=> {
                    Swal.fire({
                        title: "Reservacion",
                        text: "Error externo", 
                        icon: "error",
                    });
                },
            });
        }
    });
};

$(document).ready(function() {
    cargarTabla();
});


init();
