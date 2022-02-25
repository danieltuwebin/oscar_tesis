<?php
ob_start();
session_start();
require_once "../modelos/Letras.php";

$letras = new Letras();

$idletra = isset($_POST["idletra"]) ? limpiarCadena($_POST["idletra"]) : "";
$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$id_cliente = isset($_POST["id_cliente"]) ? limpiarCadena($_POST["id_cliente"]) : "";
$tipoletra = isset($_POST["tipoletra"]) ? limpiarCadena($_POST["tipoletra"]) : "";
$numeroletra = isset($_POST["numeroletra"]) ? limpiarCadena(strtoupper($_POST["numeroletra"])) : "";
$numerofactura = isset($_POST["numerofactura"]) ? limpiarCadena(strtoupper($_POST["numerofactura"])) : "";
$lugargiro = isset($_POST["lugargiro"]) ? limpiarCadena($_POST["lugargiro"]) : "";
$fechaemision = isset($_POST["fechaemision"]) ? limpiarCadena($_POST["fechaemision"]) : "";
$fechavencimiento = isset($_POST["fechavencimiento"]) ? limpiarCadena($_POST["fechavencimiento"]) : "";
$numerounico = isset($_POST["numerounico"]) ? limpiarCadena(strtoupper($_POST["numerounico"])) : "";
$tipoMoneda = isset($_POST["tipoMoneda"]) ? limpiarCadena($_POST["tipoMoneda"]) : "";
$totalletra = isset($_POST["totalletra"]) ? limpiarCadena($_POST["totalletra"]) : "";
$condicion = isset($_POST["condicion"]) ? limpiarCadena($_POST["condicion"]) : "";

// Para Fecha
$date = date('Y-m-d H:i:s');
$newDate = strtotime('-2 hour', strtotime($date));
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'listar':
		$rspta = $letras->listar();
		//declaramos un array
		$data = array();

		//https://wiki.php.net/rfc/ternary_associativity
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->condicion == 1 ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>'
					. ' ' . '<button title="Pago Letra" class="btn btn-warning btn-xs" onclick="detalleLetra(' . $reg->idletra . ',1,' . $reg->total . ',' . $reg->idcliente . ')"><i class="fa fa-pencil"></i></button>'
					. ' ' . '<button title="Renovación" class="btn btn-success btn-xs" onclick="detalleLetra(' . $reg->idletra . ',2,' . $reg->total . ',' . $reg->idcliente . ')"><i class="fa fa-pencil"></i></button>'
					. ' ' . '<button title="Protesto" class="btn btn-primary btn-xs" onclick="detalleLetra(' . $reg->idletra . ',3,' . $reg->total . ',' . $reg->idcliente . ')"><i class="fa fa-pencil"></i></button>'
					: ($reg->condicion == 2 ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>'
						. ' ' . '<button title="Renovación" class="btn btn-success btn-xs" onclick="detalleLetra(' . $reg->idletra . ',2,' . $reg->total . ',' . $reg->idcliente . ')"><i class="fa fa-pencil"></i></button>'
						. ' ' . '<button title="Protesto" class="btn btn-primary btn-xs" onclick="detalleLetra(' . $reg->idletra . ',3,' . $reg->total . ',' . $reg->idcliente . ')"><i class="fa fa-pencil"></i></button>'
						: ($reg->condicion == 3 ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>'
							. ' ' . '<button title="Renovación" class="btn btn-success btn-xs" onclick="detalleLetra(' . $reg->idletra . ',2,' . $reg->total . ',' . $reg->idcliente . ')"><i class="fa fa-pencil"></i></button>'
							. ' ' . '<button title="Protesto" class="btn btn-primary btn-xs" onclick="detalleLetra(' . $reg->idletra . ',3,' . $reg->total . ',' . $reg->idcliente . ')"><i class="fa fa-pencil"></i></button>'
							: '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>')),
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
				"12" => $reg->condicion == 1 ? '<span class="label bg-red">Pendiente</span>'
					: ($reg->condicion == 2 ? '<span class="label bg-yellow">Renovado</span>'
						: ($reg->condicion == 3 ? '<span class="label bg-blue">Protestado</span>'
							: '<span class="label bg-green">Pagado</span>'))
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
		$rspta = $letras->listar();
		//declaramos un array
		$data = array();

		//https://wiki.php.net/rfc/ternary_associativity
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>',
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
				"12" => $reg->condicion == 1 ? '<span class="label bg-red">Pendiente</span>'
					: ($reg->condicion == 2 ? '<span class="label bg-yellow">Renovado</span>'
						: ($reg->condicion == 3 ? '<span class="label bg-blue">Protestado</span>'
							: '<span class="label bg-green">Pagado</span>'))
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
			$rspta = $letras->insertar(
				$id_cliente,
				$tipoletra,
				$numeroletra,
				$numerofactura,
				$lugargiro,
				$fechaemision,
				$fechavencimiento,
				$numerounico,
				$tipoMoneda,
				$totalletra,
				$condicion,
				$fechagrabacion
			);

			//echo $id_cliente.'-'.$tipoletra.'-'.$numeroletra.'-'.$numerofactura.'-'.$lugargiro.'-'.
			//--$fechaemision.'-'.$fechavencimiento.'-'.$numerounico.'-'.$tipoMoneda.'-'.$totalletra.'-'.$condicion.'-'.$fechagrabacion;
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del Trabajador";
			//echo $rspta;

		} else {
			//$rspta = $amortizacion->editar($id_formacion, $id_trabajador, $nivelEducativo, $gradoEducativo, $nombreProfesion, $numeroColegiatura, $maestria, $doctorado, $institucionEducativa, $fechaExpedicionTitulo);
			//echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
			//echo $rspta;
		}

		break;

	case 'mostrar':
		$rspta = $letras->mostrar($idletra);
		echo json_encode($rspta);
		//echo $rspta;
		//echo '1234 '.$idamortizacion;
		break;

	case 'actualizarEstado':
		$rspta = $letras->actualizarEstado($idletra, $condicion);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		//echo $rspta;
		break;

	case 'actualizarNumeroUnico':
		$rspta = $letras->actualizarNumeroUnico($idletra, $numerounico);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		//echo $rspta;
		break;

	case 'obtieneDeudaPendiente':
		$rspta = $letras->obtieneDeudaPendiente($idletra);
		//echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		echo json_encode($rspta);
		break;
}
