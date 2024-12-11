<?php 
	
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();

	$datos=array(
		$_POST['inputDescripcion'],
		$_POST['inputcod_trabajo'],
		$_POST['input_total'],
		$_POST['input_ruta'],
		$_POST['input_empleado']
		);

	echo $obj->editar_trabajo_crud($datos);

 ?>