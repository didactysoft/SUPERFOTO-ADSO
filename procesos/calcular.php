<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$valor = $_POST['inputValor'];
$abono = $_POST['inputAbono'];

session_start();

if ($valor == '' || $valor < 0)
{
	$saldo = -1;
}
else
{
	if ($abono == '' || $abono < 0)
	{
		$saldo = -1;
	}
	else
	{


		$total_productos = 0;

		if (isset($_SESSION['productos']))
		{
			$productos = $_SESSION['productos'];

			foreach ($productos as $num_item => $producto)
			{
				$cod_producto = $producto['cod_producto'];
				$sql_producto = "SELECT `cod_producto`, `descripción`, `valor`, `stock`, `fecha_modificacion` FROM `productos` WHERE cod_producto = '$cod_producto'";
				$result_producto=mysqli_query($conexion,$sql_producto);
				$ver_producto=mysqli_fetch_row($result_producto);
				$cant = $producto['cant_producto'];
				$descripcion_producto = $ver_producto[1];

				$total_productos += $ver_producto[2]*$cant;
			}
		}

		$saldo = $valor + $total_productos - $abono;
	}
}
echo $saldo;


?>