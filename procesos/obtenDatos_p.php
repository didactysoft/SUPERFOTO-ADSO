<?php 
	
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();



	echo json_encode($obj->obtenDatos_prod($_POST['cod_producto']));

 ?>