<?php
require_once "../modelos/Persona.php";

$persona = new Persona();

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$tipo_persona = isset($_POST["tipo_persona"]) ? limpiarCadena($_POST["tipo_persona"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$iddocumento = isset($_POST["iddocumento"]) ? limpiarCadena($_POST["iddocumento"]) : "";
$numerodoc = isset($_POST["numerodoc"]) ? limpiarCadena($_POST["numerodoc"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idpersona)) {
            $rspta = $persona->insertar($tipo_persona, $nombre, $iddocumento, $numerodoc, $direccion, $telefono, $email);
            echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
        } else {
            $rspta = $persona->editar($idpersona, $tipo_persona, $nombre, $iddocumento, $numerodoc, $direccion, $telefono, $email);
            echo $rspta ? "Persona actualizada" : "Persona no se pudo actualizar";
        }
        break;

    case 'eliminar':
        $rspta = $persona->eliminar($idpersona);
        echo $rspta ? "Persona eliminada" : "Persona no se puede eliminar";
        break;

    case 'mostrar':
        $rspta = $persona->mostrar($idpersona);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $persona->listar();
        //Vamos a declarar un array
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg->idpersona . ')"><i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="eliminar(' . $reg->idpersona . ')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->tipo_persona,
                "3" => $reg->documento . ' : ' . $reg->numerodoc,
                "4" => $reg->telefono,
                "5" => $reg->email
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case "selectDocumento":
        require_once "../modelos/Docpersona.php";
        $docpersona = new Docpersona();

        $rspta = $docpersona->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->iddocumento . '>' . $reg->documento . '</option>';
        }
        break;

    case "SelectPersona":
        $rspta = $persona->listar_Persona();
        echo '<option value=""> --Seleccione cliente-- </option>';
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
        }
        break;
}
