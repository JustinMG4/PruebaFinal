<?php
class Conectar
{
    public $conexion;
    protected $db;
    private $server = "localhost";
    private $usu = "root";
    private $clave = ""; 
    private $base = "hotel2";

    public function Procedimiento_Conectar() {
        $this->conexion = new mysqli($this->server, $this->usu, $this->clave, $this->base);

        if ($this->conexion->connect_error) {
            die("Error al conectar con MySQL: " . $this->conexion->connect_error);
        }

        if (!$this->conexion->set_charset("utf8")) {
            die("Error al establecer el charset UTF-8: " . $this->conexion->error);
        }
        return $this->conexion;
    }
}