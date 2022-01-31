<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Docpersona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($documento)
	{
		$sql="INSERT INTO documentopersona (documento,condicion) VALUES ('$documento','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($iddocumento,$documento)
	{
		$sql="UPDATE documentopersona SET documento='$documento' WHERE iddocumento='$iddocumento'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar 
	public function desactivar($iddocumento)
	{
		$sql="UPDATE documentopersona SET condicion='0' WHERE iddocumento='$iddocumento'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar 
	public function activar($iddocumento)
	{
		$sql="UPDATE documentopersona SET condicion='1' WHERE iddocumento='$iddocumento'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($iddocumento)
	{
		$sql="SELECT * FROM documentopersona WHERE iddocumento='$iddocumento'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM documentopersona";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM documentopersona where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>