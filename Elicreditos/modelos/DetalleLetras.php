<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class DetalleLetras
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }
    //metodo insertar registro
    public function insertar(
        $idletra,
        $tipoLetraDetalle,
        $numeroPago,
        $fechapago,
        $fecharenovacion,
        $fechavencimiento,
        $comisionprotesto,
        $fechaprotesto,
        $montopagoDetalle,
        $fechagrabacion
    ) {
        $sql = "INSERT INTO detalle_letras(
                              idDetalleLetra
                            , idletra
                            , tipoDetalleLetra
                            , tipo1_numeroPago
                            , tipo1_FechaPago
                            , tipo2_FechaRenovacion
                            , tipo2_FechaVencimiento
                            , tipo3_Comision
                            , tipo3_FechaProtesto
                            , total
                            , fechagrabacion
                            ) 
                            VALUES (
                                NULL
                            , '$idletra'
                            , '$tipoLetraDetalle'
                            , '$numeroPago'
                            , '$fechapago'
                            , '$fecharenovacion'
                            , '$fechavencimiento'
                            , '$comisionprotesto'
                            , '$fechaprotesto'
                            , '$montopagoDetalle'
                            , '$fechagrabacion'
                            )";
                            //die($sql);
        return ejecutarConsulta($sql);
        //return $sql;
    }

    /*
    public function listar()
    {
        $sql = "SELECT l.idletra
        , l.idcliente
        , p.nombre
        , UPPER(l.tipo_letra) AS tipo_letra
        , UPPER(l.num_letra) AS num_letra
        , UPPER(l.num_factura) AS num_factura
        , UPPER(l.lugar_giro) AS lugar_giro
        , l.fecha_emi
        , l.fecha_ven
        , l.num_unico
        , UPPER(l.moneda) AS moneda
        , l.total
        , l.condicion
        , l.fechagrabacion 
        FROM letras l LEFT JOIN persona p ON l.idcliente = p.idpersona";
        return ejecutarConsulta($sql);
    }
    */

    public function listar($idLetra)
    {
        $sql = "SELECT idDetalleLetra
        ,IF(tipoDetalleLetra = 1, 'PAGO LETRA'
        ,IF(tipoDetalleLetra = 2, 'RENOVACION'
        ,IF(tipoDetalleLetra = 3, 'PROTESTO',''))) AS tipopagoletra
        , tipo1_numeroPago
        , tipo1_FechaPago
        , tipo2_FechaRenovacion
        ,tipo2_FechaVencimiento
        ,tipo3_FechaProtesto
        ,tipo3_Comision,total 
        FROM detalle_letras WHERE idletra = '$idLetra'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idletra)
    {
        $sql = "SELECT l.idletra
        , l.idcliente
        , p.nombre
        , UPPER(l.tipo_letra) AS tipo_letra
        , UPPER(l.num_letra) AS num_letra
        , UPPER(l.num_factura) AS num_factura
        , UPPER(l.lugar_giro) AS lugar_giro
        , l.fecha_emi
        , l.fecha_ven
        , l.num_unico
        , UPPER(l.moneda) AS moneda
        , l.total
        , l.condicion
        , l.fechagrabacion 
        FROM letras l LEFT JOIN persona p ON l.idcliente = p.idpersona
        WHERE l.idletra = '$idletra'";
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
