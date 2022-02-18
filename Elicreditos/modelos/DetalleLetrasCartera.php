<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class DetalleLetrasCartera
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }
    //metodo insertar registro
    public function insertar(
        $idletra,
        $numeroRecibo,
        $numeroOperacion,
        $descripcion,
        $fechapago,
        $montopagoDetalle,
        $fechagrabacion
    ) {
        $sql = "INSERT INTO pago_letraCartera(
                               idpago_letraCartera
                             , idletra
                             , num_recibo
                             , nump_op
                             , descrip
                             , fecha_pago
                             , total_pago
                             , fechagrabacion
                            ) 
                            VALUES (
                                NULL
                            , '$idletra'
                            , '$numeroRecibo'
                            , '$numeroOperacion'
                            , '$descripcion'
                            , '$fechapago'
                            , '$montopagoDetalle'
                            , '$fechagrabacion'
                            )";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function listar($idLetra)
    {
        $sql = "SELECT idpago_letraCartera
                    , idletra
                    , num_recibo
                    , nump_op
                    , descrip
                    , fecha_pago
                    , total_pago
                    , fechagrabacion 
                    FROM pago_letraCartera WHERE idletra = '$idLetra'";
        return ejecutarConsulta($sql);
    }
}
