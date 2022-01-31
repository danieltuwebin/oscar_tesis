<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros
	
	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
    {
        $sql="SELECT DATE(v.fecha_emision) as emision,u.nombre as usuario,p.nombre as cliente,c.tipocomprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN comprobante c on v.idcomprobante=c.idcomprobante WHERE DATE(v.fecha_emision)>='$fecha_inicio' AND DATE(v.fecha_emision)<='$fecha_fin' AND v.idcliente='$idcliente'";
        return ejecutarConsulta($sql);      
    }

	
	
	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_emision)=curdate()";
		return ejecutarConsulta($sql);

	}

	
	public function ventasultimos_12meses()
    {
        $sql="SELECT DATE_FORMAT(fecha_emision,'%M') as fecha,SUM(total_venta) as total FROM venta GROUP by MONTH(fecha_emision) ORDER BY fecha_emision DESC limit 0,10";
        return ejecutarConsulta($sql);
    }
}

?>