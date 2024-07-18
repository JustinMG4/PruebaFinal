<?php
require_once('../config/conexion.php');

class Reserva{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT R.id_reservacion, H.apellido, R.fecha_entrada, R.fecha_salida, R.total FROM reservaciones AS R JOIN huespedes AS H ON R.id_huesped = H.id_huesped";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    public function uno($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT R.id_reservacion, H.id_huesped , H.apellido, R.fecha_entrada, R.fecha_salida, R.total FROM reservaciones AS R JOIN huespedes AS H ON R.id_huesped = H.id_huesped WHERE R.id_reservacion = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        
        return $datos;
    }

    public function insertar($id_huesped, $fecha_entrada, $fecha_salida, $total)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "INSERT INTO reservaciones (id_huesped, fecha_entrada, fecha_salida, total) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('issd', $id_huesped, $fecha_entrada, $fecha_salida, $total);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }

    public function eliminar($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "DELETE FROM reservaciones WHERE id_reservacion = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return $id;
        } else {
            return 'Error al eliminar:' . $stmt->error;
        }
    }

    public function ultimo()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT MAX(id_reservacion) AS ultimo_id FROM reservaciones";
        $resultado = mysqli_query($con, $cadena);
        $fila = mysqli_fetch_assoc($resultado);
        $con->close();
        return $fila['ultimo_id'];
    }
}