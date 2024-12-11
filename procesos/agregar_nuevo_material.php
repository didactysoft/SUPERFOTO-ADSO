<?php 
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();

$datos=array(
	$_POST['inputNombre_Material_m']
);

echo $obj->agregar_nuevo_material($datos);
?>