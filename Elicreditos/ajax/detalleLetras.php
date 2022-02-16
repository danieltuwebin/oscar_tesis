<?php

session_start();
require_once "../modelos/DetalleLetras.php";

$detalleLetras = new DetalleLetras();

$idLetraDetalle = isset($_POST["idLetraDetalle"]) ? limpiarCadena($_POST["idLetraDetalle"]) : "";
//$idLetra = isset($_POST["idLetra"]) ? limpiarCadena($_POST["idLetra"]) : "";
$idLetra = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$tipoLetraDetalle = isset($_POST["tipoLetraDetalle"]) ? limpiarCadena($_POST["tipoLetraDetalle"]) : "";
$montoidLetra = isset($_POST["montoidLetra"]) ? limpiarCadena($_POST["montoidLetra"]) : "";
$nombreDetalle = isset($_POST["nombreDetalle"]) ? limpiarCadena($_POST["nombreDetalle"]) : "";
$numeroPago = isset($_POST["numeroPago"]) ? limpiarCadena(strtoupper($_POST["numeroPago"])) : "";
$fechapago = isset($_POST["fechapago"]) ? limpiarCadena($_POST["fechapago"]) : "";
$fecharenovacion = isset($_POST["fecharenovacion"]) ? limpiarCadena($_POST["fecharenovacion"]) : "";
$fechavencimiento = isset($_POST["fechavencimiento"]) ? limpiarCadena($_POST["fechavencimiento"]) : "";
$fechaprotesto = isset($_POST["fechaprotesto"]) ? limpiarCadena($_POST["fechaprotesto"]) : "";
$comisionprotesto = isset($_POST["comisionprotesto"]) ? limpiarCadena(strtoupper($_POST["comisionprotesto"])) : "";
$montopagoDetalle = isset($_POST["montopagoDetalle"]) ? limpiarCadena($_POST["montopagoDetalle"]) : "";
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'listar':
		$rspta = $letras->listar();
		//declaramos un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion == 1) ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idletra . ')"><i class="fa fa-eye"></i></button>'
					. ' ' . '<button title="Pago Letra" class="btn btn-warning btn-xs" onclick="detalleLetra(' . $reg->idletra .',1'.')"><i class="fa fa-pencil"></i></button>'
					. ' ' . '<button title="Renovación" class="btn btn-success btn-xs" onclick="detalleLetra(' . $reg->idletra .',2'.')"><i class="fa fa-pencil"></i></button>'
					. ' ' . '<button title="Protesto" class="btn btn-primary btn-xs" onclick="detalleLetra(' . $reg->idletra .',3'.')"><i class="fa fa-pencil"></i></button>'
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
		if (empty($idLetra)) {
			$rspta = $detalleLetras->insertar(
				$idLetraDetalle,
				$tipoLetraDetalle,
				$numeroPago,
				$fechapago,
				$fecharenovacion,
				$fechavencimiento,
				$comisionprotesto,
				$fechaprotesto,
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
			echo "11111";
		}

		break;

	case 'mostrar':
		$rspta = $letras->mostrar($idletra);
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
