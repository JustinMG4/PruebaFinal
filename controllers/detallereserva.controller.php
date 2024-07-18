<?php
require_once('../config/cors.php');
require_once('../models/detallereserva.model.php');

$detalle = new DetalleReserva();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    //TODOS LOS REGISTROS
    case 'detalle':
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $datos = $detalle->detalle($id);
            header('Content-Type: application/json'); // Asegurarse de que el contenido sea JSON
            echo json_encode($datos);
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID"));
        }
        break;
    // INSERTAR
    case 'insertar':
        $id_reservacion = $_POST["id_reservacion"]?? null;
        $id_habitacion = $_POST["id_habitacion"]?? null;
        $subtotal = $_POST["subtotal"]?? null;
        if($id_reservacion && $id_habitacion && $subtotal){
            $insertar = $detalle->insertar($id_reservacion, $id_habitacion, $subtotal);
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