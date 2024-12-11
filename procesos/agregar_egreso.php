<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
$fecha_hora=date('Y-m-d G:i:s');

$descripcion = $_POST['inputDescripcion'];
$valor = $_POST['inputValor'];


$sql_egreso="INSERT INTO `egresos`(`descripción`, `valor`, `fecha`) VALUES (
'$descripcion',
'$valor',
'".date('Y-m-d G:i:s')."')";

echo mysqli_query($conexion,$sql_egreso);

?>