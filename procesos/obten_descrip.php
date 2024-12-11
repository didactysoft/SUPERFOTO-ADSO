<?php 

date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();


$cod_trabajo = $_POST['cod_trabajo'];

$sql="SELECT `descripción` FROM `trabajos` WHERE cod_trabajo='$cod_trabajo'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

echo nl2br($ver[0]);

?>