<?php 
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();

$datos=array(
	$_POST['int_cod_servicio_h'],
	$_POST['int_valor']
);

echo $obj->add_descuento_crud($datos);


?>