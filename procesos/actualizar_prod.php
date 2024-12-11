<?php 
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();

$datos=array(
	$_POST['cod_productoU'],
	$_POST['descripcionU'],
	$_POST['valorU'],
	$_POST['stockU']
);

echo $obj->actualizar_prod($datos);

?>