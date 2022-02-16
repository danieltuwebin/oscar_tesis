<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class PagoAmortizacion
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo insertar registro
    public function insertar(
        $idamortizacionDetalle,
        $numeroreciboDetalle,
        $numerooperacionDetalle,
        $descripcionDetalle,
        $fechapagoDetalle,
        $montopagoDetalle
    ) {
        $sql = "INSERT INTO pago_amortiz(idpago_amort
                            , idamortizacion
                            , num_recivo
                            , nump_op
                            , descrip
                            , fecha_pago
                            , total_pago) 
                            VALUES (
                            null
                            ,'$idamortizacionDetalle'
                            ,'$numeroreciboDetalle'
                            ,'$numerooperacionDetalle'
                            ,'$descripcionDetalle'
                            ,'$fechapagoDetalle'
                            ,'$montopagoDetalle'
                            )";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function obtenerPendientePagoAmortizacion($idamortizacionDetalle)
    {
        $sql = "SELECT (SELECT total FROM amortizacion WHERE idamortizacion = '$idamortizacionDetalle') - IFNULL(sum(total_pago),0) as total_pago FROM pago_amortiz WHERE idamortizacion ='$idamortizacionDetalle'";
        return ejecutarConsultaSimpleFila($sql);
        //$sql = "LLLL";
        //return $sql;
    }

    public function listar($idamortizacionDetalle)
    {
        $sql = "SELECT idpago_amort
        , idamortizacion
        , UPPER(num_recivo) AS num_recivo
        , UPPER(nump_op) AS nump_op
        , UPPER(descrip) AS descrip
        , fecha_pago, total_pago
        , fechagrabacion FROM pago_amortiz 
        -- WHERE idamortizacion = '3';
        WHERE idamortizacion = '$idamortizacionDetalle'";
        return ejecutarConsulta($sql);
    }
}
