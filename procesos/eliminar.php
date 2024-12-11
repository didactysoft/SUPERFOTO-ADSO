<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();

if (isset($_POST['cod_cliente']))
{
	echo $obj->eliminar($_POST['cod_cliente']);
}
if (isset($_POST['cod_egreso']))
{
	echo $obj->eliminar_egreso($_POST['cod_egreso']);
}
if (isset($_POST['cod_producto']))
{
	echo $obj->eliminar_producto($_POST['cod_producto']);
}

if (isset($_POST['cod_material']))
{
	echo $obj->eliminar_material($_POST['cod_material']);
}



?>