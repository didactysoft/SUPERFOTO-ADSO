<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();

$verificacion = 0;

if($_POST['inputLargo'] != '')
{
	$verificacion += 1;
}
if($_POST['inputAncho'] != '')
{
	$verificacion += 1;
}
if($_POST['inputValor'] != '')
{
	$verificacion += 1;
}
if($_POST['tipo_material'] != '')
{
	$verificacion += 1;
}

echo $verificacion;

?>