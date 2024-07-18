<?php
require_once('../config/cors.php');
require_once('../models/direccion.model.php');

$direccion = new Direccion();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    // INSERTAR
    case 'insertar':
        $id_cliente = $_POST["id_cliente"]?? null;
        $ndireccion = $_POST["ndireccion"]?? null;
        if($id_cliente && $ndireccion){
            $insertar = $direccion->insertar($id_cliente, $ndireccion);
            if($insertar){
                echo json_encode(array("Mensaje" => "Registro de direccion insertado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al insertar direccion"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos en direccion"));
        }
        break;

    default:
        echo json_encode(array("Mensaje" => "Falta la operación"));
    break;
}