<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
$fecha_hora=date('Y-m-d G:i:s');

$largo = $_POST['inputLargo'];
$ancho = $_POST['inputAncho'];
$valor = $_POST['inputValor'];
$tipo = $_POST['tipo_material'];


$sql_egreso="INSERT INTO `material`(`largo`, `ancho`, `valor`, `tipo_material`, `fecha`) VALUES (
'$largo',
'$ancho',
'$valor',
'$tipo',
'".date('Y-m-d G:i:s')."')";

echo mysqli_query($conexion,$sql_egreso);

?>