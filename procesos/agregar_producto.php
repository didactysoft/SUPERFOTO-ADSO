<?php 
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();

$datos=array(
	$_POST['inputDescripcion'],
	$_POST['inputValor'],
	$_POST['inputStock']
);

echo $obj->agregar_producto($datos);
?>