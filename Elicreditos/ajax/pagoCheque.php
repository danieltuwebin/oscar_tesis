<?php
session_start();
require_once "../modelos/PagoCheque.php";

$pagoCheque = new PagoCheque();

$idCheque = isset($_POST["idCheque"]) ? limpiarCadena($_POST["idCheque"]) : "";
$idPagoCheque = isset($_POST["idPagoCheque"]) ? limpiarCadena($_POST["idPagoCheque"]) : "";
$montoidCheque = isset($_POST["montoidCheque"]) ? limpiarCadena(strtoupper($_POST["montoidCheque"])) : "";
$numeroPago = isset($_POST["numeroPago"]) ? limpiarCadena(strtoupper($_POST["numeroPago"])) : "";
$fechapago = isset($_POST["fechapago"]) ? limpiarCadena(strtoupper($_POST["fechapago"])) : "";
$montopagoDetalle = isset($_POST["montopagoDetalle"]) ? limpiarCadena($_POST["montopagoDetalle"]) : "";

// Para Fecha
$date = date('Y-m-d H:i:s');
$newDate = strtotime('-2 hour', strtotime($date));
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'obtenerPendientePagosCheque':
		$rspta = $pagoCheque->obtenerPendientePagosCheque($idCheque);
		//echo $rspta;
		//echo 'daniel '.$idCheque;
		echo json_encode($rspta);

		break;

	case 'guardaryeditar':	
		if (empty($idPagoCheque)) {
			$rspta = $pagoCheque->insertar(
				$idCheque,
				$numeroPago,
				$fechapago,
				$montopagoDetalle,
				$fechagrabacion
			);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del Trabajador";
			//echo $rspta;
		} else {
			//$rspta = $amortizacion->editar($id_formacion, $id_trabajador, $nivelEducativo, $gradoEducativo, $nombreProfesion, $numeroColegiatura, $maestria, $doctorado, $institucionEducativa, $fechaExpedicionTitulo);
			//echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
			//echo $rspta;
		}
		

		break;

		case 'listar':
			$id = $_GET["id"];
			$rspta = $pagoCheque->listar($id);
			//declaramos un array
			$data = array();
	
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0" => $reg->idpcheque,
					"1" => $reg->num_pago,
					"2" => $reg->fecha_pago,
					"3" => $reg->total_pago
				);
			}
	
			$results = array(
				"sEcho" => 1, //info para datatables
				"iTotalRecords" => count($data), //enviamos el total de registros al datatable
				"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
				"aaData" => $data
			);
			echo json_encode($results);
	
			break;

}
