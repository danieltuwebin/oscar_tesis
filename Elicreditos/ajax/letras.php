<?php

session_start();
require_once "../modelos/Letras.php";

$letras = new Letras();

$idletra = isset($_POST["idletra"]) ? limpiarCadena($_POST["idletra"]) : "";
$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$id_cliente = isset($_POST["id_cliente"]) ? limpiarCadena($_POST["id_cliente"]) : "";
$tipoletra = isset($_POST["tipoletra"]) ? limpiarCadena($_POST["tipoletra"]) : "";
$numeroletra = isset($_POST["numeroletra"]) ? limpiarCadena($_POST["numeroletra"]) : "";
$numerofactura = isset($_POST["numerofactura"]) ? limpiarCadena($_POST["numerofactura"]) : "";
$lugargiro = isset($_POST["lugargiro"]) ? limpiarCadena($_POST["lugargiro"]) : "";
$fechaemision = isset($_POST["fechaemision"]) ? limpiarCadena($_POST["fechaemision"]) : "";
$fechavencimiento = isset($_POST["fechavencimiento"]) ? limpiarCadena($_POST["fechavencimiento"]) : "";
$numerounico = isset($_POST["numerounico"]) ? limpiarCadena($_POST["numerounico"]) : "";
$tipoMoneda = isset($_POST["tipoMoneda"]) ? limpiarCadena($_POST["tipoMoneda"]) : "";
$totalletra = isset($_POST["totalletra"]) ? limpiarCadena($_POST["totalletra"]) : "";
$condicion = isset($_POST["condicion"]) ? limpiarCadena($_POST["condicion"]) : "";
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'listar':
		$rspta = $letras->listar();
		//declaramos un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion == 1) ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>'
					. ' ' . '<button class="btn btn-warning btn-xs" onclick="pago(' . $reg->idletra .')"><i class="fa fa-pencil"></i></button>'
					. ' ' . '<button class="btn btn-success btn-xs" onclick="renovacion(' . $reg->idletra .')"><i class="fa fa-pencil"></i></button>'
					. ' ' . '<button class="btn btn-primary btn-xs" onclick="protesto(' . $reg->idletra .')"><i class="fa fa-pencil"></i></button>'
					: '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>',
				//"0" => $reg->idamortizacion,
				"1" => $reg->idletra,
				"2" => $reg->nombre,
				"3" => $reg->tipo_letra,
				"4" => $reg->num_letra,
				"5" => $reg->num_factura,
				"6" => $reg->lugar_giro,
				"7" => $reg->fecha_emi,
				"8" => $reg->fecha_ven,
				"9" => $reg->num_unico,
				"10" => $reg->moneda,
				"11" => $reg->total,
				"12" => ($reg->condicion == 1) ? '<span class="label bg-red">Pendiente</span>' : '<span class="label bg-green">Pagado</span>'
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