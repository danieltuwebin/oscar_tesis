<?php 
require_once "../modelos/Unidad.php";

$unidad=new Unidad();

$idunidad=isset($_POST["idunidad"])? limpiarCadena($_POST["idunidad"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idunidad)){
			$rspta=$unidad->insertar($nombre);
			echo $rspta ? "Unidad registrada" : "Unidad no se pudo registrar";
		}
		else {
			$rspta=$unidad->editar($idunidad,$nombre);
			echo $rspta ? "Unidad actualizada" : "Unidad no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$unidad->desactivar($idunidad);
 		echo $rspta ? "Unidad Desactivada" : "Unidad no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$unidad->activar($idunidad);
 		echo $rspta ? "Unidad activada" : "Unidad no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$unidad->mostrar($idunidad);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$unidad->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idunidad.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idunidad.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idunidad.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idunidad.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>