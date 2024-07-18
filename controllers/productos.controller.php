<?php
require_once('../config/cors.php');
require_once('../models/productos.model.php');

$producto = new Productos();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $producto->todos();
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
            $datos = $producto->uno($id);
            echo json_encode($datos);
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID"));
        }
        break;

    // INSERTAR
    case 'insertar':
        $nombre = $_POST["nombre"]?? null;
        $precio = $_POST["precio"]?? null;
        if($nombre && $precio){
            $insertar = $producto->insertar($nombre, $precio);
            if($insertar){
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
        $id = $_POST["id_producto"]?? null;
        $nombre = $_POST["nombre"]?? null;
        $precio = $_POST["precio"]?? null;
        if($id && $nombre && $precio){
            $actualizar = $producto->actualizar($id, $nombre, $precio);
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
        if(isset($_POST["id_producto"])){
            $id = $_POST["id_producto"];
            $eliminar = $producto->eliminar($id);
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