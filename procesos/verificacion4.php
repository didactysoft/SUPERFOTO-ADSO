<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();

$verificacion = 0;

if($_POST['inputDescripcion'] != '')
{
	$verificacion += 1;
}
if($_POST['inputValor'] != '')
{
	$verificacion += 1;
}

echo $verificacion;

?>