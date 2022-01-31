<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Modelo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO modelo (nombre,condicion)
		VALUES ('$nombre','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idmodelo,$nombre)
	{
		$sql="UPDATE modelo SET nombre='$nombre' WHERE idmodelo='$idmodelo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idmodelo)
	{
		$sql="UPDATE modelo SET condicion='0' WHERE idmodelo='$idmodelo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idmodelo)
	{
		$sql="UPDATE modelo SET condicion='1' WHERE idmodelo='$idmodelo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idmodelo)
	{
		$sql="SELECT * FROM modelo WHERE idmodelo='$idmodelo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM modelo";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM modelo where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>