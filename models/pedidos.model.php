<?php
require_once('../config/conexion.php');


class Pedidos
{
    public function todos()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT p.id_pedido AS id_pedido, c.apellido AS apellido_cliente,d.direccion AS direccion, p.fecha_pedido AS fecha, p.total AS total, p.estado AS estado FROM pedidos AS p JOIN clientes AS c ON p.id_cliente = c.id_cliente JOIN direcciones AS d ON c.id_cliente = d.id_cliente";
        $datos = mysqli_query($con, $cadena);
        $con->close(); 
        return $datos;
        console.log($datos);
        
    }

    public function uno($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT p.id_pedido, c.apellido,d.direccion, p.fecha_pedido, p.total FROM pedidos AS p JOIN clientes AS c ON p.id_cliente = c.id_cliente JOIN direcciones AS d ON c.id_cliente = d.id_cliente WHERE p.id_pedido = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        $con->close(); 
        
        return $datos;
    }

    public function insertar($id_cliente, $total)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $estado = 'pendiente';
        $cadena = "INSERT INTO pedidos (id_cliente, total, estado) VALUES (?, ?, ?)";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('ids', $id_cliente, $total, $estado);
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
        $cadena = "DELETE FROM pedidos WHERE id_pedido = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return $id;
        } else {
            return 'Error al eliminar:' . $stmt->error;
        }
    
        $con->close();
    }

    //obtener el id del ultimo registro insertado
    public function ultimo()
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT MAX(id_pedido) AS ultimo_id FROM pedidos";
        $resultado = mysqli_query($con, $cadena);
        $fila = mysqli_fetch_assoc($resultado);
        $con->close();
        return $fila['ultimo_id'];
    }

    //actualizar el estado del pedido a pagado
    public function pagar($id)
    {
        $con = new Conectar();
        $con = $con->Procedimiento_Conectar();
        $estado = 'pagado';
        $cadena = "UPDATE pedidos SET estado = ? WHERE id_pedido = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('si', $estado, $id);
        if ($stmt->execute()) {
            return $id;
        } else {
            return 'Error al actualizar:' . $stmt->error;
        }
        $con->close(); 
    }
}
