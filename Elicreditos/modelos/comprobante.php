<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Comprobante
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($tipocomprobante)
	{
		$sql="INSERT INTO comprobante(tipocomprobante,condicion)
		VALUES ('$tipocomprobante','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcomprobante,$tipocomprobante)
	{
		$sql="UPDATE comprobante SET tipocomprobante='$tipocomprobante' WHERE idcomprobante='$idcomprobante'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcomprobante)
	{
		$sql="UPDATE comprobante SET condicion='0' WHERE idcomprobante='$idcomprobante'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcomprobante)
	{
		$sql="UPDATE comprobante SET condicion='1' WHERE idcomprobante='$idcomprobante'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcomprobante)
	{
		$sql="SELECT * FROM comprobante WHERE idcomprobante='$idcomprobante'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM comprobante";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM comprobante where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>