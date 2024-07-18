<?php
require_once('../config/conexion.php');
class DetallesPedidos
{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT d.id_detalle, d.id_pedido, p.nombre_producto, p.precio, d.cantidad, d.total FROM detalles_pedido AS d JOIN productos AS p ON d.id_producto = p.id_producto";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close(); 
    }


    public function insertar($id_pedido, $id_producto, $cantidad, $total)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO detalles_pedido (id_pedido, id_producto, cantidad, total) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('iiid', $id_pedido, $id_producto, $cantidad, $total);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }
    
    
}