<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
require_once "../clases/crud.php";
$obj= new crud();
$obj_2= new conectar();

$conexion=$obj_2->conexion();

$cedula = $_POST['inputCedula_m'];

$sql="SELECT `cod_cliente`,`cedula` FROM `clientes` WHERE cedula='$cedula'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

if ($ver[0]!= '')
{
	echo -1;
}
else
{
	$datos=array(
		$_POST['inputCedula_m'],
		$_POST['inputNombre_Cliente_m'],
		$_POST['inputDireccion_m'],
		$_POST['inputTelefono_m'],
		$_POST['inputCorreo_m']
	);

	echo $obj->agregar($datos);
}
?>