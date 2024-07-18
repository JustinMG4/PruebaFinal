<?php
require_once('../config/cors.php');
require_once('../models/clientes.model.php');

$cliente = new Clientes();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $cliente->todos();
        $todos = array();
        while($row = mysqli_fetch_assoc($datos)){
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    // UN REGISTRO
    case 'uno':
        if (isset($_GET["id"])) {
            $idCliente = intval($_GET["id"]);
            $datos = $cliente->uno($idCliente);
            echo json_encode($datos); // Devuelve los datos del usuario en formato JSON
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    // INSERTAR
    case 'insertar':
        $nombre = $_POST["nombre"] ?? null;
        $apellido = $_POST["apellido"] ?? null;
        $correo = $_POST["correo"] ?? null;

        if($nombre && $apellido && $correo){
            $insertar = $cliente->insertar($nombre, $apellido, $correo);
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
        $id = $_POST["id_cliente"]?? null;
        $nombre = $_POST["nombre"]?? null;
        $apellido = $_POST["apellido"]?? null;
        $correo = $_POST["correo"]?? null;
        if($id && $nombre && $apellido && $correo){
            $actualizar = $cliente->actualizar($id, $nombre, $apellido, $correo);
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
            $eliminar = $cliente->eliminar($id);
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

