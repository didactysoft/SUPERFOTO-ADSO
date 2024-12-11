<?php 


date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

session_start();
if (isset($_SESSION['usuario']))
{
	$num_producto = $_POST['num_producto'];
	unset($_SESSION['productos'][$num_producto]);

	$productos = $_SESSION['productos'];
	$cantidad_prod = count($productos);
	if ($cantidad_prod == 0)
	{
		unset($_SESSION['productos']);
		echo 2;
	}
	else
	{
		$num_item = 1;
		foreach ($productos as $num => $producto)
		{
			$descripcion = $producto['descripcion'];
			$valor = $producto['valor_unitario'];
			$cant = $producto['cant_producto'];

			$nuevo_productos[$num_item]['cant_producto'] = $cant;
			$nuevo_productos[$num_item]['descripcion'] = $descripcion;
			$nuevo_productos[$num_item]['valor_unitario'] = $valor;
			$num_item += 1;
		}
		$_SESSION['productos'] = $nuevo_productos;	
		echo 1;
	}
}

?>
