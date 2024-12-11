<?php 


date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

session_start();
if (isset($_SESSION['usuario']))
{

	$cod_producto = $_POST['input_producto'];

	$sql="SELECT `cod_producto`, `descripción`, `valor`, `stock`, `fecha_modificacion` FROM `productos` WHERE cod_producto='$cod_producto'";
	$result=mysqli_query($conexion,$sql);
	$ver=mysqli_fetch_row($result);
	if ($ver[0] == '')
	{
		echo 2;
	}
	else
	{
		if (isset($_SESSION['productos']))
		{
			$productos = $_SESSION['productos'];
			$cant = count($productos);

			$productos[$cant +1]['cod_producto'] = $ver[0];

			if ($_POST['cant_producto'] == '')
			{
				$productos[$cant +1]['cant_producto'] = 1;
				$_SESSION['productos'] = $productos;
			}
			else
			{
				$productos[$cant +1]['cant_producto'] = $_POST['cant_producto'];
				$_SESSION['productos'] = $productos;
			}
		}
		else
		{
			$productos[1]['cod_producto'] = $ver[0];

			if ($_POST['cant_producto'] == '')
			{
				$productos[1]['cant_producto'] = 1;
				$_SESSION['productos'] = $productos;
			}
			else
			{
				$productos[1]['cant_producto'] = $_POST['cant_producto'];
				$_SESSION['productos'] = $productos;
			}
		}
	}
}

?>
