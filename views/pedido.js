// Codigo para abrir modal de nuevo pedido y editar pedido

const btnAbrirModalPedido = document.querySelector('#btn-abrir-modal-pedido');
const btnCerrarModalPedido = document.querySelector('#btn-cerrar-modal-pedido');
const modalPedido = document.querySelector('#modal_pedido');


const btnCerrarModalDetallePedido = document.querySelector('#btn-cerrar-modal-detallepedido');
const modalDetallePedido = document.querySelector('#modal_detallepedido');

btnAbrirModalPedido.addEventListener('click', () => {
    //cargar la tabla de productos en el modal
    cargarTablaProductos();
    modalPedido.showModal();
}
);

btnCerrarModalPedido.addEventListener('click', () => {
    modalPedido.close();
}
);

btnCerrarModalDetallePedido.addEventListener('click', () => {
    modalDetallePedido.close();
}
);


//Fin de codigo para abrir modal de nuevo pedido y editar pedido

//Backend de modal pedido

function actualizarTotal(index, precio) {
    var cantidad = parseInt(document.getElementById('cantidad-' + index).innerText);
    var total = cantidad * precio;
    document.getElementById('total-' + index).innerText = total.toFixed(2); // Asumiendo que el precio es un número flotante
}

function reducirCantidad(index, precio) {
    var cantidad = parseInt(document.getElementById('cantidad-' + index).innerText);
    if (cantidad > 1) { // Asegura que la cantidad no sea menor que 1
        document.getElementById('cantidad-' + index).innerText = cantidad - 1;
        actualizarTotal(index, precio);
    }
}

function incrementarCantidad(index, precio) {
    var cantidad = parseInt(document.getElementById('cantidad-' + index).innerText);
    document.getElementById('cantidad-' + index).innerText = cantidad + 1;
    actualizarTotal(index, precio);
}

var productosSeleccionados = []; // Paso 6: Definir el array fuera de la función para almacenar los productos seleccionados
function limpiarProductosSeleccionados() {
    productosSeleccionados = []; // Limpiar el array
    // Aquí puedes agregar cualquier código necesario para actualizar la UI
    console.log('Productos seleccionados limpiados');
}
function imprimirProductosSeleccionados() {
    var sumaTotal = calcularSumaTotalProductosSeleccionados();
    console.log("Productos seleccionados:", productosSeleccionados);
    console.log("Total:", sumaTotal);
}

function calcularSumaTotalProductosSeleccionados() {
    return productosSeleccionados.reduce((acumulador, productoActual) => {
        return acumulador + parseFloat(productoActual.total);
    }, 0);
}

