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
    public function insertar($idamortizacionDetalle
                            , $numeroreciboDetalle
                            , $numerooperacionDetalle
                            , $descripcionDetalle
                            , $fechapagoDetalle
                            , $montopagoDetalle)
    {
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
        $sql = "SELECT (SELECT total FROM amortizacion WHERE idamortizacion = '$idamortizacionDetalle') - sum(total_pago) as total_pago FROM pago_amortiz WHERE idamortizacion ='$idamortizacionDetalle'";
        return ejecutarConsultaSimpleFila($sql);
        //$sql = "LLLL";
        //return $sql;
    }

}
