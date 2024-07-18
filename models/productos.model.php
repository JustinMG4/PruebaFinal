<?php
require_once('../config/conexion.php');

class Productos
{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id_producto, nombre_producto, precio FROM productos";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close(); 
    }

    public function uno($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id_producto, nombre_producto, precio FROM productos WHERE id_producto = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        
        return $datos;
    }

    public function insertar($nombre, $precio)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO productos (nombre_producto, precio) VALUES (?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('ss', $nombre, $precio);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }

    public function actualizar($id, $nombre, $precio)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE productos SET nombre_producto = ?, precio = ? WHERE id_producto = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('ssi', $nombre, $precio, $id);
        if ($stmt->execute()) {
            return $id;
        } else {
            return 'Error al actualizar:' . $stmt->error;
        }
        $con->close(); 
    }

    public function eliminar($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return $id;
        } else {
            return 'Error al eliminar:' . $stmt->error;
        }
    
        $con->close();
    }
}