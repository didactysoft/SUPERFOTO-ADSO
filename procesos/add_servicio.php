<?php 
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();

if (isset($_POST['int_cod_orden_4'])) 
{
	$datos=array(
		$_POST['int_cod_orden_4'],
		$_POST['servicio_n'],
		$_POST['precio_n'],
		$_POST['int_linea']
	);

	echo $obj->add_servicio_crud($datos);
}
else 
{

	if (isset($_POST['int_cod_orden_5']))
	{
		$datos=array(
			$_POST['int_cod_orden_5'],
			$_POST['inputServicio']
		);

		echo $obj->add_servicio_2_crud($datos);
	}
}


?>