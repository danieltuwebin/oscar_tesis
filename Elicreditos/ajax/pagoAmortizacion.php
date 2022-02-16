<?php

session_start();
require_once "../modelos/PagoAmortizacion.php";

$pagoAmortizacion = new PagoAmortizacion();

$idamortizacionPago = isset($_POST["idamortizacionPago"]) ? limpiarCadena($_POST["idamortizacionPago"]) : "";
$idamortizacionDetalle = isset($_POST["idamortizacionDetalle"]) ? limpiarCadena($_POST["idamortizacionDetalle"]) : "";
$numeroreciboDetalle = isset($_POST["numeroreciboDetalle"]) ? limpiarCadena(strtoupper($_POST["numeroreciboDetalle"])) : "";
$numerooperacionDetalle = isset($_POST["numerooperacionDetalle"]) ? limpiarCadena(strtoupper($_POST["numerooperacionDetalle"])) : "";
$descripcionDetalle = isset($_POST["descripcionDetalle"]) ? limpiarCadena(strtoupper($_POST["descripcionDetalle"])) : "";
$fechapagoDetalle = isset($_POST["fechapagoDetalle"]) ? limpiarCadena($_POST["fechapagoDetalle"]) : "";
$montopagoDetalle = isset($_POST["montopagoDetalle"]) ? limpiarCadena($_POST["montopagoDetalle"]) : "";
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'obtenerPendientePagoAmortizacion':
		$rspta = $pagoAmortizacion->obtenerPendientePagoAmortizacion($idamortizacionDetalle);
		echo json_encode($rspta);
		//echo $rspta;
		//echo $idamortizacion;
		//echo 'hola mundo';
		//echo '1234 '.$idamortizacionDetalle.'--';
		break;

	case 'guardaryeditar':
		if (empty($idamortizacionPago)) {
			$rspta = $pagoAmortizacion->insertar(
				$idamortizacionDetalle,
				$numeroreciboDetalle,
				$numerooperacionDetalle,
				$descripcionDetalle,
				$fechapagoDetalle,
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
		//die('123');
		$id = $_GET["id"];
		$rspta = $pagoAmortizacion->listar($id);
		//declaramos un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->idpago_amort,
				"1" => $reg->num_recivo,
				"2" => $reg->nump_op,
				"3" => $reg->descrip,
				"4" => $reg->fecha_pago,
				"5" => $reg->total_pago
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
