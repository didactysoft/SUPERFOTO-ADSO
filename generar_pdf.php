<?php
require('librerias/fpdf/fpdf.php');

date_default_timezone_set('America/Bogota');
require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();


class PDF extends FPDF
{
// Cabecera de página
	function Header()
	{
		$fecha=date('d/m/Y');
		//$fecha = date('d/m/Y',$fecha);

		$this->AddFont('GOTHIC','','GOTHIC.php');
		$this->AddFont('GOTHICB','','GOTHICB.php');
	// Fondo
		$this->Image('img/pdf/fondo.jpg',0,0,216);
    // Logo
		$this->Image('img/pdf/logo.png',10,10,55);
    // Arial bold 15
		$this->SetFont('GOTHIC','',12);
    // Título
		$this->SetXY(165,8);
		$this->Cell(40,6,'Nit 1094248144-0',0,0,'R');
		$this->SetFont('GOTHICB','',12);
		$this->SetTextColor(255,0,0);
		$this->SetXY(165,14);
		$this->Cell(40,6,$fecha,0,0,'R');
		$this->SetFont('GOTHIC','',12);
		$this->SetTextColor(0,0,0);
		$this->SetXY(165,20);
		$this->Cell(40,6,utf8_decode('www.arquidiseños.com'),0,0,'R');
    // Salto de línea
		$this->Ln(20);
	}
}

// Variables
$cod_cotizacion = $_POST['cod_cotizacion'];

$sql="SELECT `cod_cotizacion`, `datos_cot`, `cc_cliente`, `cc_empleado`, `fecha` FROM `cotizaciones` WHERE cod_cotizacion='$cod_cotizacion'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$sql_cliente="SELECT `nombre` FROM `clientes` WHERE cedula='$ver[2]'";
$result_cliente=mysqli_query($conexion,$sql_cliente);
$ver_cliente=mysqli_fetch_row($result_cliente);

$Cliente = $ver_cliente[0];
$datos_cot = $ver[1];

$items = explode("!", $datos_cot);

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetXY(14,60);
$pdf->SetFont('GOTHIC','',12);
$pdf->Cell(24,6,utf8_decode('SEÑORES:'),0,0,'L');

$pdf->SetXY(14,66);
$pdf->SetFont('GOTHICB','',12);
$pdf->Cell(150,6,utf8_decode($Cliente),0,0,'L');

$pdf->SetXY(14,72);
$pdf->SetFont('GOTHIC','',11);
$pdf->Cell(24,6,utf8_decode('Cordial Saludo.'),0,0,'L');

$pdf->SetXY(14,81);
$pdf->SetFont('GOTHICB','',12);
$pdf->SetTextColor(255,0,0);
$pdf->Cell(150,6,utf8_decode('DESCRIPCIÓN'),0,0,'L');

$pdf->SetTextColor(0,0,0);

$pdf->SetXY(14,87);
$pdf->SetFont('GOTHICB','',12);
$pdf->Cell(150,6,utf8_decode('TIPO'),0,0,'L');

$pdf->SetXY(128,87);
$pdf->SetFont('GOTHICB','',12);
$pdf->Cell(18,6,utf8_decode('UNIDAD'),0,0,'C');

$pdf->SetXY(149,87);
$pdf->SetFont('GOTHICB','',12);
$pdf->Cell(34,6,utf8_decode('VALOR/UNIDAD'),0,0,'C');

$pdf->SetXY(185,87);
$pdf->SetFont('GOTHICB','',12);
$pdf->Cell(15,6,utf8_decode('TOTAL'),0,0,'C');

$pos_y = 93;
$cont = count($items)-1;

for ($i=0; $i < $cont; $i+=4)
{
	$pdf->SetXY(14,$pos_y);
	$pdf->SetFont('GOTHIC','',11);
	$pdf->MultiCell(112,5,utf8_decode($items[$i+1]),0,'L',0);
	$nueva_pos_y = $pdf->GetY();

	$pdf->SetXY(128,$pos_y);
	$pdf->SetFont('GOTHIC','',12);
	$pdf->Cell(18,6,utf8_decode($items[$i]),0,0,'C');

	$pdf->SetXY(149,$pos_y);
	$pdf->SetFont('GOTHIC','',12);
	$pdf->Cell(34,6,utf8_decode('$'.number_format($items[$i+2])),0,0,'C');

	$pdf->SetXY(185,$pos_y);
	$pdf->SetFont('GOTHICB','',12);
	$pdf->Cell(15,6,utf8_decode('$'.number_format($items[$i+3])),0,0,'C');
	$pos_y = $nueva_pos_y+2;
}

$pdf->SetXY(18,235);
$pdf->SetFont('GOTHICB','',12);
$pdf->Cell(50,6,utf8_decode('GUSTAVO PICON MORENO'),0,0,'C');
$pdf->SetXY(18,239);
$pdf->SetFont('GOTHIC','',10);
$pdf->Cell(50,6,utf8_decode('Gerente Comercial'),0,0,'C');

$pdf->SetTextColor(255,0,0);
$pdf->SetXY(99,245);
$pdf->SetFont('GOTHICB','',8);
$pdf->Cell(92,6,utf8_decode('VENCE : 60 DIAS'),0,0,'R');

$pdf->SetTextColor(0,0,0);
$pdf->SetXY(99,248);
$pdf->SetFont('GOTHICB','',8);
$pdf->Cell(92,6,utf8_decode('EL PAGO SE EFECTUARÁ  50% ADELANTADO Y 50% A LA ENTREGA'),0,0,'R');

$pdf->SetXY(30,261);
$pdf->SetFont('GOTHICB','',8);
$pdf->Cell(92,6,utf8_decode('CALLE 4 N 4-50 CENTRO PAMPLONA N.de.S'),0,0,'R');

$pdf->SetXY(100,261);
$pdf->SetFont('GOTHICB','',8);
$pdf->Cell(92,6,utf8_decode('AV 8  13-23 CENTRO CUCUTA N.DE.S'),0,0,'R');

$pdf->SetXY(30,265);
$pdf->SetFont('GOTHIC','',8);
$pdf->Cell(92,6,utf8_decode('568 29 20-311 2329428'),0,0,'R');

$pdf->SetXY(100,265);
$pdf->SetFont('GOTHIC','',8);
$pdf->Cell(92,6,utf8_decode('568 30 06 - 313 4799815'),0,0,'R');

$pdf->SetXY(124,261);
$pdf->SetDrawColor(255,0,0);
$pdf->SetFillColor(255,0,0);
$pdf->Cell(0.5,15,'',1,1,'C',true);

$pdf->SetXY(195,261);
$pdf->SetDrawColor(255,0,0);
$pdf->SetFillColor(255,0,0);
$pdf->Cell(0.5,15,'',1,1,'C',true);

$pdf->SetTitle('Cotizacion #'.$cod_cotizacion);
$pdf->SetAuthor('Witsoft - Desarrollo de Software');

$pdf->Output('i','cotizacion_'.$cod_cotizacion);




?>