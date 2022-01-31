<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcategoria,$codigo,$nombre,$stock,$idunidad,$idmarca,$idmodelo,$preciounit,$imagen)
	{
		$sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,idunidad,idmarca,idmodelo,preciounit,imagen,condicion)
		VALUES ('$idcategoria','$codigo','$nombre','$stock','$idunidad','$idmarca','$idmodelo','$preciounit','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$idunidad,$idmarca,$idmodelo,$preciounit,$imagen)
	{
		$sql="UPDATE articulo SET idcategoria='$idcategoria',codigo='$codigo',nombre='$nombre',stock='$stock',idunidad='$idunidad',idmarca='$idmarca',idmodelo='$idmodelo',preciounit='$preciounit',imagen='$imagen' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.idunidad,u.nombre as unidad, ma.nombre as marca, mo.nombre as modelo,a.preciounit,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad u on a.idunidad=u.idunidad INNER JOIN marca ma on a.idmarca=ma.idmarca INNER JOIN modelo mo on a.idmodelo=mo.idmodelo";
		return ejecutarConsulta($sql);		
	}
	public function listarprecio()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.idunidad,u.nombre as unidad, ma.nombre as marca, mo.nombre as modelo,a.preciounit,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad u on a.idunidad=u.idunidad INNER JOIN marca ma on a.idmarca=ma.idmarca INNER JOIN modelo mo on a.idmodelo=mo.idmodelo WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros avtivos
	public function listarActivos()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.idunidad,u.nombre as unidad, ma.nombre as marca, mo.nombre as modelo,a.preciounit,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad u on a.idunidad=u.idunidad INNER JOIN marca ma on a.idmarca=ma.idmarca INNER JOIN modelo mo on a.idmodelo=mo.idmodelo WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}
	 //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
    public function listarActivosVenta()
    {
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.idunidad,u.nombre as unidad, ma.nombre as marca, mo.nombre as modelo,a.preciounit,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad u on a.idunidad=u.idunidad INNER JOIN marca ma on a.idmarca=ma.idmarca INNER JOIN modelo mo on a.idmodelo=mo.idmodelo WHERE a.condicion='1'";
        return ejecutarConsulta($sql);      
    }

 
    //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_Guia)
   
}

?>