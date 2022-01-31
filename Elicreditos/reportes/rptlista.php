<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['almacen']==1)
{

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE PRECIOS SOLES',1,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,6,utf8_decode('Código'),1,0,'C',1);
$pdf->Cell(58,6,'Nombre',1,0,'C',1); 
$pdf->Cell(25,6,utf8_decode('Categoría'),1,0,'C',1);
$pdf->Cell(12,6,'Stock',1,0,'C',1);
$pdf->Cell(15,6,'P.Venta',1,0,'C',1);

 
$pdf->Ln(10);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Articulo.php";
$articulo = new Articulo();

$rspta = $articulo->listarprecio();

//Table with rows and columns
$pdf->SetWidths(array(30,58,25,12,15,40));

while($reg= $rspta->fetch_object())
{  
    $codigo = $reg->codigo;
    $nombre = $reg->nombre;
    $categoria = $reg->categoria;
    $stock = $reg->stock.' '.$reg->unidad;
    $preciounit = $reg->preciounit;
   
 	
 	$pdf->SetFont('Arial','',8);
    $pdf->Row(array($codigo,utf8_decode($nombre),utf8_decode($categoria),$stock,$preciounit));
}
 
//Mostramos el documento pdf
$pdf->Output();

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>