<?php

session_start();
require_once "../modelos/LetrasCartera.php";

$letrasCartera = new LetrasCartera();

$idletra = isset($_POST["idletra"]) ? limpiarCadena($_POST["idletra"]) : "";
$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$id_cliente = isset($_POST["id_cliente"]) ? limpiarCadena($_POST["id_cliente"]) : "";
$tipoletra = isset($_POST["tipoletra"]) ? limpiarCadena($_POST["tipoletra"]) : "";
$numeroletra = isset($_POST["numeroletra"]) ? limpiarCadena(strtoupper($_POST["numeroletra"])) : "";
$numerofactura = isset($_POST["numerofactura"]) ? limpiarCadena(strtoupper($_POST["numerofactura"])) : "";
$lugargiro = isset($_POST["lugargiro"]) ? limpiarCadena($_POST["lugargiro"]) : "";
$fechaemision = isset($_POST["fechaemision"]) ? limpiarCadena($_POST["fechaemision"]) : "";
$fechavencimiento = isset($_POST["fechavencimiento"]) ? limpiarCadena($_POST["fechavencimiento"]) : "";
$tipoMoneda = isset($_POST["tipoMoneda"]) ? limpiarCadena($_POST["tipoMoneda"]) : "";
$totalletra = isset($_POST["totalletra"]) ? limpiarCadena($_POST["totalletra"]) : "";
$condicion = isset($_POST["condicion"]) ? limpiarCadena($_POST["condicion"]) : "";
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'listar':
		$rspta = $letrasCartera->listar();
		//declaramos un array
		$data = array();
		//https://wiki.php.net/rfc/ternary_associativity
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion == 1) ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>'
					. ' ' . '<button class="btn btn-warning btn-xs" onclick="pagoLetra(' . $reg->idletra . ',&apos;' . $reg->nombre . '&apos;)"><i class="fa fa-pencil"></i></button>'
					: '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>',
				"1" => $reg->idletra,
				"2" => $reg->nombre,
				"3" => $reg->tipo_letra,
				"4" => $reg->num_letra,
				"5" => $reg->num_factura,
				"6" => $reg->lugar_giro,
				"7" => $reg->fecha_emi,
				"8" => $reg->fecha_ven,
				"9" => $reg->moneda,
				"10" => $reg->total,
				"11" => $reg->condicion == 1 ? '<span class="label bg-red">Pendiente</span>'
					: '<span class="label bg-green">Pagado</span>'
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
		if (empty($idletra)) {
			$rspta = $letrasCartera->insertar(
				$id_cliente,
				$tipoletra,
				$numeroletra,
				$numerofactura,
				$lugargiro,
				$fechaemision,
				$fechavencimiento,
				$tipoMoneda,
				$totalletra,
				$condicion,
				$fechagrabacion
			);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del Trabajador";
			//echo $rspta;
		} else {
			//echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
			//echo $rspta;
		}

		break;

	case 'mostrar':
		$rspta = $letrasCartera->mostrar($idletra);
		echo json_encode($rspta);
		//echo $rspta;
		break;

	case 'actualizarEstado':
		$rspta = $letrasCartera->actualizarEstado($idletra, $condicion);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		//echo $rspta;
		break;

	case 'obtieneDeudaPendiente':
		$rspta = $letrasCartera->obtieneDeudaPendiente($idletra);
		//echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		echo json_encode($rspta);
		break;
}
