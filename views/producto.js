// Codigo para abrir modal de nuevo producto y editar prodcuto

const btnAbrirModalProducto = document.querySelector('#btn-abrir-modal-producto');
const btnCerrarModalProducto = document.querySelector('#btn-cerrar-modal-producto');
const modalProducto = document.querySelector('#modal_producto');

btnAbrirModalProducto.addEventListener('click', () => {
    modalProducto.showModal();
});

btnCerrarModalProducto.addEventListener('click', () => {
    modalProducto.close();
});

//Fin de codigo para abrir modal de nuevo producto y editar producto

//Backend de procucto
//Inicializacion
function init() {
    $("#frm_producto").on('submit', function(e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargarTabla();
});

//Cargar Tabla
var cargarTabla = () => {
    var html = '';

    $.get("../controllers/productos.controller.php?op=todos",(listaProductos) => {
        console.log(listaProductos);
        $.each(listaProductos, (i, prodcuto) => {
            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${prodcuto.nombre_producto}</td>
                    <td>${prodcuto.precio}</td>
                    <td class="flex gap-10">
                        <button class="" onclick="editar(${prodcuto.id_producto})">Editar</button>
                        <button class="" onclick="eliminar(${prodcuto.id_producto})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
        $("#cuerpoProducto").html(html);    
    });
};

//Guardar y Editar

var guardaryeditar = (e) => {
    e.preventDefault(); 
   
    var frm_producto = new FormData($("#frm_producto")[0]);

    var ProductoIdEdit = $("#id_producto").val(); 

    var ruta = "";
    if (ProductoIdEdit == 0) {
        console.log("Si llega");
        // Insertar
        ruta = '../controllers/productos.controller.php?op=insertar';
       
    } else {
        // Editar
        console.log("Si llega a edit");
        ruta = "../controllers/productos.controller.php?op=actualizar";
    }

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_producto,
        contentType: false,
        processData: false,
        
        success: function (datos) {
            console.log(datos);
            modalProducto.close();
            location.reload();
            cargarTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar o editar:", error);
        }
    });
};

//Editar
var editar = (productoId) => { 
    $.ajax({
        url: `../controllers/productos.controller.php?op=uno&id=${productoId}`,
        type: "GET",
        success: function (data) {
            $("#id_producto").val(data.id_producto); 
            $("#nombre").val(data.nombre_producto); 
            $("#precio").val(data.precio); 
            console.log(data.id_producto);
            console.log(data.nombre_producto);
            console.log(data.precio);
            modalProducto.showModal();
        },
        error: function () {
            
            Swal.fire({
                title: "Producto",
                text: "Error al intentar obtener los datos del producto", 
                icon: "error",

            });
        },
    });
};

//Eliminar
var eliminar = (productoId) => {
    Swal.fire({
        title: "Producto",
        text: "¿Estas seguro de eliminar el producto?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `../controllers/productos.controller.php?op=eliminar`,
                type: "POST",
                data: { id_producto: productoId },
                success: (resultado)=> {
                    var resultadoMessage = resultado;
                    console.log(resultadoMessage);
                   if(resultado === resultadoMessage) {
                          cargarTabla();
                       Swal.fire({
                            title: "Producto",
                            text: "Producto eliminado correctamente",
                            icon: "success",
                          });
                   }else{
                       Swal.fire({
                           title: "Producto",
                           text: "Error al intentar eliminar el producto",
                           icon: "error",
                       });
                   }
                },
                error: ()=> {
                    Swal.fire({
                        title: "Producto",
                        text: "Error al intentar eliminar el producto", 
                        icon: "error",
                    });
                },
            });
        }
    });
};

init();