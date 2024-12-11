<?php 
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();

	$datos=array(
		$_POST['inputDescripcion'],
		$_POST['inputCosto'],
		$_POST['inputTipo'],
		$_POST['inputMetodo']
		);
	echo $obj->agregar_cuenta($datos);
 ?>