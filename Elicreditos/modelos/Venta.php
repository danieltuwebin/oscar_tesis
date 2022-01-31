<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Venta
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idcliente,$idusuario,$idcomprobante,$serie_comprobante,$num_comprobante,$fecha_emision,$impuesto,$nroorden,$total_venta,$total_soles,$idarticulo,$cantidad,$precio_venta,$descuento)
    {
        $sql="INSERT INTO venta (idcliente,idusuario,idcomprobante,serie_comprobante,num_comprobante,fecha_emision,impuesto,nroorden,total_venta,total_soles,estado)
        VALUES ('$idcliente','$idusuario','$idcomprobante','$serie_comprobante','$num_comprobante','$fecha_emision','$impuesto','$nroorden','$total_venta','$total_soles','0')";
        //return ejecutarConsulta($sql);
        $idventanew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($idarticulo))
        {
            $sql_detalle = "INSERT INTO detalle_venta(idventa,idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
 
     
    //Implementamos un método para anular la venta
    public function anular($idventa)
    {
        $sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
        return ejecutarConsulta($sql);
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idventa)
    {
        $sql="SELECT v.idventa,DATE(v.fecha_emision) as emision,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.idcomprobante,c.tipocomprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.total_soles,v.impuesto,v.nroorden,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN comprobante c on v.idcomprobante=c.idcomprobante WHERE v.idventa='$idventa'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
 
    public function listarDetalle($idventa)
    {
        $sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv 
            inner join articulo a on dv.idarticulo=a.idarticulo  where dv.idventa='$idventa'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
   public function listar()
    {
        $sql="SELECT v.idventa,DATE(v.fecha_emision) as emision,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.idcomprobante,c.tipocomprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN comprobante c on v.idcomprobante=c.idcomprobante ORDER by v.idventa desc";
        return ejecutarConsulta($sql);      
    }
    
    public function ventacabecera($idventa){
        $sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.iddocumento,d.documento,p.numerodoc,p.email,p.telefono,v.idusuario,u.nombre as usuario,c.tipocomprobante,v.serie_comprobante,v.num_comprobante,DATE(v.fecha_emision) as emision,v.impuesto,v.total_venta FROM venta v INNER JOIN comprobante c on v.idcomprobante=c.idcomprobante INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN documentopersona d on p.iddocumento=d.iddocumento INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
        return ejecutarConsulta($sql);
    }

    public function ventadetalle($idventa){
        $sql="SELECT a.nombre as articulo,u.nombre as unidad,a.codigo,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv INNER JOIN articulo a ON dv.idarticulo=a.idarticulo INNER JOIN Unidad u on a.idunidad=u.idunidad WHERE dv.idventa='$idventa'";
        return ejecutarConsulta($sql);
    }
    public function listarMaxId($tipocomprobante)
    {
        $sql="SELECT LPAD(count(*)+1,8, '0')  AS num_comprobante FROM venta v inner join comprobante c on v.idcomprobante=c.idcomprobante WHERE substr( c.tipocomprobante,1,1)=substr('$tipocomprobante',1,1)";
        return ejecutarConsultaSimpleFila($sql);      
    }   
}
?>