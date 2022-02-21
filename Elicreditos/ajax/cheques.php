<?php

session_start();
require_once "../modelos/Cheques.php";

$cheques = new Cheques();

$idcheque = isset($_POST["idcheque"]) ? limpiarCadena($_POST["idcheque"]) : "";
$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$id_cliente = isset($_POST["id_cliente"]) ? limpiarCadena($_POST["id_cliente"]) : "";
$tipocheque = isset($_POST["tipocheque"]) ? limpiarCadena($_POST["tipocheque"]) : "";
$banco = isset($_POST["banco"]) ? limpiarCadena($_POST["banco"]) : "";
$tipodocumento = isset($_POST["tipodocumento"]) ? limpiarCadena(strtoupper($_POST["tipodocumento"])) : "";
$numerodocumento = isset($_POST["numerodocumento"]) ? limpiarCadena($_POST["numerodocumento"]) : "";
$fechaemision = isset($_POST["fechaemision"]) ? limpiarCadena($_POST["fechaemision"]) : "";
$fechavencimiento = isset($_POST["fechavencimiento"]) ? limpiarCadena($_POST["fechavencimiento"]) : "";
$tipoMoneda = isset($_POST["tipoMoneda"]) ? limpiarCadena($_POST["tipoMoneda"]) : "";
$monto = isset($_POST["monto"]) ? limpiarCadena($_POST["monto"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$condicion = isset($_POST["condicion"]) ? limpiarCadena($_POST["condicion"]) : "";

// Para Fecha
$date = date('Y-m-d H:i:s');
$newDate = strtotime('-2 hour', strtotime($date));
$fechagrabacion = date('Y-m-d H:i:s', $newDate);

switch ($_GET["op"]) {

	case 'listar':
		$rspta = $cheques->listar();
		//declaramos un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion == 1) ? '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idcheques . ')"><i class="fa fa-eye"></i></button>'
					. ' ' . '<button class="btn btn-warning btn-xs" onclick="pagoCheque(' . $reg->idcheques .',&apos;'. $reg->nombre .'&apos;)"><i class="fa fa-pencil"></i></button>'
					: '<button class="btn btn-info btn-xs" onclick="mostrar(' . $reg->idcheques . ')"><i class="fa fa-eye"></i></button>',
				//"0" => $reg->idamortizacion,
				"1" => $reg->idcheques,
				"2" => $reg->nombre,
				"3" => $reg->tipo_cheque,
				"4" => $reg->bco_cheque,
				"5" => $reg->doc_pago,
				"6" => $reg->num_docpago,
				"7" => $reg->fecha_emi,
				"8" => $reg->fecha_ven,
				"9" => $reg->moneda,
				"10" => $reg->monto,
				"11" => '<a href="../files/cheques/'.$reg->imagen.'" target="_blank">Visualizar</a>',
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
		 
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
        {
            $imagen=$_POST["imagenactual"];
        }
        else
        {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
            {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/cheques/" . $imagen);
            }
        }

		if (empty($idcheque)) {
			$rspta = $cheques->insertar(
				$id_cliente,
				$tipocheque,
				$banco,
				$tipodocumento,
				$numerodocumento,
				$fechaemision,
				$fechavencimiento,
				$tipoMoneda,
				$monto,
				$imagen,
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
		$rspta = $cheques->mostrar($idcheque);
		echo json_encode($rspta);
		//echo $rspta;
		break;

	case 'actualizarEstado':
		$rspta = $cheques->actualizarEstado($idcheque);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo desactivar los datos";
		//echo $rspta;

		//echo $idcheque. ' ---';
		break;
}
