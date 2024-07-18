// Codigo para abrir modal de nuevo cliente y editar cliente
const btnAbrirModal = document.querySelector('#btn-abrir-modal');
const btnCerrarModal = document.querySelector('#btn-cerrar-modal');
const modal2 = document.querySelector('#modal');

btnAbrirModal.addEventListener('click', () => {
    modal2.showModal();
});

btnCerrarModal.addEventListener('click', () => {
    modal2.close();
});

//Fin de codigo para abrir modal de nuevo cliente y editar cliente

//Backend de cliente

//Inicializacion
function init() {
    $("#frm_cliente").on('submit', function(e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargarTabla();
});

//Cargar Tabla
var cargarTabla = () => {
    var html = '';

    $.get("../controllers/clientes.controller.php?op=todos",(listaClientes) => {
        console.log(listaClientes);
        $.each(listaClientes, (i, cliente) => {
            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${cliente.nombre}</td>
                    <td>${cliente.apellido}</td>
                    <td>${cliente.correo}</td>
                    <td class="flex gap-10">
                       <div class="botones-centrados">
                            <button class="boton-celda" onclick="editar(${cliente.id_cliente})">Editar</button>
                            <button class="boton-celda" onclick="eliminar(${cliente.id_cliente})">Eliminar</button>
                       </div>
                    </td>
                </tr>
            `;
        });
        $("#cuerpoClientes").html(html);    
    });
};

//Guardar y Editar

var guardaryeditar = (e) => {
    e.preventDefault(); 
   
    var frm_cliente = new FormData($("#frm_cliente")[0]);

    var ClienteIdEdit = $("#id_cliente").val(); 

    var ruta = "";
    if (ClienteIdEdit == 0) {
        console.log("Si llega");
        // Insertar
        ruta = '../controllers/clientes.controller.php?op=insertar';
       
    } else {
        // Editar
        ruta = "../controllers/clientes.controller.php?op=actualizar";
    }

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_cliente,
        contentType: false,
        processData: false,
        
        success: function (datos) {
            console.log(datos);
            modal2.close();
            location.reload();
            cargarTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar o editar:", error);
        }
    });
};

//Editar
var editar = (ClienteId) => { 
    $.ajax({
        url: `../controllers/clientes.controller.php?op=uno&id=${ClienteId}`,
        type: "GET",
        success: function (data) {
            $("#id_cliente").val(data.id_cliente); 
            $("#nombre").val(data.nombre); 
            $("#apellido").val(data.apellido); 
            $("#correo").val(data.correo);
            console.log(data.id_cliente);
            console.log(data.nombre);
            console.log(data.apellido);
            console.log(data.correo);
            modal2.showModal();
        },
        error: function () {
            
            Swal.fire({
                title: "Cliente",
                text: "Error al intentar obtener los datos del cliente", 
                icon: "error",

            });
        },
    });
};

//Eliminar
var eliminar = (ClienteId) => {
    Swal.fire({
        title: "Cliente",
        text: "¿Estas seguro de eliminar el cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `../controllers/clientes.controller.php?op=eliminar`,
                type: "POST",
                data: { id: ClienteId },
                success: (resultado)=> {
                    var resultadoMessage = resultado;
                    console.log(resultadoMessage);
                   if(resultado === resultadoMessage) {
                          cargarTabla();
                       Swal.fire({
                            title: "Cliente",
                            text: "Cliente eliminado correctamente",
                            icon: "success",
                          });
                   }else{
                       Swal.fire({
                           title: "Cliente",
                           text: "Error al intentar eliminar el cliente",
                           icon: "error",
                       });
                   }
                },
                error: ()=> {
                    Swal.fire({
                        title: "Cliente",
                        text: "Error al intentar eliminar el cliente", 
                        icon: "error",
                    });
                },
            });
        }
    });
};

init();