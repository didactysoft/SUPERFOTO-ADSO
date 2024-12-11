<?php 
	
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();

	$datos=array(
		$_POST['int_cod_orden_2']
				);

	echo $obj->inicio_trabajo_crud($datos);

 ?>