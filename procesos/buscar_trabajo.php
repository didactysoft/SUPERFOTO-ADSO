<?php 
date_default_timezone_set('America/Bogota');
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
$fecha_hora=date('Y-m-d G:i:s');

$cod_orden = $_POST['input_buscar_trabajo'];
if ($cod_orden=='')
{
	echo -2;
}
else
{
	$sql="SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `total`, `abono`, `fecha_entrega`, `hora_entrega`, `fecha_recepcion`, `ruta` FROM `trabajos` WHERE cod_trabajo='$cod_orden'";
	$result=mysqli_query($conexion,$sql);
	$ver=mysqli_fetch_row($result);
	if ($ver[0]!='')
	{
		echo $ver[0];
	}
	else
	{
		echo -1;
	}
}

?>