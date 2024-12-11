<?php 

require_once "../clases/conexion.php";

$obj= new conectar();
$conexion=$obj->conexion();

$verificacion = 0;

$recibido = 0;

if(($_POST['inputValor_recibido']) != '')
{
	$recibido += $_POST['inputValor_recibido'];
	$cod_trabajo = $_POST['inputcod_trabajo'];

	$sql="SELECT `total`, `abono` FROM `trabajos` WHERE cod_trabajo='$cod_trabajo'";
	$result=mysqli_query($conexion,$sql);
	$ver=mysqli_fetch_row($result);

	$total = 0;
	$abono = 0;

	$total += $ver[0];
	$abono += $ver[1];

	$saldo = $total - $abono;

	if ($saldo >= $recibido)
	{
		$verificacion += $recibido;
	}
	else
	{
		$verificacion = -2;
	}

	
}
else
{
	$verificacion = -1;
}

echo $verificacion;

?>