<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class TipoDocumento
{
    //implementamos nuestro constructor
    public function __construct()
    {
    }
    //listar registros
    public function listar()
    {
        $sql = "SELECT * FROM tipoDocumento";
        return ejecutarConsulta($sql);
    }
}
