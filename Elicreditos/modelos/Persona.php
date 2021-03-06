<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";
 
Class Persona
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$contacto,$direccion,$telefono,$email)
    {
        $sql="INSERT INTO persona (tipo_persona,nombre,tipo_documento,num_documento,contacto,direccion,telefono,email,estado)
        VALUES ('$tipo_persona','$nombre','$tipo_documento','$num_documento','$contacto','$direccion','$telefono','$email','1')";
        return ejecutarConsulta($sql);
        //return $sql;
    }
 
    //Implementamos un método para editar registros
    public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$contacto,$direccion,$telefono,$email)
    {
        $sql="UPDATE persona SET tipo_persona='$tipo_persona',nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',contacto='$contacto',direccion='$direccion',telefono='$telefono',email='$email' WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para eliminar categorías
    public function eliminar($idpersona)
    {
        $sql="DELETE FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idpersona)
    {
        $sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros
   
    public function listar()
    {
        $sql="SELECT p.idpersona,p.nombre,p.tipo_persona,p.iddocumento,d.documento,p.numerodoc,p.telefono,p.email FROM persona p INNER JOIN documentopersona d ON p.iddocumento=d.iddocumento";
        return ejecutarConsulta($sql);
    }

    public function listar_Persona()
    {
        $sql="SELECT idpersona, tipo_persona, UPPER(nombre) as nombre, tipo_documento, num_documento, contacto, direccion, telefono, email FROM persona WHERE estado = 1";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listarp()
    {
        $sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros 
    public function listarc()
    {
        $sql="SELECT * FROM persona WHERE tipo_persona='Cliente'";
        return ejecutarConsulta($sql);      
    }    
}
