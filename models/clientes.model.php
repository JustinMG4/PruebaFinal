<?php
require_once('../config/conexion.php');

class Clientes
{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id_cliente, nombre, apellido, correo FROM clientes";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close(); 
    }

    public function uno($idCliente)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id_cliente, nombre, apellido, correo FROM clientes WHERE id_cliente = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $idCliente);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        
        return $datos;
    }

    public function insertar($nombre, $apellido, $correo)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO clientes (nombre, apellido, correo) VALUES (?, ?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('sss', $nombre, $apellido, $correo);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }

    public function actualizar($id, $nombre, $apellido, $correo)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE clientes SET nombre = ?, apellido = ?, correo = ? WHERE id_cliente = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('sssi', $nombre, $apellido, $correo, $id);
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
        $cadena = "DELETE FROM clientes WHERE id_cliente = ?";
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