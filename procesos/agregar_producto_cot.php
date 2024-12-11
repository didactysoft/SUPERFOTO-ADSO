<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

session_start();
if (isset($_SESSION['usuario']))
{
	if (isset($_POST['input_producto']))
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

				$productos[$cant +1]['descripcion'] = $ver[1];
				$productos[$cant +1]['valor_unitario'] = $ver[2];

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
				$productos[1]['descripcion'] = $ver[1];
				$productos[1]['valor_unitario'] = $ver[2];

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
	else
	{
		if (isset($_SESSION['productos']))
		{
			$productos = $_SESSION['productos'];
			$cant = count($productos);

			$descripcion = $_POST['inputDescripcion'];
			$cantidad = $_POST['inputCantidad'];
			$valor = $_POST['input_valor'];

			$productos[$cant +1]['descripcion'] = $descripcion;
			$productos[$cant +1]['valor_unitario'] = $valor;

			if ($cantidad == '')
			{
				$productos[$cant +1]['cant_producto'] = 1;
				$_SESSION['productos'] = $productos;
			}
			else
			{
				$productos[$cant +1]['cant_producto'] = $cantidad;
				$_SESSION['productos'] = $productos;
			}
		}
		else
		{
			$descripcion = $_POST['inputDescripcion'];
			$cantidad = $_POST['inputCantidad'];
			$valor = $_POST['input_valor'];

			$productos[1]['descripcion'] = $descripcion;
			$productos[1]['valor_unitario'] = $valor;

			if ($cantidad == '')
			{
				$productos[1]['cant_producto'] = 1;
				$_SESSION['productos'] = $productos;
			}
			else
			{
				$productos[1]['cant_producto'] = $cantidad;
				$_SESSION['productos'] = $productos;
			}
		}
	}
}

?>
