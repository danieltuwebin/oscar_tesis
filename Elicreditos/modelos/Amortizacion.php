<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class Amortizacion
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $sql = "SELECT a.idamortizacion
        , a.idcliente
        , p.nombre
        , a.tipo_doc
        , t.nombre as nombre_doc
        , a.num_doc
        , a.fecha_emi
        , a.fecha_ven
        , a.moneda
        , a.total
        , a.condicion
        , a.fechagrabacion
        FROM amortizacion a 
        LEFT JOIN persona p ON a.idcliente = p.idpersona 
        LEFT JOIN tipoDocumento t ON a.tipo_doc = t.id";
        return ejecutarConsulta($sql);
    }

    //metodo insertar registro
    public function insertar($idcliente, $tipo_doc, $num_doc, $fecha_emi, $fecha_ven, $moneda, $total, $condicion, $fechagrabacion)
    {
        $sql = "INSERT INTO amortizacion(idamortizacion
                                        , idcliente
                                        , tipo_doc
                                        , num_doc
                                        , fecha_emi
                                        , fecha_ven
                                        , moneda
                                        , total
                                        , condicion
                                        , fechagrabacion) 
                                        VALUES (
                                        null
                                        ,'$tipo_doc'
                                        ,'$idcliente'
                                        ,'$num_doc'
                                        ,'$fecha_emi'
                                        ,'$fecha_ven'
                                        ,'$moneda'
                                        ,'$total'
                                        ,'$condicion'
                                        ,'$fechagrabacion'
                                        )";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function mostrar($idamortizacion)
    {
        $sql = "SELECT a.idamortizacion
        , a.idcliente
        , a.tipo_doc
        , a.num_doc
        , a.fecha_emi
        , a.fecha_ven
        , a.moneda
        , a.total
        , a.condicion
        , a.fechagrabacion 
        , sum(p.total_pago) as pagorealizado
        FROM amortizacion a        
        LEFT JOIN pago_amortiz p ON a.idamortizacion = p.idamortizacion
        WHERE a.idamortizacion = '$idamortizacion'";
        return ejecutarConsultaSimpleFila($sql);
        //return $sql;
    }
}
