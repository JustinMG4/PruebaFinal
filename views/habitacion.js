// Codigo para abrir modal de nuevo producto y editar prodcuto



const btnAbrirModalProducto = document.querySelector('#btn-abrir-modal-h');
const btnCerrarModalProducto = document.querySelector('#btn-cerrar-modal-h');
const modalHabitacion = document.querySelector('#modal_hab');

btnAbrirModalProducto.addEventListener('click', () => {
    modalHabitacion.showModal();
    cargarTipos();
});

btnCerrarModalProducto.addEventListener('click', () => {
    $("#numero").prop('readonly', false); 
    limpiar();
    modalHabitacion.close();
});

//Fin de codigo para abrir modal de nuevo producto y editar producto

//Backend de procucto
//Inicializacion
function init() {
    $("#frm_habitacion").on('submit', function(e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargarTabla();
});

//Cargar tipos de habitacion

var cargarTipos = () => {
    $.get("../controllers/tipohabitacion.controller.php?op=todos", (tipos) => {
      var selectTipo = $("#tipo");
      selectTipo.empty();
      //carga una opcion en el select
      
      $.each(tipos, (index, tipohab) => {
        selectTipo.append(
          `<option value='${tipohab.id}'>${tipohab.tipo}</option>`
        );
      });
    });
  };

//Cargar Tabla
var cargarTabla = () => {
    var html = '';

    $.get("../controllers/habitacion.controller.php?op=todos",(listaHabitacion) => {
        console.log(listaHabitacion);
        $.each(listaHabitacion, (i, habitacion) => {
            html += `
                <tr>
                    <td>${habitacion.numero}</td>
                    <td>${habitacion.tipo}</td>
                    <td>${habitacion.precio}</td>
                    <td>${habitacion.estado}</td>
                    <td class="flex gap-10">
                        <div class="botones-centrados">
                            <button class="boton-celda" onclick="editar(${habitacion.id_habitacion})">Editar</button>
                            <button class="boton-celda" onclick="eliminar(${habitacion.id_habitacion})">Eliminar</button>
                        </div>
                    </td>
                </tr>
            `;
        });
        $("#cuerpoHabitacion").html(html);    
    });
};

function limpiar() {
    $("#id_habitacion").val("");
    $("#numero").val("");
    $("#tipo").val("");
    $("#precio").val("");
}
//Guardar y Editar

var guardaryeditar = (e) => {
    e.preventDefault();

    var frm_habitacion = new FormData($("#frm_habitacion")[0]);
    var habitacionIdEdit = $("#id_habitacion").val();
    var numeroHabitacion = $("#numero").val(); // Asumiendo que el campo del número de habitación tiene este ID

    var ruta = "";
    if(habitacionIdEdit==0){
        //insertar
        ruta = "../controllers/habitacion.controller.php?op=insertar";
        //imprimir valores del formulario
        for (let [key, value] of frm_habitacion.entries()) {
            console.log(key, value);
        }
        $.ajax({
            url: "../controllers/habitacion.controller.php?op=numeroExistente",
            type: "POST",
            data: { numero: numeroHabitacion },
            dataType: "json",
            success: function (existe) {
                if (existe) {
                    // Si el número de habitación ya existe, mostrar alerta
                    modalHabitacion.close();
                    swal.fire({
                        icon: 'error',
                        title: 'Número de habitación existente',
                        text: 'El número de habitación ya está registrado. Por favor, elija otro número.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            modalHabitacion.showModal();
                        }
                    });
                } else {
                  
                    $.ajax({
                        url: ruta,
                        type: "POST",
                        data: frm_habitacion,
                        contentType: false,
                        processData: false,
                        
                        success: function (datos) {
                            console.log(datos);
                            modalHabitacion.close();
                            limpiar();
                            location.reload();
                            cargarTabla();
                        },
                        error: function (xhr, status, error) {
                            console.error("Error al guardar:", error);
                        }
                    });
    
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al verificar el número de habitación:", error);
            }
        });
      } else {
        //actualziar
        ruta = "../controllers/habitacion.controller.php?op=actualizar";
        $.ajax({
            url: ruta,
            type: "POST",
            data: frm_habitacion,
            contentType: false,
            processData: false,
            
            success: function (datos) {
                console.log(datos);
                $("#numero").prop('readonly', false); 
                modalHabitacion.close();
                limpiar();
                location.reload();
                cargarTabla();
            },
            error: function (xhr, status, error) {
                console.error("Error al editar:", error);
            }
        });
    }
    // Primero, verificar si el número de habitación ya existe
   
};

//Editar
var editar = async (habitacionId) => { 
    await cargarTipos();
    $.ajax({
        url: `../controllers/habitacion.controller.php?op=uno&id=${habitacionId}`,
        type: "GET",
        success: function (data) {
            $("#id_habitacion").val(data.id_habitacion);
            $("#numero").val(data.numero);
            $("#tipo").val(data.tipo);
            $("#precio").val(data.precio); 
            $("#numero").prop('readonly', true); 
            console.log(data.id_habitacion);
            console.log(data.numero);
            console.log(data.tipo);
            console.log(data.precio);
            modalHabitacion.showModal();
        },
        error: function () {
            
            Swal.fire({
                title: "Habitacion",
                text: "Error al intentar obtener los datos de la habitacion", 
                icon: "error",

            });
        },
    });
};

//Eliminar
var eliminar = (habitacionId) => {
    Swal.fire({
        title: "Habitacion",
        text: "¿Estas seguro de eliminar la habitacion?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `../controllers/habitacion.controller.php?op=eliminar`,
                type: "POST",
                data: { id_habitacion: habitacionId },
                success: (resultado)=> {
                    var resultadoMessage = resultado;
                    console.log(resultadoMessage);
                   if(resultado === resultadoMessage) {
                          cargarTabla();
                       Swal.fire({
                            title: "Habitacion",
                            text: "Habitacion eliminada correctamente",
                            icon: "success",
                          });
                   }else{
                       Swal.fire({
                           title: "Habitacion",
                           text: "Error al intentar eliminar la habitacion",
                           icon: "error",
                       });
                   }
                },
                error: ()=> {
                    Swal.fire({
                        title: "Habitacion",
                        text: "Error al intentar eliminar la habitacion", 
                        icon: "error",
                    });
                },
            });
        }
    });
};

init();