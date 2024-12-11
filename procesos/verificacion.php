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
if($_POST['inputTitulo'] != '')
{
	$verificacion += 1;
}
if($_POST['inputRuta'] != '')
{
	$verificacion += 1;
}
if($_POST['inputRuta'] == '')
{
	$verificacion += 1;
}
if($_POST['inputDescripcion'] != '')
{
	$verificacion += 1;
}
if($_POST['inputFecha'] != '')
{
	$verificacion += 1;
}
if($_POST['inputHora'] != '')
{
	$verificacion += 1;
}
if($_POST['inputEmpleado'] != '')
{
	$verificacion += 1;
}
if($_POST['inputValor'] != '')
{
	$verificacion += 1;
}
if($_POST['inputAbono'] != '')
{
	$verificacion += 1;
}

echo $verificacion;

?>