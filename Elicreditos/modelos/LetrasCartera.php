<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class LetrasCartera
{

    //implementamos nuestro constructor
    public function __construct()
    {
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
        FROM letras_cartera l LEFT JOIN persona p ON l.idcliente = p.idpersona";
        return ejecutarConsulta($sql);
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
        $moneda,
        $total,
        $condicion,
        $fechagrabacion
    ) {
        $sql = "INSERT INTO letras_cartera(idletra
                            , idcliente
                            , tipo_letra
                            , num_letra
                            , num_factura
                            , lugar_giro
                            , fecha_emi
                            , fecha_ven
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
                            , '$moneda'
                            , '$total'
                            -- , '$condicion'
                            , '1'
                            , '$fechagrabacion'
                            )";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function mostrar($idletra)
    {
        $sql = "SELECT l.idletra
        , l.idcliente
        , c.nombre
        , UPPER(l.tipo_letra) AS tipo_letra
        , UPPER(l.num_letra) AS num_letra
        , UPPER(l.num_factura) AS num_factura
        , UPPER(l.lugar_giro) AS lugar_giro
        , l.fecha_emi
        , l.fecha_ven
        , l.num_unico
        , UPPER(l.moneda) AS moneda
        , l.total
        , ifnull(sum(p.total_pago),0) as pagorealizado
        -- , ifnull((l.total - sum(p.total_pago)),0) as pagopendiente
        , ifnull((l.total - ifnull(sum(p.total_pago),0)),0) as pagopendiente
        , l.condicion
        , l.fechagrabacion 
        FROM letras_cartera l 
        LEFT JOIN pago_letraCartera p ON l.idletra = p.idletra
        LEFT JOIN persona c ON c.idpersona = l.idcliente
        WHERE l.idletra = '$idletra'";
        return ejecutarConsultaSimpleFila($sql);
        //return $sql;
    }

    public function actualizarEstado($idletra, $condicion)
    {
        $sql = "UPDATE letras_cartera SET condicion ='$condicion' WHERE idletra ='$idletra'";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function obtieneDeudaPendiente($idletra)
    {
        $sql = "SELECT l.idletra
                , ifnull((l.total - ifnull(sum(p.total_pago),0)),0) as total
                FROM letras_cartera l 
                LEFT JOIN pago_letraCartera p ON l.idletra = p.idletra
                WHERE l.idletra = '$idletra'";
        return ejecutarConsultaSimpleFila($sql);
        //return $sql;
    }
}
