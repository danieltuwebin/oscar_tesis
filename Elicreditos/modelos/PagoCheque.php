<?php
//incluir la conexion de base de datos
require "../config/conexion.php";

class PagoCheque
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo insertar registro
    public function insertar(
        $idCheque,
        $num_pago,
        $fecha_pago,
        $total_pago,
        $fechagrabacion
    ) {
        $sql = "INSERT INTO pago_cheque(idpcheque
                            , idcheques
                            , num_pago
                            , fecha_pago
                            , total_pago
                            , fechagrabacion)
                            VALUES (
                            null
                            ,'$idCheque'
                            ,'$num_pago'
                            ,'$fecha_pago'
                            ,'$total_pago'
                            ,'$fechagrabacion'
                            )";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function obtenerPendientePagosCheque($idCheque)
    {
        $sql = "SELECT       
                ifnull(sum(pc.total_pago),0) as pagorealizado
                , ifnull((c.monto - ifnull(sum(pc.total_pago),0)),0) as pagopendiente
                FROM cheques c 
                LEFT JOIN pago_cheque pc ON c.idcheques = pc.idcheques
                WHERE c.idcheques = '$idCheque'";
                return ejecutarConsultaSimpleFila($sql);
                //return $sql;
    }

    public function listar($idCheque)
    {
        $sql = "SELECT idpcheque
        , idcheques
        , num_pago
        , fecha_pago
        , total_pago
        from pago_cheque
        WHERE idcheques = '$idCheque'";
        return ejecutarConsulta($sql);
    }
}
