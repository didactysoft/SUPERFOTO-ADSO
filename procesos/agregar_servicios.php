<?php 
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();

	$datos=array(
		$_POST['inputCedula'],
		$_POST['inputNombre_Cliente'],
		$_POST['inputOcupacion'],
		$_POST['inputDireccion'],
		$_POST['inputTelefono'],
		$_POST['inputCorreo'],
		$_POST['inputFacebook'],
		$_POST['inputPlaca'],
		$_POST['inputMarca'],
		$_POST['inputLinea'],
		$_POST['inputModelo'],
		$_POST['inputPreferencial']
		);

	echo $obj->agregar($datos);
 ?>