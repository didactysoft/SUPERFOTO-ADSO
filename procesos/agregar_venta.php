<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
$fecha_hora=date('Y-m-d G:i:s');

$cedula = $_POST['inputCedula'];
$descripcion = $_POST['inputDescripcion'];

$empleado = $_POST['inputEmpleado'];
$valor = $_POST['inputValor'];

if($_POST['inputSelect'] == '1')
{
	$descripcion = 'Corte Laser - ' . $descripcion;
}
if($_POST['inputSelect'] == '2')
{
	$descripcion = 'Sublimación - ' . $descripcion;
}
if($_POST['inputSelect'] == '3')
{
	$descripcion = 'Impresión Solvente - ' . $descripcion;
}

$sql_venta="INSERT INTO `ventas_directas`(`descripción`, `responsable`, `total`, `fecha_recepcion`, `cc_cliente`) VALUES (
'$descripcion',
'$empleado',
'$valor',
'".date('Y-m-d G:i:s')."',
'$cedula')";

$result_venta=mysqli_query($conexion,$sql_venta);

$sql="SELECT MAX(cod_venta)
as cod_venta  from ventas_directas";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$venta_num_print = $ver[0];

$venta_num = str_pad($ver[0],8,"0",STR_PAD_LEFT);

$descripcion_cuentas = 'Ingreso por venta directa #' . $venta_num ;
$cod_venta_reg = 'V'.$ver[0];

$sql_cuentas="INSERT INTO `cuentas_diarias`(`cod_trabajo`, `valor`, `descripcion`, `fecha`, `responsable`) VALUES (
'$cod_venta_reg',
'$valor',
'$descripcion_cuentas',
'".date('Y-m-d G:i:s')."',
'$empleado')";

$result_cuentas=mysqli_query($conexion,$sql_cuentas);

$cc_cliente = $cedula;

$sql="SELECT `puntos_actuales`, `puntos_totales` FROM `clientes` WHERE  cedula='$cc_cliente'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$ganados = $valor/1000;
$ganados = floor($ganados);
$actuales = $ver[0] + $ganados;
$totales = $ver[1] + $ganados;

$result_cuentas=mysqli_query($conexion,$sql_cuentas);

$sql="UPDATE `clientes` SET `puntos_actuales`='$actuales', `puntos_totales`='$totales' WHERE cedula='$cc_cliente'";
mysqli_query($conexion,$sql);

echo $venta_num_print;
?>