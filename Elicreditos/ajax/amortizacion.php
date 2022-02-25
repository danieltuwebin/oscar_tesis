<?php
ob_start();
session_start();
require_once "../modelos/Amortizacion.php";

$amortizacion = new Amortizacion();

$idamortizacion = isset($_POST["idamortizacion"]) ? limpiarCadena($_POST["idamortizacion"]) : "";
$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$tipo_persona = isset($_POST["tipo_persona"]) ? limpiarCadena($_POST["tipo_persona"]) : "";
$id_cliente = isset($_POST["id_cliente"]) ? limpiarCadena($_POST["id_cliente"]) : "";
$documento = isset($_POST["documento"]) ? limpiarCadena($_POST["documento"]) : "";
$numerodoc = isset($_POST["numerodoc"]) ? limpiarCadena(strtoupper($_POST["numerodoc"])) : "";
$fechaemision = isset($_POST["fechaemision"]) ? limpiarCadena($_POST["fechaemision"]) : "";
$fechavencimiento = isset($_POST["fechavencimiento"]) ? limpiarCadena($_POST["fechavencimiento"]) : "";
$tipoMoneda = isset($_POST["tipoMoneda"]) ? limpiarCadena($_POST["tipoMoneda"]) : "";
$totaldeuda = isset($_POST["totaldeuda"]) ? limpiarCadena($_POST["totaldeuda"]) : "";
$tipovista = isset($_POST["tipovista"]) ? limpiarCadena($_POST["tipovista"]) : "";

// Para Fecha
$date = date('Y-m-d H:i:s');
$newDate = strtotime('-2 hour', strtotime($date));
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'listar':
		$rspta = $amortizacion->listar();
		//declaramos un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion == 1) ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idamortizacion . ')"><i class="fa fa-eye"></i></button>'
					. ' ' . '<button class="btn btn-warning btn-xs" onclick="amortizar(' . $reg->idamortizacion . ',&apos;' . $reg->nombre . '&apos;)"><i class="fa fa-pencil"></i></button>'
					: '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idamortizacion . ')"><i class="fa fa-eye"></i></button>',
				//"0" => $reg->idamortizacion,
				"1" => $reg->idamortizacion,
				"2" => $reg->nombre,
				"3" => $reg->nombre_doc,
				"4" => $reg->num_doc,
				"5" => $reg->fecha_emi,
				"6" => $reg->fecha_ven,
				"7" => $reg->moneda,
				"8" => $reg->total,
				"9" => ($reg->condicion == 1) ? '<span class="label bg-red">Pendiente</span>' : '<span class="label bg-green">Pagado</span>'
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

		case 'listarView':
			$rspta = $amortizacion->listar();
			//declaramos un array
			$data = array();
	
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0" => '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idamortizacion . ')"><i class="fa fa-eye"></i></button>',
					//"0" => $reg->idamortizacion,
					"1" => $reg->idamortizacion,
					"2" => $reg->nombre,
					"3" => $reg->nombre_doc,
					"4" => $reg->num_doc,
					"5" => $reg->fecha_emi,
					"6" => $reg->fecha_ven,
					"7" => $reg->moneda,
					"8" => $reg->total,
					"9" => ($reg->condicion == 1) ? '<span class="label bg-red">Pendiente</span>' : '<span class="label bg-green">Pagado</span>'
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
	

	case 'guardaryeditar':
		if (empty($idamortizacion)) {
			$rspta = $amortizacion->insertar(
				$id_cliente,
				$documento,
				$numerodoc,
				$fechaemision,
				$fechavencimiento,
				$tipoMoneda,
				$totaldeuda,
				'1',
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

	case 'mostrar':
		$rspta = $amortizacion->mostrar($idamortizacion);
		echo json_encode($rspta);
		//echo $rspta;
		//echo '1234 '.$idamortizacion;
		break;

	case 'actualizarEstado':
		$rspta = $amortizacion->actualizarEstado($idamortizacion);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		//echo $rspta;
		break;
}
