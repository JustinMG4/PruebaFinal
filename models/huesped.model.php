<?php
require_once('../config/conexion.php');

class Huesped
{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id_huesped, tipo_identificacion, nombre, apellido, email, telefono FROM huespedes";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close(); 
    }

    public function uno($idHuesped)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id_huesped, tipo_identificacion ,nombre, apellido, email, telefono FROM huespedes WHERE id_huesped = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $idHuesped);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        return $datos;
    }

    public function insertar($idHuesped, $tipo_identificacion, $nombre, $apellido, $email, $telefono)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO huespedes (id_huesped, tipo_identificacion, nombre, apellido, email, telefono) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('ssssss', $idHuesped ,$tipo_identificacion, $nombre, $apellido, $email, $telefono);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }

    public function actualizar($id,$nombre, $apellido, $email, $telefono)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE huespedes SET nombre = ?, apellido = ?, email = ?, telefono = ? WHERE id_huesped = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('sssss', $nombre, $apellido, $email, $telefono , $id);
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
        $cadena = "DELETE FROM huespedes WHERE id_huesped = ?";
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