<?php 
	
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();

	echo $obj->trabajo_pendiente_crud($_POST['cod_trabajo']);

 ?>