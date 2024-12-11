<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();

$Hex = $_POST['input_color_emp'];


if (substr($Hex,0,1) == "#")
	$Hex = substr($Hex,1);
$R = substr($Hex,0,2);
$G = substr($Hex,2,2);
$B = substr($Hex,4,2);

$R = hexdec($R);
$G = hexdec($G);
$B = hexdec($B);

$color = 'rgb('. $R . ',' . $G . ',' . $B . ')';

$datos=array(
	$_POST['cc_usuario'],
	$_POST['input_nombre_usuario'],
	$_POST['input_direccion'],
	$_POST['input_telefono'],
	$color
);

echo $obj->editar_empleado_crud($datos);

?>