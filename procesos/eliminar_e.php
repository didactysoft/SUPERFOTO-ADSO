<?php 
	
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();

	echo $obj->eliminar_emp($_POST['cod_empleado']);

 ?>