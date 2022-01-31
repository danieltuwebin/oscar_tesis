<?php 
require_once "../modelos/Consultas.php";

$consultas=new Consultas();

switch ($_GET["op"]){
	
    case 'ventasfechacliente':
    $fecha_inicio=$_REQUEST["fecha_inicio"];
    $fecha_fin=$_REQUEST["fecha_fin"];
    $idcliente=$_REQUEST["idcliente"];
        $rspta=$consultas->ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente);
        //Vamos a declarar un array
        $data= Array();

         while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->emision,
                "1"=>$reg->usuario,
                "2"=>$reg->cliente,
                "3"=>$reg->tipocomprobante,
                "4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                "5"=>$reg->total_venta,
                "6"=>$reg->impuesto,
                "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
                '<span class="label bg-red">Anulado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;
    
}

?>