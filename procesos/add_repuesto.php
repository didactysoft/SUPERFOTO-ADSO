<?php 
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();

	$datos=array(
		$_POST['int_cod_orden_3'],
		$_POST['repuesto_n'],
		$_POST['precio_n']
				);

	echo $obj->add_repuesto_crud($datos);
	

 ?>