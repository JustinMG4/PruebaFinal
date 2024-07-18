<?php
require_once('../config/conexion.php');
class Direccion
{
    public function insertar($id_cliente, $direccion)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO direcciones (id_cliente, direccion) VALUES (?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('is', $id_cliente, $direccion);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }

}