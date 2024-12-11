<?php

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();



if (isset($_POST['cod_venta']))
{
	$codigo = $_POST['cod_venta'];

	$sql_venta = "SELECT `cod_venta`, `descripción`, `responsable`, `total`, `fecha_recepcion`, `cc_cliente` FROM `ventas_directas` WHERE cod_venta = '$codigo'";
	$result_venta=mysqli_query($conexion,$sql_venta);
	$mostrar_venta=mysqli_fetch_row($result_venta);

	$total = $mostrar_venta[3];
	$total = number_format($total);

	$sql_empleados = "SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE cedula = '$mostrar_venta[2]'";
	$result_empleados=mysqli_query($conexion,$sql_empleados);
	$mostrar_empleados=mysqli_fetch_row($result_empleados);

	$responsable = substr($mostrar_empleados[2], 0, 30);

	$estado_trabajo = '';

	$descripcion = $mostrar_venta[1];

	$sql_cliente = "SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cedula = '$mostrar_venta[5]'";
	$result_cliente=mysqli_query($conexion,$sql_cliente);
	$mostrar_cliente=mysqli_fetch_row($result_cliente);

	$cliente = substr($mostrar_cliente[2], 0, 19);
	$telefono = $mostrar_cliente[4];
	$puntos = $mostrar_cliente[6];
}
else
{
	if (isset($_POST['cod_trabajo']))
	{
		$codigo = $_POST['cod_trabajo'];
	}
	else
	{
		$codigo = $_POST['cod_trabajo_c'];
	}

	$sql_trabajo = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `total`, `abono`, `fecha_entrega`, `hora_entrega`, `fecha_recepcion` FROM `trabajos` WHERE cod_trabajo = '$codigo'";
	$result_trabajo=mysqli_query($conexion,$sql_trabajo);
	$mostrar_trabajo=mysqli_fetch_row($result_trabajo);

	$sql_empleados = "SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE cedula = '$mostrar_trabajo[5]'";
	$result_empleados=mysqli_query($conexion,$sql_empleados);
	$mostrar_empleados=mysqli_fetch_row($result_empleados);

	$sql_cliente = "SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cedula = '$mostrar_trabajo[2]'";
	$result_cliente=mysqli_query($conexion,$sql_cliente);
	$mostrar_cliente=mysqli_fetch_row($result_cliente);

	$cliente = substr($mostrar_cliente[2], 0, 19);
	$telefono = $mostrar_cliente[4];
	$puntos = $mostrar_cliente[6];
	$fecha_entrega = strtotime($mostrar_trabajo[8]);
	$fecha_recepcion = $mostrar_trabajo[10];

	$dia = date('D',$fecha_entrega);

	if ($dia == 'Mon')
	{
		$dia = 'Lunes';
	}
	if ($dia == 'Tue')
	{
		$dia = 'Martes';
	}
	if ($dia == 'Wed')
	{
		$dia = 'Miercoles';
	}
	if ($dia == 'Thu')
	{
		$dia = 'Jueves';
	}
	if ($dia == 'Fri')
	{
		$dia = 'Viernes';
	}
	if ($dia == 'Sat')
	{
		$dia = 'Sabado';
	}
	if ($dia == 'Sun')
	{
		$dia = 'Domingo';
	}

	$fecha_entrega = $dia . ' ' . $mostrar_trabajo[8];
	$hora_entrega = strtotime($mostrar_trabajo[9]);
	$hora_entrega = date('g:i A',$hora_entrega);

	$responsable = substr($mostrar_empleados[2], 0, 33);

	$estado_trabajo = $mostrar_trabajo[4];

	$descripcion = $mostrar_trabajo[3];

	$sql_productos = "SELECT `cod_producto_vendido`, `descripción`, `cantidad`, `valor`, `cod_trabajo`, `fecha` FROM `productos_vendidos` WHERE cod_trabajo = '$codigo'";
	$result_productos=mysqli_query($conexion,$sql_productos);

	$mostrar_hay=mysqli_fetch_row($result_productos);
	if($mostrar_hay[0]=='')
	{
		$hay_productos =0;
	}
	else
	{
		$hay_productos = 1;
	}

	$sql_productos = "SELECT `cod_producto_vendido`, `descripción`, `cantidad`, `valor`, `cod_trabajo`, `fecha` FROM `productos_vendidos` WHERE cod_trabajo = '$codigo'";
	$result_productos=mysqli_query($conexion,$sql_productos);

	$total = $mostrar_trabajo[6];
	$abono = $mostrar_trabajo[7];
	$saldo = $total - $abono;
	$total = number_format($total);
	$abono = number_format($abono);

}
$codigo_pos = $codigo;
$codigo = str_pad($codigo,8,"0",STR_PAD_LEFT);



