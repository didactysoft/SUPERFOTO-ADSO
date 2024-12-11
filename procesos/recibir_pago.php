<?php 
	
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();

	$datos=array(
		$_POST['cod_trabajo'],
		$_POST['valor']
		);

	echo $obj->recibir_pago_crud($datos);

 ?>