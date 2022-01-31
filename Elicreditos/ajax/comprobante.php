<?php 
require_once "../modelos/Comprobante.php";

$comprobante=new Comprobante();

$idcomprobante=isset($_POST["idcomprobante"])? limpiarCadena($_POST["idcomprobante"]):"";
$tipocomprobante=isset($_POST["tipocomprobante"])? limpiarCadena($_POST["tipocomprobante"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcomprobante)){
			$rspta=$comprobante->insertar($tipocomprobante);
			echo $rspta ? "Comprobante registrado" : "Comprobante no se pudo registrar";
		}
		else {
			$rspta=$comprobante->editar($idcomprobante,$tipocomprobante);
			echo $rspta ? "Comprobante actualizada" : "Comprobante no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$comprobante->desactivar($idcomprobante);
 		echo $rspta ? "Comprobante Desactivada" : "Comprobante no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$comprobante->activar($idcomprobante);
 		echo $rspta ? "Comprobante activado" : "Comprobante no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$comprobante->mostrar($idcomprobante);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$comprobante->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcomprobante.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idcomprobante.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idcomprobante.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idcomprobante.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->tipocomprobante,
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