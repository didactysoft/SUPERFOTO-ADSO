<?php 
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();

$datos=array(
	$_POST['cod_clienteU'],
	$_POST['cedulaU'],
	$_POST['nombreU'],
	$_POST['telefonoU'],
	$_POST['direccionU'],
	$_POST['correoU']
);

echo $obj->actualizar($datos);

?>