<?php
require_once('../config/cors.php');
require_once('../models/tipohabitacion.model.php');

$tipo = new Tipo();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){

    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $tipo->todos();
        $todos = array();
        while($row = mysqli_fetch_assoc($datos)){
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    // INSERTAR
    case 'insertar':
        $tipo = $_POST["tipo"]?? null;
        if($tipo){
            $insertar = $tipo->insertar($tipo);
            if($insertar){
                echo json_encode(array("Mensaje" => "Registro insertado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al insertar"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos"));
        }
        break;
    case 'obtenerId':
        $tipoH = $_POST["tipo"]?? null;
        if($tipoH){
            $id = $tipo-> obtenerId($tipoH);
            if($id){
                echo json_encode($id);
            } else {
                echo json_encode(array("Mensaje" => "Error al obtener el id"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos"));
        }
        break;
    default:
        echo json_encode(array("Mensaje" => "Falta la operación"));
    break;
}