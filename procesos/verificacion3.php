<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();

$verificacion = 0;

if($_POST['inputCedula'] != '')
{
	$verificacion += 1;
}
if($_POST['inputNombre'] != '')
{
	$verificacion += 1;
}

if($_POST['inputSelect'] == '0')
{
	$verificacion += 1;
	if($_POST['inputDescripcion'] != '')
	{
		$verificacion += 1;
	}
}
else
{
	$verificacion += 2;
}
if($_POST['inputEmpleado'] != '')
{
	$verificacion += 1;
}
if($_POST['inputValor'] != '')
{
	$verificacion += 1;
}

echo $verificacion;

?>