<?php 
require_once "../modelos/Docpersona.php";

$docpersona=new Docpersona();

$iddocumento=isset($_POST["iddocumento"])? limpiarCadena($_POST["iddocumento"]):"";
$documento=isset($_POST["documento"])? limpiarCadena($_POST["documento"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($iddocumento)){
			$rspta=$docpersona->insertar($documento);
			echo $rspta ? "Doc. de identidad registrada" : "Doc. de identidad no se pudo registrar";
		}
		else {
			$rspta=$docpersona->editar($iddocumento,$documento);
			echo $rspta ? "Doc. de identidad actualizada" : "Doc. de identidad no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$docpersona->desactivar($iddocumento);
 		echo $rspta ? "Doc. de identidad Desactivada" : "Doc. de identidad no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$docpersona->activar($iddocumento);
 		echo $rspta ? "Doc. de identidad activada" : "Doc. de identidad no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$docpersona->mostrar($iddocumento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$docpersona->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->iddocumento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->iddocumento.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->iddocumento.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->iddocumento.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->documento,
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