/*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/


/*
    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

	$nombre_impresora = "EPSON TM-T20II Receipt5"; 


	$connector = new WindowsPrintConnector($nombre_impresora);
	$printer = new Printer($connector);
#Mando un numero de respuesta para saber que se conecto correctamente.
	//echo 1;
/*
	Vamos a imprimir un logotipo
	opcional. Recuerda que esto
	no funcionará en todas las
	impresoras

	Pequeña nota: Es recomendable que la imagen no sea
	transparente (aunque sea png hay que quitar el canal alfa)
	y que tenga una resolución baja. En mi caso
	la imagen que uso es de 250 x 250
*/

# Vamos a alinear al centro lo próximo que imprimamos
	$printer->setJustification(Printer::JUSTIFY_CENTER);

/*
	Intentaremos cargar e imprimir
	el logo
*/

	try{
		$logo = EscposImage::load("img/Arqui_ticket.png", false);
		$printer->bitImage($logo);
	}catch(Exception $e){/*No hacemos nada si hay error*/}
/*
	Ahora vamos a imprimir un encabezado
*/

#La fecha también
	date_default_timezone_set('America/Bogota');
	$printer->text("NIT: 1094248144-0"."\n");
	$printer->text("Compromiso de Trabajo"."\n");
	$printer->text("Fecha Imp: " . date("d-m-Y h:i:s A")."\n\n");
	$printer->setJustification(Printer::JUSTIFY_CENTER);
	$printer->setBarcodeWidth(4);
	$printer->setBarcodeHeight(32);
	$printer->barcode($codigo_pos, Printer::BARCODE_CODE39);
	$printer->text("------------------------------------------------"."\n");
	$printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer -> setEmphasis(true);
	if (isset($_POST['cod_trabajo_c']))
	{
		$printer->text("Compromiso:       ");
	}
	if (isset($_POST['cod_venta']))
	{
		$printer->text("Venta:       ");
		$codigo_pos = "V".$codigo_pos;
		$codigo = "V".$codigo;
	}
	
	$printer -> setEmphasis(false);
	$printer -> setTextSize(2, 1);
	$printer->text($codigo . "\n");
	$printer -> setTextSize(1, 1);
	$printer->text("------------------------------------------------"."\n");
	if (isset($_POST['cod_trabajo_c']))
	{
		$printer -> setTextSize(2, 1);
		$printer -> setEmphasis(true);
		$printer->setJustification(Printer::JUSTIFY_CENTER);
		$printer->text("-- COPIA --" . "\n");
		$printer -> setTextSize(1, 1);
		$printer->text("------------------------------------------------"."\n");
	}
	if ($estado_trabajo == 'ENTREGADO')
	{
		$printer -> setTextSize(2, 1);
		$printer -> setEmphasis(true);
		$printer->setJustification(Printer::JUSTIFY_CENTER);
		$printer->text("-- ENTREGADO --" . "\n");
		$printer -> setTextSize(1, 1);
		$printer->text("------------------------------------------------"."\n");
	}

	$printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer -> setEmphasis(true);
	$printer -> text("Cliente: ");
	$printer -> setEmphasis(false);
	$printer -> setTextSize(2, 1);
	$printer->text($cliente . "\n");
	$printer -> setTextSize(1, 1);
	$printer -> setEmphasis(true);
	$printer -> text("Telefono: ");
	$printer -> setEmphasis(false);
	$printer->text($telefono . "\n");
	$printer -> setEmphasis(true);
	$printer -> text("Puntos Acumulados: ");
	$printer -> setEmphasis(false);
	$printer->text($puntos . "\n");
	$printer->text("------------------------------------------------"."\n");

	if (isset($_POST['cod_trabajo_c']) || isset($_POST['cod_trabajo']))
	{
		$printer -> setEmphasis(true);
		$printer -> text("\nFecha de Entrega: ");
		$printer -> setEmphasis(false);
		$printer->text($fecha_entrega . "\n");
		$printer -> setEmphasis(true);
		$printer -> text("Hora de Entrega: ");
		$printer -> setEmphasis(false);
		$printer->text($hora_entrega . "\n");
		$printer -> setEmphasis(true);
		$printer -> text("\nFecha de Recepción: ");
		$printer -> setEmphasis(false);
		$printer->text($fecha_recepcion . "\n");
		$printer -> setEmphasis(true);
		$printer->text("------------------------------------------------"."\n");
	}
	$printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer -> setEmphasis(true);
	$printer -> text("Descripción:");
	$printer -> setEmphasis(false);
	$printer->text("\n" . $descripcion . "\n");
	$printer->text("------------------------------------------------"."\n");

	if (!isset($_POST['cod_venta']))
	{
		if($hay_productos == 1)
		{
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer -> setEmphasis(true);
			$printer->text("CANT    DESCRIPCION       V. UNITARIO    TOTAL\n");
			$printer -> setEmphasis(false);
			$printer->text("------------------------------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$total_productos = 0;
			while($mostrar_productos=mysqli_fetch_row($result_productos))
			{
				$cant = $mostrar_productos[2];
				$descrip_trabajo = substr($mostrar_productos[1], 0,22);
				$descrip_trabajo = str_pad($descrip_trabajo,22," ",STR_PAD_RIGHT);
				$v_unitario = $mostrar_productos[3];
				$v_total = $mostrar_productos[3]*$mostrar_productos[2];
				$total_productos += $v_total;
				$v_unitario = number_format($v_unitario);
				$v_total = number_format($v_total);
				$v_unitario = str_pad($v_unitario,9," ",STR_PAD_LEFT);
				$v_total = str_pad($v_total,9," ",STR_PAD_LEFT);
				

				$printer->text("  ". $cant ." ". $descrip_trabajo ." $". $v_unitario." $". $v_total."\n");
			}
			$total_productos = number_format($total_productos);
			$total_productos = str_pad($total_productos,9," ",STR_PAD_LEFT);
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("----------------------"."\n");
			$printer->text("$ ". $total_productos."\n");
			$printer->text("------------------------------------------------"."\n");
		}
	}

	$printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer -> setEmphasis(true);
	$printer -> text("Responsable:");
	$printer -> setEmphasis(false);
	$printer->text($responsable . "\n");
	$printer->text("------------------------------------------------"."\n");
	$printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer -> setTextSize(2, 2);
	$printer -> setEmphasis(true);
	$printer -> text("TOTAL:");
	$printer -> setEmphasis(false);
	$printer->text(" $ " . $total . "\n");
	if (isset($_POST['cod_trabajo_c']) || isset($_POST['cod_trabajo']))
	{
		if ($saldo == 0)
		{
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer -> setEmphasis(true);
			$saldo = 'CANCELADO';
			$printer->text($saldo . "\n");
			$printer -> setEmphasis(false);
		}
		else
		{
			$printer -> setEmphasis(true);
			$printer -> text("ABONO:");
			$printer -> setEmphasis(false);
			$printer->text(" $ " . $abono . "\n");
			
			$printer -> setEmphasis(true);
			$printer -> text("SALDO:");
			$printer -> setEmphasis(false);
			$saldo = number_format($saldo);
			$printer->text(" $ " . $saldo . "\n");
		}
	}

	$printer -> setTextSize(1, 1);

/*
	Podemos poner también un pie de página
*/
	$printer->setJustification(Printer::JUSTIFY_CENTER);
	$printer->text("------------------------------------------------"."\n");
	$printer->text("\n******::::::::******\n");
	$printer -> setEmphasis(true);
	$printer -> text("\nCavpsoft");
	$printer -> setEmphasis(false);
	$printer->text(" - Desarrollo de Software\n");
	$printer->text("\nwww.facebook.com/Cavpsoft\n\n");

	$printer->setJustification(Printer::JUSTIFY_CENTER);
	try
	{
		$sello = EscposImage::load("img/Sello_ticket.png", false);
		$printer->bitImage($sello);
	}
	catch(Exception $e)
	{
		/*No hacemos nada si hay error*/
		$printer->text("\n");
		$printer->text("\n");
		$printer->text("\n");
		$printer->text("\n");
		$printer->text("\n");
	}
	

	/*Alimentamos el papel 3 veces*/
	$printer->feed(3);

/*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
	$printer->cut();

/*
	Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
	$printer->pulse();

/*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
	$printer->close();

	if (isset($_POST['cod_trabajo']) || isset($_POST['cod_trabajo_c']) || isset($_POST['cod_venta']))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

	?>