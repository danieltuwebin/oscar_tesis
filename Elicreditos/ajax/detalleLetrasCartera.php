<?php

session_start();
require_once "../modelos/DetalleLetrasCartera.php";

$detalleLetrasCartera = new DetalleLetrasCartera();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$idLetraDetalle = isset($_POST["idLetraDetalle"]) ? limpiarCadena($_POST["idLetraDetalle"]) : "";
$montoidLetra = isset($_POST["montoidLetra"]) ? limpiarCadena($_POST["montoidLetra"]) : "";
$nombreDetalle = isset($_POST["nombreDetalle"]) ? limpiarCadena($_POST["nombreDetalle"]) : "";
$numeroRecibo = isset($_POST["numeroRecibo"]) ? limpiarCadena($_POST["numeroRecibo"]) : "";
$numeroOperacion = isset($_POST["numeroOperacion"]) ? limpiarCadena(strtoupper($_POST["numeroOperacion"])) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena(strtoupper($_POST["descripcion"])) : "";
$fechapago = isset($_POST["fechapago"]) ? limpiarCadena($_POST["fechapago"]) : "";
$montopagoDetalle = isset($_POST["montopagoDetalle"]) ? limpiarCadena($_POST["montopagoDetalle"]) : "";
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'guardaryeditar':
		if (empty($id)) {
			$rspta = $detalleLetrasCartera->insertar(
				$idLetraDetalle,
				$numeroRecibo,
				$numeroOperacion,
				$descripcion,
				$fechapago,
				$montopagoDetalle,
				$fechagrabacion
			);
			//echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del Trabajador";
			echo $rspta ? "1" : "0";
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
		$rspta = $detalleLetrasCartera->listar($id);
		//declaramos un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->idpago_letraCartera,
				"1" => $reg->idletra,
				"2" => $reg->num_recibo,
				"3" => $reg->nump_op,
				"4" => $reg->descrip,
				"5" => $reg->fecha_pago,
				"6" => $reg->total_pago,
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
