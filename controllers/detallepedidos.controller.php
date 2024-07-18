<?php
require_once('../config/cors.php');
require_once('../models/detallepedidos.model.php');

$detalle = new DetallesPedidos();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $detalle->todos();
        $todos = array();
        while($row = mysqli_fetch_assoc($datos)){
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    // INSERTAR
    case 'insertar':
        $id_pedido = $_POST["id_pedido"]?? null;
        $id_producto = $_POST["id_producto"]?? null;
        $cantidad = $_POST["cantidad"]?? null;
        $total = $_POST["total"]?? null;
        if($id_pedido && $id_producto && $cantidad && $total){
            $insertar = $detalle->insertar($id_pedido, $id_producto, $cantidad, $total);
            if($insertar){
                echo json_encode(array("Mensaje" => "Registro detalle insertado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al insertar detalle"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos en detalle"));
        }
        break;

    default:
    echo json_encode(array("Mensaje" => "Faltan datos en detalle: " . implode(', ', $faltantes)));;
    break;
}