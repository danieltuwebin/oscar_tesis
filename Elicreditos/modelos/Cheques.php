<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class Cheques
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    public function listar()
    {
        $id =  $_SESSION['idcliente'];
        $sql = "SELECT idcheques
        , c.idcliente
        , UPPER(p.nombre) as nombre
        , c.tipo_cheque
        , c.bco_cheque
        , c.doc_pago
        , c.num_docpago
        , c.fecha_emi
        , c.fecha_ven
        , c.moneda
        , c.monto
        , c.imagen
        , c.condicion
        FROM cheques c
        LEFT JOIN persona p ON c.idcliente = p.idpersona";
        if($_SESSION['tipoUsuario']=="CLIENTE") $sql .= " WHERE c.idcliente = '$id' ";
        return ejecutarConsulta($sql);
    }

    //metodo insertar registro
    public function insertar($id_cliente
                            ,$tipocheque
                            ,$banco
                            ,$tipodocumento
                            ,$numerodocumento
                            ,$fechaemision
                            ,$fechavencimiento
                            ,$tipoMoneda
                            ,$monto
                            ,$imagen
                            ,$condicion
                            ,$fechagrabacion
                            )
    {
        $sql = "INSERT INTO cheques(idcheques
                                        , idcliente
                                        , tipo_cheque
                                        , bco_cheque
                                        , doc_pago
                                        , num_docpago
                                        , fecha_emi
                                        , fecha_ven
                                        , moneda
                                        , monto
                                        , imagen
                                        , condicion
                                        , fechagrabacion) 
                                        VALUES (
                                        null
                                        ,'$id_cliente'
                                        ,'$tipocheque'
                                        ,'$banco'
                                        ,'$tipodocumento'
                                        ,'$numerodocumento'
                                        ,'$fechaemision'
                                        ,'$fechavencimiento'
                                        ,'$tipoMoneda'
                                        ,'$monto'
                                        ,'$imagen'
                                        ,'$condicion'
                                        ,'$fechagrabacion'
                                        )";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function mostrar($idcheque)
    {
        $sql = "SELECT c.idcheques
        , c.idcliente
        , c.tipo_cheque
        , c.bco_cheque
        , c.doc_pago
        , c.num_docpago
        , c.fecha_emi
        , c.fecha_ven
        , c.moneda
        , c.monto
        , c.imagen
        , c.condicion
        , c.fechagrabacion 
        , ifnull(sum(pc.total_pago),0) as pagorealizado
        , ifnull((c.monto - ifnull(sum(pc.total_pago),0)),0) as pagopendiente
        FROM cheques c 
        LEFT JOIN pago_cheque pc ON c.idcheques = pc.idcheques
        LEFT JOIN persona p ON c.idcliente = p.idpersona
        WHERE c.idcheques = '$idcheque'";
        return ejecutarConsultaSimpleFila($sql);
        //return $sql;
    }

	public function actualizarEstado($idcheque)
	{
		$sql = "UPDATE cheques set condicion='2' WHERE idcheques='$idcheque'";
		return ejecutarConsulta($sql);
		//return $sql;
	}
}
