<?php
require_once('../config/cors.php');
require_once('../models/habitacion.model.php');

$habitacion = new Habitacion();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $habitacion->todos();
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
            $datos = $habitacion->uno($id);
            echo json_encode($datos);
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID"));
        }
        break;

    // INSERTAR
    case 'insertar':
        $numero = $_POST["numero"]?? null;
        $tipo = $_POST["tipo"]?? null;
        $precio = $_POST["precio"]?? null;
        if($numero && $tipo && $precio){
            $insertar = $habitacion->insertar($numero, $tipo, $precio);
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
        $id = $_POST["id_habitacion"]?? null;
        $tipo = $_POST["tipo"]?? null;
        $precio = $_POST["precio"]?? null;
        if($id && $tipo && $precio){
            $actualizar = $habitacion->actualizar($id, $tipo, $precio);
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
        if(isset($_POST["id_habitacion"])){
            $id = $_POST["id_habitacion"];
            $eliminar = $habitacion->eliminar($id);
            if($eliminar){
                echo json_encode(array("Mensaje" => "Registro eliminado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al eliminar"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID"));
        }
        break;
    
    case 'numeroExistente':
        if(isset($_POST["numero"])){
            $numero = $_POST["numero"];
            $datos = $habitacion->verificarNumero($numero);
            echo json_encode($datos);
        } else {
            echo json_encode(array("Mensaje" => "Falta el número"));
        }
        break;
    
    case 'habitacionesDisponibles':
            if(isset($_POST["fechaInicio"]) && isset($_POST["fechaFin"])){
                $fechaInicio = $_POST["fechaInicio"];
                $fechaFin = $_POST["fechaFin"];
                $habitacionesDisponibles = $habitacion->obtenerHabitacionesDisponibles($fechaInicio, $fechaFin);
                echo json_encode($habitacionesDisponibles);
            } else {
                echo json_encode(array("Mensaje" => "Faltan las fechas de inicio y fin"));
            }
    break;
    default:
        echo json_encode(array("Mensaje" => "Falta la operación"));
    break;
}