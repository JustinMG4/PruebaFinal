<?php
require_once('../config/conexion.php');
class Tipo
{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id, tipo FROM tipos_habitaciones";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function insertar($tipo)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO tipos_habitaciones (tipo) VALUES (?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('s', $tipo);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }

    //obtener id de tipo de habitacion con el nombre
    public function obtenerId($tipo)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT id FROM tipos_habitaciones WHERE tipo = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('s', $tipo);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        return $datos;
    }

}