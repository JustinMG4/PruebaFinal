<?php
require_once('../config/cors.php');
require_once('../models/reserva.model.php');

$reserva = new Reserva();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($_GET["op"]) {

    //TODOS LOS REGISTROS
    case 'todos':
        $datos = $reserva->todos();
        $todos = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    // UN REGISTRO
    case 'uno':
        if (isset($_GET["id"])) {
            $idReserva = intval($_GET["id"]);
            $datos = $reserva->uno($idReserva);
            echo json_encode($datos); // Devuelve los datos del usuario en formato JSON
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    // INSERTAR
    case 'insertar':
        $idHuesped = $_POST["id_huesped"] ?? null;
        $fechaEntrada = $_POST["fecha_entrada"] ?? null;
        $fechaSalida = $_POST["fecha_salida"] ?? null;
        $total = $_POST["total"] ?? null;
        if ($idHuesped && $fechaEntrada && $fechaSalida && $total) {
            $insertar = $reserva->insertar($idHuesped, $fechaEntrada, $fechaSalida, $total);
            if ($insertar) {
                echo json_encode(array("Mensaje" => "Registro insertado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al insertar"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Faltan datos"));
        }

        break;
    // ELIMINAR
    case 'eliminar':
        if (isset($_POST["id_reservacion"])) {
            $id = $_POST["id_reservacion"];
            $eliminar = $reserva->eliminar($id);
            if ($eliminar) {
                echo json_encode(array("Mensaje" => "Registro eliminado"));
            } else {
                echo json_encode(array("Mensaje" => "Error al eliminar"));
            }
        } else {
            echo json_encode(array("Mensaje" => "Falta el ID"));
        }
        break;

    case 'ultimo':
        $datos = $reserva->ultimo();
        echo json_encode($datos);
        break;
    default:
        echo json_encode(array("Mensaje" => "Falta el ID"));
   break;
}

