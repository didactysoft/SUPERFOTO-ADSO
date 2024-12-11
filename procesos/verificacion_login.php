<?php 

session_start();

require_once "../clases/conexion.php";

$obj= new conectar();
$conexion=$obj->conexion();

$cedula = $_POST['input_cedula'];
$contraseña = $_POST['input_contraseña'];

$contraseña = md5($contraseña);

$sql="SELECT `cedula`, `contraseña`, `nombre`, `rol` FROM `empleados` WHERE cedula='$cedula'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

if ($ver[0] == '')
{
	$verificacion = 0;
}
else
{
	if ($ver[1] == $contraseña)
	{
		$verificacion = $ver[2];
		$_SESSION['usuario'] = $ver[0];
		$_SESSION['rol'] = $ver[3];
	}
	else
	{
		$verificacion = 1;
	}
}

echo $verificacion;

?>