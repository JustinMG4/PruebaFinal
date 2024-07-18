<?php
require_once('../config/conexion.php');
class DetalleReserva
{
     public function detalle($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT D.id_reservacion, H.numero, T.tipo, H.precio, D.subtotal FROM detalle_reservaciones AS D JOIN habitaciones AS H ON D.id_habitacion = H.id_habitacion JOIN reservaciones AS R ON D.id_reservacion = R.id_reservacion JOIN tipos_habitaciones AS T ON H.id_tipo = T.id WHERE D.id_reservacion = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $DetalleReserva = [];
        while ($fila = $resultado->fetch_assoc()) {
            $DetalleReserva[] = $fila;
        }
        $con->close();
        return $DetalleReserva;
    }


    public function insertar($id_reservacion, $id_habitacion, $subtotal)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO detalle_reservaciones (id_reservacion, id_habitacion, subtotal) VALUES (?, ?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('iid', $id_reservacion, $id_habitacion, $subtotal);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }
    
    
}