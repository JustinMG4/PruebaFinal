// Codigo para abrir modal de nuevo cliente y editar cliente
const btnAbrirModal = document.querySelector('#btn-abrir-modal');
const btnCerrarModal = document.querySelector('#btn-cerrar-modal');
const modal2 = document.querySelector('#modal');

btnAbrirModal.addEventListener('click', () => {
    modal2.showModal();
});

btnCerrarModal.addEventListener('click', () => {
    modal2.close();
    $("#id_huesped").prop('readonly', false);
    $("#tipo_identificacion").prop('disabled', false);
    limpiar();
    flag = 0;
});

//Fin de codigo para abrir modal de nuevo cliente y editar cliente

//Backend de cliente



//Limpia el formulario
function limpiar() {
    $("#id_huesped").val("");
    $("#tipo_identificacion").val("");
    $("#nombre").val("");
    $("#apellido").val("");
    $("#email").val("");
    $("#telefono").val("");
}
//Inicializacion
function init() {
    $("#frm_huesped").on('submit', function(e) {
        guardaryeditar(e);
        
    });
}

$(document).ready(() => {
    cargarTabla();
});

//Cargar Tabla
var cargarTabla = () => {
    var html = '';

    $.get("../controllers/huesped.controller.php?op=todos",(listaHuesped) => {
        console.log(listaHuesped);
        $.each(listaHuesped, (i, huesped) => {
            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${huesped.id_huesped}</td>
                    <td>${huesped.tipo_identificacion}</td>
                    <td>${huesped.nombre}</td>
                    <td>${huesped.apellido}</td>
                    <td>${huesped.email}</td>
                    <td>${huesped.telefono}</td>
                    <td class="flex gap-10">
                       <div class="botones-centrados">
                            <button class="boton-celda" onclick="editar(${huesped.id_huesped})">Editar</button>
                            <button class="boton-celda" onclick="eliminar(${huesped.id_huesped})">Eliminar</button>
                       </div>
                    </td>
                </tr>
            `;
        });
        $("#cuerpoHuesped").html(html);    
    });
};

//Guardar y Editar
var flag = 0;
var guardaryeditar = (e) => {
    e.preventDefault(); 
   
    var frm_huesped = new FormData($("#frm_huesped")[0]);

    var ruta = "";
    if (flag == 0) {
        console.log("Si llega");
        // Insertar
        ruta = '../controllers/huesped.controller.php?op=insertar';
       
    } else {
        // Editar
        console.log("llega a editar");
        ruta = "../controllers/huesped.controller.php?op=actualizar";
        flag = 0;
    }

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_huesped,
        contentType: false,
        processData: false,
        
        success: function (datos) {
            console.log(datos);
            modal2.close();
            limpiar();
            $("#id_huesped").prop('readonly', false);
            $("#tipo_identificacion").prop('disabled', false);
            cargarTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar o editar:", error);
        }
    });
};

//Editar
var editar = (huespedId) => { 
    flag = 1;
    $.ajax({
        url: `../controllers/huesped.controller.php?op=uno&id=${huespedId}`,
        type: "GET",
        success: function (data) {
            $("#id_huesped").val(data.id_huesped);
            $("#tipo_identificacion").val(data.tipo_identificacion); 
            $("#nombre").val(data.nombre); 
            $("#apellido").val(data.apellido); 
            $("#email").val(data.email);
            $("#telefono").val(data.telefono);
            console.log(data.id_huesped);
            console.log(data.tipo_identificacion);
            console.log(data.nombre);
            console.log(data.apellido);
            console.log(data.email);
            console.log(data.telefono);
            modal2.showModal();
            $("#id_huesped").prop('readonly', true);
            $("#tipo_identificacion").prop('disabled', true);
        },
        error: function () {
            
            Swal.fire({
                title: "Huesped",
                text: "Error al intentar obtener los datos del huesped", 
                icon: "error",

            });
        },
    });
};

//Eliminar
var eliminar = (huespedId) => {
    Swal.fire({
        title: "Huesped",
        text: "¿Estas seguro de eliminar el Huesped?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `../controllers/huesped.controller.php?op=eliminar`,
                type: "POST",
                data: { id: huespedId },
                success: (resultado)=> {
                    var resultadoMessage = resultado;
                    console.log(resultadoMessage);
                   if(resultado === resultadoMessage) {
                          cargarTabla();
                       Swal.fire({
                            title: "Huesped",
                            text: "Huesped eliminado correctamente",
                            icon: "success",
                          });
                   }else{
                       Swal.fire({
                           title: "Huesped",
                           text: "Error al intentar eliminar el huesped",
                           icon: "error",
                       });
                   }
                },
                error: ()=> {
                    Swal.fire({
                        title: "Huesped",
                        text: "Error al intentar eliminar el huesped", 
                        icon: "error",
                    });
                },
            });
        }
    });
};

init();