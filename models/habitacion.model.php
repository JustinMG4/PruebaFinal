<?php
require_once('../config/conexion.php');

class Habitacion
{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT H.id_habitacion, H.numero, T.tipo, H.precio, H.estado FROM habitaciones AS H JOIN tipos_habitaciones AS T ON H.id_tipo = T.id ORDER BY H.numero";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    public function uno($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT H.id_habitacion, H.numero, T.tipo, H.precio, H.estado FROM habitaciones AS H JOIN tipos_habitaciones AS T ON H.id_tipo = T.id WHERE H.id_habitacion = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        
        return $datos;
    }

    public function insertar($numero, $tipo, $precio)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $estado = 'Disponible';
        $cadena = "INSERT INTO habitaciones (numero, id_tipo, precio, estado) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('ssss', $numero, $tipo, $precio, $estado);
        if ($stmt->execute()) {
        } else {
            return 'Error al insertar:' . $stmt->error;
        }
        $con->close(); 
    }

    public function actualizar($id, $tipo, $precio)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE habitaciones SET id_tipo = ?, precio = ? WHERE id_habitacion = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('ssi', $tipo, $precio, $id);
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
        $cadena = "DELETE FROM habitaciones WHERE id_habitacion = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return $id;
        } else {
            return 'Error al eliminar:' . $stmt->error;
        }
    
        $con->close();
    }

    //Verificar si el numero de habitacion ya existe
    public function verificarNumero($numero)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT numero FROM habitaciones WHERE numero = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('s', $numero);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        return $datos;
    }

    public function obtenerHabitacionesDisponibles($fechaInicio, $fechaFin)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "
            SELECT DISTINCT h.id_habitacion, h.numero, th.tipo, h.precio, h.estado
            FROM habitaciones h
            LEFT JOIN tipos_habitaciones th ON h.id_tipo = th.id
            LEFT JOIN detalle_reservaciones dr ON h.id_habitacion = dr.id_habitacion
            LEFT JOIN reservaciones r ON dr.id_reservacion = r.id_reservacion
            WHERE h.estado = 'Disponible' AND (
                r.id_reservacion IS NULL OR
                (r.fecha_entrada >= ? OR r.fecha_salida <= ?)
            )
            AND NOT EXISTS (
                SELECT 1
                FROM reservaciones r2
                WHERE r2.id_reservacion = r.id_reservacion
                AND (
                    (r2.fecha_entrada BETWEEN ? AND ?) OR
                    (r2.fecha_salida BETWEEN ? AND ?) OR
                    (? BETWEEN r2.fecha_entrada AND r2.fecha_salida) OR
                    (? BETWEEN r2.fecha_entrada AND r2.fecha_salida)
                ) 
            )
            ORDER BY h.numero;
            
        ";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('ssssssss', $fechaFin, $fechaInicio, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $habitacionesDisponibles = [];
        while ($fila = $resultado->fetch_assoc()) {
            $habitacionesDisponibles[] = $fila;
        }
        $con->close();
        return $habitacionesDisponibles;
    }
   
}