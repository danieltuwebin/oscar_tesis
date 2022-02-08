<?php

session_start();
require_once "../modelos/PagoAmortizacion.php";

$pagoAmortizacion = new PagoAmortizacion();

$idamortizacionDetalle = isset($_POST["idamortizacionDetalle"]) ? limpiarCadena($_POST["idamortizacionDetalle"]) : "";
$numeroreciboDetalle = isset($_POST["numeroreciboDetalle"]) ? limpiarCadena($_POST["numeroreciboDetalle"]) : "";
$numerooperacionDetalle = isset($_POST["numerooperacionDetalle"]) ? limpiarCadena($_POST["numerooperacionDetalle"]) : "";
$descripcionDetalle = isset($_POST["descripcionDetalle"]) ? limpiarCadena($_POST["descripcionDetalle"]) : "";
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
}
