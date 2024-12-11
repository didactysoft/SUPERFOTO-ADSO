<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
$fecha_hora=date('Y-m-d G:i:s');

session_start();


$cedula = $_POST['inputCedula'];
$descripcion = $_POST['inputDescripcion'];
$fecha = $_POST['inputFecha'];
$hora = $_POST['inputHora'];
$titulo = $_POST['inputTitulo'];
if ($_POST['inputRuta'] == 'Ruta')
{
	$ruta = '';
}
else
{
	$ruta = $_POST['inputRuta'];
}

$empleado = $_POST['inputEmpleado'];
$valor = $_POST['inputValor'];
$abono = $_POST['inputAbono'];

$total_productos = 0;

$sql="SELECT MAX(cod_trabajo)
as cod_trabajo, `responsable` from trabajos";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$orden_num_1 = 1;
$orden_num_1 += $ver[0];

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
		$valor = $ver_producto[2];

		$stock = $ver_producto[3]-$cant;

		$sql="UPDATE `productos` SET `stock`= '$stock' WHERE cod_producto = '$cod_producto'";
		mysqli_query($conexion,$sql);

		$sql_productos="INSERT INTO `productos_vendidos`(`descripción`, `cantidad`, `valor`, `cod_trabajo`, `fecha`) VALUES (
		'$descripcion_producto',
		'$cant',
		'$valor',
		'$orden_num_1',
		'".date('Y-m-d G:i:s')."')";

		$result_productos=mysqli_query($conexion,$sql_productos);

		unset($_SESSION['productos']);
	}
}
$valor += $total_productos;

$sql_trabajo="INSERT INTO `trabajos`(`cc_cliente`, `titulo`, `descripción`, `estado`, `responsable`, `total`, `abono`, `fecha_entrega`, `hora_entrega`, `fecha_recepcion`, `ruta`) VALUES (
'$cedula',
'$titulo',
'$descripcion',
'PENDIENTE',
'$empleado',
'$valor',
'$abono',
'$fecha',
'$hora',
'".date('Y-m-d G:i:s')."',
'$ruta')";

$result_trabajo=mysqli_query($conexion,$sql_trabajo);

$sql="SELECT MAX(cod_trabajo)
as cod_trabajo, `responsable` from trabajos";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$venta_num_print = $ver[0];

$orden_num = str_pad($ver[0],8,"0",STR_PAD_LEFT);

$descripcion_cuentas = 'Ingreso por generacion de orden de servicio #' . $orden_num ;

$sql_cuentas="INSERT INTO `cuentas_diarias`(`cod_trabajo`, `valor`, `descripcion`, `fecha`, `responsable`) VALUES (
'$ver[0]',
'$abono',
'$descripcion_cuentas',
'".date('Y-m-d G:i:s')."',
'$empleado')";

$result_cuentas=mysqli_query($conexion,$sql_cuentas);

$cc_cliente = $cedula;

$sql="SELECT `puntos_actuales`, `puntos_totales` FROM `clientes` WHERE  cedula='$cc_cliente'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$ganados = $abono/1000;
$ganados = floor($ganados);
$actuales = $ver[0] + $ganados;
$totales = $ver[1] + $ganados;

$result_cuentas=mysqli_query($conexion,$sql_cuentas);

$sql="UPDATE `clientes` SET `puntos_actuales`='$actuales', `puntos_totales`='$totales' WHERE cedula='$cc_cliente'";
mysqli_query($conexion,$sql);

echo $venta_num_print;
?>