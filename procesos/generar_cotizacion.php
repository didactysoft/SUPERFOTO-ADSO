<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

session_start();
if (isset($_SESSION['usuario']))
{

	$cc_cliente = $_POST['inputCedula'];
	$empleado = $_POST['inputEmpleado'];
	$datos_cot = '';
	$productos = $_SESSION['productos'];
	foreach ($productos as $num_item => $producto)
	{
		$descripcion = $producto['descripcion'];
		$valor_unitario = $producto['valor_unitario'];
		$cant = $producto['cant_producto'];
		$valor_total = $valor_unitario * $cant;

		$datos_cot .= $cant.'!'.$descripcion.'!'.$valor_unitario.'!'.$valor_total.'!';
	}

	unset($_SESSION['productos']);

	$sql="INSERT INTO `cotizaciones`(`datos_cot`, `cc_cliente`, `cc_empleado`, `fecha`) VALUES (
	'$datos_cot',
	'$cc_cliente',
	'$empleado',
	'".date('Y-m-d')."')";

	mysqli_query($conexion,$sql);

	$sql="SELECT MAX(cod_cotizacion)
	as cod_cotizacion  from cotizaciones";
	$result=mysqli_query($conexion,$sql);
	$ver=mysqli_fetch_row($result);

	echo $ver[0];
}

?>
