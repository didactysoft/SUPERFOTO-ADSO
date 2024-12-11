<?php 
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();

$datos=array(
	$_POST['inputCedula'],
	$_POST['inputNombre'],
	$_POST['inputDireccion'],
	$_POST['inputTelefono'],
	$_POST['inputSelect']
);
echo $obj->agregar_emp($datos);
?>