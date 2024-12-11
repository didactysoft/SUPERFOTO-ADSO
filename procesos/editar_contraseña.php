<?php 

require_once "../clases/conexion.php";
require_once "../clases/crud.php";

$obj= new crud();




$contraseña = $_POST['input_contraseña'];
$contraseña_1 = $_POST['input_contraseña_1'];
$contraseña_2 = $_POST['input_contraseña_2'];

if ($contraseña == '')
{
	echo 'Ingrese su contraseña actual';
}
else
{
	if ($contraseña_1 == '')
	{
		echo 'Ingrese una contraseña nueva';
	}
	else
	{
		if ($contraseña_2 == '')
		{
			echo 'Repita la contraseña nueva';
		}
		else
		{
			if ($contraseña_1 != $contraseña_2)
			{
				echo 'Las contraseñas no coinciden';
			}
			else
			{
				$datos=array(
					$_POST['cc_usuario'],
					$contraseña,
					$contraseña_1,
					$contraseña_2
				);
				echo $obj->editar_contraseña_crud($datos);
			}
		}
	}
}
?>