var cargarTablaProductos = () => {
    var html = '';

    $.get("../controllers/productos.controller.php?op=todos", (listaProductos) => {
        console.log(listaProductos);
        $.each(listaProductos, (i, producto) => {
            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${producto.nombre_producto}</td>
                    <td>${producto.precio}</td>
                    <td>
                        <button onclick="reducirCantidad(${i}, ${producto.precio})">-</button>
                        <span id="cantidad-${i}">1</span>
                        <button onclick="incrementarCantidad(${i}, ${producto.precio})">+</button>
                    </td>
                    <td id="total-${i}">${producto.precio}</td>
                    <td class="flex gap-10">
                        <button type="button" data-id-producto="${producto.id_producto}" onclick="seleccionarProducto(this)">Seleccionar</button>
                        <button type="button"style="display:none;" data-id-producto="${producto.id_producto}" onclick="cancelarSeleccionProducto(this)">Cancelar</button>
                    </td>
                </tr>
            `;
        });
        $("#tbProductos").html(html);    
    });
};

function seleccionarProducto(btn) {
    var idProducto = $(btn).data('id-producto');
    var fila = $(btn).closest('tr');
    var cantidad = fila.find('span[id^="cantidad-"]').text();
    var total = fila.find('td[id^="total-"]').text();
    fila.find('button[onclick^="reducirCantidad"], button[onclick^="incrementarCantidad"]').hide();

    var productoSeleccionado = {
        idProducto: idProducto,
        cantidad: cantidad,
        total: total
    };

    productosSeleccionados.push(productoSeleccionado);
    imprimirProductosSeleccionados();

    $(btn).hide(); // Oculta el botón "Seleccionar"
    $(btn).next().show(); // Muestra el botón "Cancelar"
}

function cancelarSeleccionProducto(btn) {
    var fila = $(btn).closest('tr');
    var idProducto = $(btn).data('id-producto');
    fila.find('button[onclick^="reducirCantidad"], button[onclick^="incrementarCantidad"]').show();
    productosSeleccionados = productosSeleccionados.filter(p => p.idProducto != idProducto); // Elimina el producto del array
    imprimirProductosSeleccionados();

    $(btn).hide(); // Oculta el botón "Cancelar"
    $(btn).prev().show(); // Muestra el botón "Seleccionar"
}

//backend pedido

function init() {
    $("#frm_pedido").on('submit', function(e) {
        guardar(e);
        guardarDetallePedido(e);
    });
    
}

$(document).ready(() => {
    cargarTabla();
});

//Cargar Tabla de pedidos
var cargarTabla = () => {
    var html = '';

    $.get("../controllers/pedidos.controller.php?op=todos",(listaPedidos) => {
        console.log(listaPedidos);
        $.each(listaPedidos, (i, pedido) => { //SELECT p.id_pedido, c.apellido,d.direccion, p.fecha_pedido, p.total
            html += `
                <tr>
                
                    <td>${i + 1}</td>
                    <td>${pedido.id_pedido}</td>
                    <td>${pedido.apellido_cliente}</td>
                    <td>${pedido.direccion}</td>
                    <td>${pedido.fecha}</td>
                    <td>${pedido.total}</td>
                    <td>${pedido.estado}</td>
                    <td class="flex gap-10">
                        <button class="" onclick="Ver(${pedido.id_pedido})">Ver</button>
                        <button class="" onclick="eliminar(${pedido.id_pedido})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
        $("#cuerpoPedido").html(html);    
    });
};

function guardar(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    // Recoger los valores del formulario
    var idCliente = $('#cliente').val();
    var totalProductos = calcularSumaTotalProductosSeleccionados();
    

    // Datos a enviar
    var datos = {
        id_cliente: idCliente,
        total: totalProductos
    };

    // Enviar datos al servidor mediante AJAX
    $.ajax({
        url: '../controllers/pedidos.controller.php?op=insertar', // La URL del servidor donde se enviarán los datos
        type: 'POST', // Método HTTP utilizado para la solicitud
        data: datos, // Los datos que se enviarán al servidor
        success: function(response) {
            // Manejar la respuesta del servidor
            console.log(response);
            console.log(ultimoIdPedido());
            cargarTabla();
            modalPedido.close();
            location.reload();
            alert('Pedido guardado con éxito');
        },
        error: function(xhr, status) {
            // Manejar errores de la solicitud
            console.error('Error al guardar el pedido:', status);
        }
    });

}

function guardarDetallePedido(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    (async () => {
        try {
            var id_pedido = await ultimoIdPedido(); // Obtener el id_pedido una sola vez
            for (const productoSe of productosSeleccionados) {
                $.ajax({
                    url: '../controllers/detallepedidos.controller.php?op=insertar',
                    type: 'POST',
                    data: {
                        id_pedido: id_pedido, // Usar el mismo id_pedido para cada producto
                        id_producto: productoSe.idProducto,
                        cantidad: productoSe.cantidad,
                        total: productoSe.total
                    },
                    success: function(response) {
                        console.log('Detalle insertado', response);
                        console.log('Pedido:', id_pedido, 'Producto:', productoSe.idProducto, 'Cantidad:', productoSe.cantidad, 'Total:', productoSe.total);
                    },
                    error: function() {
                        console.log('Error al insertar detalle');
                    }
                });
            }

            limpiarProductosSeleccionados(); // Limpiar los productos seleccionados
            modalPedido.close(); // Cerrar el modal
        } catch (error) {
            console.log('Error al obtener el último ID de pedido', error);
        }
    })();
}

function ultimoIdPedido() {
        var id_pedido = null;
        $.ajax({
            url: '../controllers/pedidos.controller.php?op=ultimo',
            type: 'GET',
            async: false,
            success: function(response) {
                id_pedido = response;
            },
            error: function() {
                console.log('Error al obtener el último id_pedido');
            }
        });
        return id_pedido;

}

var eliminar = (pedidoId) => {
    Swal.fire({
        title: "Pedido",
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
                url: `../controllers/pedidos.controller.php?op=eliminar`,
                type: "POST",
                data: { id_pedido: pedidoId },
                success: (resultado)=> {
                    var resultadoMessage = resultado;
                    console.log(resultadoMessage);
                   if(resultado === resultadoMessage) {
                          cargarTabla();
                       Swal.fire({
                            title: "Pedido",
                            text: "Pedido eliminado correctamente",
                            icon: "success",
                          });
                   }else{
                       Swal.fire({
                           title: "Pedido",
                           text: "Error al intentar eliminar el pedido",
                           icon: "error",
                       });
                   }
                },
                error: ()=> {
                    Swal.fire({
                        title: "Pedido",
                        text: "Error al intentar eliminar el pedido", 
                        icon: "error",
                    });
                },
            });
        }
    });
};


init();
