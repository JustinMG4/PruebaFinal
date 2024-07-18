<?php
require_once('../config/cors.php');
require_once('../models/huesped.model.php');

$huesped = new Huesped();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){

    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $huesped->todos();
        $todos = array();
        while($row = mysqli_fetch_assoc($datos)){
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    // UN REGISTRO
    case 'uno':
        if (isset($_GET["id"])) {
            $idHuesped = intval($_GET["id"]);
            $datos = $huesped->uno($idHuesped);
            echo json_encode($datos); // Devuelve los datos del usuario en formato JSON
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    // INSERTAR
    case 'insertar':
        $idHuesped = $_POST["id_huesped"] ?? null;
        $tipo_identificacion = $_POST["tipo_identificacion"] ?? null;
        $nombre = $_POST["nombre"] ?? null;
        $apellido = $_POST["apellido"] ?? null;
        $email = $_POST["email"] ?? null;
        $telefono = $_POST["telefono"] ?? null;
        if($idHuesped && $tipo_identificacion && $nombre && $apellido && $email && $telefono){
            $insertar = $huesped->insertar($idHuesped, $tipo_identificacion, $nombre, $apellido, $email, $telefono);
            if($insertar==0){
                echo json_encode(array("Mensaje" => "Registro insertado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al insertar"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos"));
        }

        break;

    // ACTUALIZAR
    case 'actualizar':
        $id = $_POST["id_huesped"]?? null;
        $nombre = $_POST["nombre"]?? null;
        $apellido = $_POST["apellido"]?? null;
        $email = $_POST["email"]?? null;
        $telefono = $_POST["telefono"]?? null;
        if($id  && $nombre && $apellido && $email && $telefono){
            $actualizar = $huesped->actualizar($id, $nombre, $apellido, $email, $telefono);
            if($actualizar){
                echo json_encode(array("Mensaje" => "Registro actualizado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al actualizar"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos"));
        }
        break;
    
    // ELIMINAR
    case 'eliminar':
        if(isset($_POST["id"])){
            $id = $_POST["id"];
            $eliminar = $huesped->eliminar($id);
            if($eliminar){
                echo json_encode(array("Mensaje" => "Registro eliminado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al eliminar"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID"));
        }
        break;
    
    default:
        echo json_encode(array("Mensaje" => "Falta la operación"));
    break;

}   

