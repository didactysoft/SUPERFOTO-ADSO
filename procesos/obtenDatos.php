<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();


if (isset($_POST['cod_cliente']))
{
	echo json_encode($obj->obtenDatos($_POST['cod_cliente']));
}
else
{

	if (isset($_POST['ver_Cedula']))
	{
		echo json_encode($obj->obtenDatos_cliente($_POST['ver_Cedula']));
	}
	else
	{
		if (isset($_POST['cod_cita']))
		{
			echo json_encode($obj->obtenDatos_cita($_POST['cod_cita']));
		}
		else
		{
			echo json_encode($obj->obtenDatos_trabajo($_POST['cod_trabajo']));
		}
	}
}
?>
