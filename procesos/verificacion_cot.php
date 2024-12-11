<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();

$verificacion = 1;
session_start();

if($_POST['inputCedula'] == '')
{
	$verificacion = 2;
}
if($_POST['inputNombre'] == '')
{
	$verificacion = 2;
}
if (!isset($_SESSION['productos']))
{
	$verificacion = 3;
}


echo $verificacion;

?>