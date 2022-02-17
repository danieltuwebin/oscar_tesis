<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class Letras
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }
    //metodo insertar registro
    public function insertar(
        $idcliente,
        $tipo_letra,
        $num_letra,
        $num_factura,
        $lugar_giro,
        $fecha_emi,
        $fecha_ven,
        $num_unico,
        $moneda,
        $total,
        $condicion,
        $fechagrabacion
    ) {
        $sql = "INSERT INTO letras(idletra
                            , idcliente
                            , tipo_letra
                            , num_letra
                            , num_factura
                            , lugar_giro
                            , fecha_emi
                            , fecha_ven
                            , num_unico
                            , moneda
                            , total
                            , condicion
                            , fechagrabacion) 
                            VALUES (
                            NULL
                            , '$idcliente'
                            , '$tipo_letra'
                            , '$num_letra'
                            , '$num_factura'
                            , '$lugar_giro'
                            , '$fecha_emi'
                            , '$fecha_ven'
                            , '$num_unico'
                            , '$moneda'
                            , '$total'
                            -- , '$condicion'
                            , '1'
                            , '$fechagrabacion'
                            )";
        return ejecutarConsulta($sql);
        //return $sql;
    }

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
        -- , l.total
        , (SELECT SUM(tipo3_Comision) FROM detalle_letras WHERE idletra = '$idletra') + l.total AS total
        , (SELECT IFNULL(SUM(total), 0) FROM detalle_letras WHERE idletra = '$idletra' and tipoDetalleLetra = 2) AS totalRenovacion
        , l.condicion
        , l.fechagrabacion 
        FROM letras l LEFT JOIN persona p ON l.idcliente = p.idpersona
        WHERE l.idletra = '$idletra'";
        return ejecutarConsultaSimpleFila($sql);
        //return $sql;
    }

    public function actualizarEstado($idletra, $condicion)
    {
        $sql = "UPDATE letras SET condicion ='$condicion' WHERE idletra ='$idletra'";
        return ejecutarConsulta($sql);
        //return $sql;
    }
}
