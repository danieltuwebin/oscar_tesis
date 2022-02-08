<?php

session_start();
require_once "../modelos/TipoDocumento.php";

$tipoDocumento = new TipoDocumento();

switch ($_GET["op"]) {

	case "SelectTipoDocumento":
		$rspta = $tipoDocumento->listar();
		echo '<option value=""> --Seleccione Documento-- </option>';
		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
		}
		break;
}
