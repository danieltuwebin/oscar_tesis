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
        $id =  $_SESSION['idcliente'];
        $sql = "SELECT a.idamortizacion
        , a.idcliente
        , UPPER(p.nombre) as nombre
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
        if($_SESSION['tipoUsuario']=="CLIENTE") $sql .= " WHERE a.idcliente = '$id' ";
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
                                        ,'$idcliente'
                                        ,'$tipo_doc'
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
        , (a.total - sum(p.total_pago)) as pagopendiente
        FROM amortizacion a        
        LEFT JOIN pago_amortiz p ON a.idamortizacion = p.idamortizacion
        WHERE a.idamortizacion = '$idamortizacion'";
        return ejecutarConsultaSimpleFila($sql);
        //return $sql;
    }

	public function actualizarEstado($idamortizacion)
	{
		$sql = "UPDATE amortizacion set condicion='2' WHERE idamortizacion='$idamortizacion'";
		return ejecutarConsulta($sql);
		//return $sql;
	}
}
