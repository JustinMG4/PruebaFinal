<?php
require_once('../config/cors.php');
require_once('../models/pedidos.model.php');

$pedido = new Pedidos();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $pedido->todos();
        $todos = array();
        while($row = mysqli_fetch_assoc($datos)){
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    // UN REGISTRO
    case 'uno':
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            $datos = $pedido->uno($id);
            echo json_encode($datos);
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID"));
        }
        break;

    // INSERTAR
    case 'insertar':
        $id_cliente = $_POST["id_cliente"]?? null;
        $total = $_POST["total"]?? null;
        if($id_cliente && $total){
            $insertar = $pedido->insertar($id_cliente, $total);
            if($insertar){
                echo json_encode(array("Mensaje" => "Registro  pedido insertado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al insertar pedido"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos en pedido"));
        }
        break;
    // ELIMINAR
    case 'eliminar':
        if(isset($_POST["id_pedido"])){
            $id = $_POST["id_pedido"];
            $eliminar = $pedido->eliminar($id);
            if($eliminar){
                echo json_encode(array("Mensaje" => "Registro de Pedido eliminado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al eliminar Pedido"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID en Pedido"));
        }
        break;

    case 'ultimo':
        $datos = $pedido->ultimo();
        echo json_encode($datos);
        break;

    case 'pagar':
        $id_pedido = $_POST["id_pedido"]?? null;
        $pagar = $pedido->pagar($id_pedido);
        if($pagar){
            echo json_encode(array("Mensaje" => "Pedido pagado"));
        } else {
            echo json_encode(array("Mensaje" => "Error al pagar pedido"));
        }
        break;
    default:
        echo json_encode(array("Mensaje" => "Falta la operación"));
    break;
}