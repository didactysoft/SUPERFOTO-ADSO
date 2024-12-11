<?php 
date_default_timezone_set('America/Bogota');

class crud{
	public function agregar($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="INSERT INTO `clientes`(`cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro`) VALUES (
		'$datos[0]',
		'$datos[1]',
		'$datos[2]',
		'$datos[3]',
		'$datos[4]',
		'0',
		'0',
		'".date('Y-m-d')."')";

		return mysqli_query($conexion,$sql);

	}

	public function agregar_nuevo_material($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="INSERT INTO `tipos_material`(`nombre`, `estado`, `Fecha`) VALUES (
		'$datos[0]',
		'ACTIVO',
		'".date('Y-m-d')."')";

		return mysqli_query($conexion,$sql);

	}

	public function agregar_producto($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="INSERT INTO `productos`(`descripción`, `valor`, `stock`, `fecha_modificacion`) VALUES (
		'$datos[0]',
		'$datos[1]',
		'$datos[2]',
		'".date('Y-m-d H:i:s')."')";

		return mysqli_query($conexion,$sql);

	}

	public function agregarV($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="INSERT into vehiculos (placa,marca,linea,modelo,cc_propietario)
		values ('$datos[0]',
		'$datos[1]',
		'$datos[2]',
		'$datos[3]',
		'$datos[4]'";
		return mysqli_query($conexion,$sql);
	}

	public function agregar_emp($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$contraseña_md5 = md5($datos[0]);
		$r = rand(0,255);
		$g = rand(0,255);
		$b = rand(0,255);
		$color = 'rgb('.$r.','.$g.',.'.$b.')';

		if ($datos[4] == 1)
		{
			$rol = 'user';
		}
		else
		{
			$rol = 'admin';
		}

		$sql="INSERT INTO `empleados`(`cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `rol`, `fecha_registro`) VALUES (
		'$datos[0]',
		'$datos[1]',
		'$contraseña_md5',
		'img/avatar.svg',
		'$datos[2]',
		'$datos[3]',
		'$color',
		'$rol',
		'".date('Y-m-d')."')";

		return mysqli_query($conexion,$sql);

	}

	public function agregar_cuenta($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="INSERT INTO `cuentas`(`tipo`, `descripcion`, `valor`, `metodo`, `fecha_trans`,`hora_trans`) VALUES
		('$datos[2]',
		'$datos[0]',
		'$datos[1]',
		'$datos[3]',
		'".date('Y-m-d')."',
		'".date('H:i:s')."')";

		return mysqli_query($conexion,$sql);

	}

	public function actualizar($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="UPDATE clientes set cedula='$datos[1]',
		nombre='$datos[2]',
		direccion='$datos[3]',
		telefono='$datos[4]',
		correo='$datos[5]'
		where cod_cliente='$datos[0]'";
		return mysqli_query($conexion,$sql);
	}

	public function actualizar_prod($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="UPDATE `productos` SET 
		`descripción`='$datos[1]',
		`valor`='$datos[2]',
		`stock`='$datos[3]',
		`fecha_modificacion`='".date('Y-m-d G:i:s')."' 
		WHERE cod_producto='$datos[0]'";
		return mysqli_query($conexion,$sql);
	}

	public function obtenDatos($codcliente){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cod_cliente='$codcliente'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$datos=array(
			'cod_cliente' => $ver[0],
			'cedula' => $ver[1],
			'nombre' => $ver[2],
			'direccion' => $ver[3],
			'telefono' => $ver[4],
			'correo' => $ver[5],
			'puntos_actuales' => $ver[6],
			'puntos_totales' => $ver[7],
			'fecha_registro' => $ver[8]
		);
		return $datos;
	}

	public function obtenDatos_prod($cod_producto){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `cod_producto`, `descripción`, `valor`, `stock`, `fecha_modificacion` FROM `productos` WHERE cod_producto='$cod_producto'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$datos=array(
			'cod_producto' => $ver[0],
			'descripción' => $ver[1],
			'valor' => $ver[2],
			'stock' => $ver[3]
		);
		return $datos;
	}

	public function obtenDatos_cita($cod_cita){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `cod_cita`, `placa`, `fecha_cita`, `fecha_fin`, `hora_cita`, `hora_fin`, `observaciones`, `area`, `fecha_registro`, `hora_registro` FROM `citas` WHERE cod_cita='$cod_cita'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$datos=array(
			'cod_cita' => $ver[0],
			'placa' => $ver[1],
			'fecha_cita' => $ver[2],
			'fecha_fin' => $ver[3],
			'hora_cita' => $ver[4],
			'hora_fin' => $ver[5],
			'observaciones' => $ver[6],
			'area' => $ver[7]
		);
		return $datos;
	}


	public function obtenDatos_cliente($cc_cliente){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cedula='$cc_cliente'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		if ($ver[1]==NULL) 
		{
			$datos=array(
				'cedula' => $cc_cliente,
				'nombre' => 'NO ENCONTRADO',
				'direccion' => $ver[4],
				'telefono' => $ver[5]
			);
		}
		else
		{
			$datos=array(
				'cedula' => $ver[1],
				'nombre' => $ver[2],
				'direccion' => $ver[4],
				'telefono' => $ver[5]
			);
		}
		return $datos;
	}


	public function obtenCuentas_crud(){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$fecha=date('Y-m-d');

		$sql="SELECT `tipo`, `descripcion`, `valor`, `metodo` , `fecha_trans` 
		FROM `cuentas` 
		WHERE fecha_trans='$fecha'";
		$result=mysqli_query($conexion,$sql);

		$ingresos=0;
		$egresos=0;
		$efectivo=0;
		$datafono=0;
		while ($ver=mysqli_fetch_row($result)) 
		{
			if ($ver[0]=='i') 
			{
				$ingresos +=$ver[2];
				if ($ver[3]=='d') 
				{
					$datafono +=$ver[2];
				}
			}
			if ($ver[0]=='e') 
			{
				$egresos +=$ver[2];
			}
		};

		$efectivo=$ingresos-$egresos-$datafono;

		$efectivo= number_format($efectivo);
		$datafono= number_format($datafono);
		$ingresos= number_format($ingresos);
		$egresos= number_format($egresos);

		$datos=array(
			'ingresos' => $ingresos,
			'egresos' => $egresos,
			'efectivo' => $efectivo,
			'datafono' => $datafono
		);
		return $datos;
	}
	

	public function obtenDatos_emp($codempleado){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `rol`, `fecha_registro` FROM `empleados` WHERE cod_empleado='$codempleado'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$datos=array(
			'cod_empleado' => $ver[0],
			'cedula' => $ver[1],
			'nombre' => $ver[2],
			'contraseña' => $ver[3],
			'foto' => $ver[3],
			'direccion' => $ver[4],
			'telefono' => $ver[5],
			'color' => $ver[5],
			'rol' => $ver[5]
		);
		return $datos;
	}

	public function terminar_trabajo_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="UPDATE `trabajos` SET `estado`='TERMINADO' WHERE cod_trabajo = '$datos'";
		return mysqli_query($conexion,$sql);
	}

	public function entregar_trabajo_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `total`, `abono`, `responsable`, `cc_cliente` FROM `trabajos` WHERE cod_trabajo='$datos[0]'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$total = 0;
		$abono = 0;
		$recibido = 0;
		$total += $ver[0];
		$abono += $ver[1];
		$recibido += $datos[1];

		$saldo = $total - $abono;

		$orden_num = str_pad($datos[0],8,"0",STR_PAD_LEFT);

		$descripcion_cuentas = 'Ingreso por entrega trabajo #' . $orden_num ;

		$cc_empleado = $ver[2];

		$sql_cuentas="INSERT INTO `cuentas_diarias`(`cod_trabajo`, `valor`, `descripcion`, `fecha`, `responsable`) VALUES (
		'$datos[0]',
		'$recibido',
		'$descripcion_cuentas',
		'".date('Y-m-d G:i:s')."',
		'$cc_empleado')";

		$cc_cliente = $ver[3];

		$sql="SELECT `puntos_actuales`, `puntos_totales` FROM `clientes` WHERE  cedula='$cc_cliente'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$ganados = $recibido/1000;
		$ganados = floor($ganados);
		$actuales = $ver[0] + $ganados;
		$totales = $ver[1] + $ganados;

		$result_cuentas=mysqli_query($conexion,$sql_cuentas);

		$sql="UPDATE `clientes` SET `puntos_actuales`='$actuales', `puntos_totales`='$totales' WHERE cedula='$cc_cliente'";
		mysqli_query($conexion,$sql);

		if ($saldo != 0)
		{
			if ($saldo > $recibido)
			{
				$abono += $recibido;
				$valor_deuda = 0;
				$valor_deuda = $total - ( $abono );
				$sql_deuda="INSERT INTO `deudas`(`cod_trabajo`, `valor`, `fecha_creacion`, `estado`)
				VALUES
				('$datos[0]',
				'$valor_deuda',
				'".date('Y-m-d H:i:s')."',
				'EN MORA')";
				mysqli_query($conexion,$sql_deuda);
			}
			else
			{
				$abono += $recibido;
			}
			$sql="UPDATE `trabajos` SET `estado`='ENTREGADO', `abono`='$abono' WHERE cod_trabajo = '$datos[0]'";
			return mysqli_query($conexion,$sql);
		}
		else
		{
			$sql="UPDATE `trabajos` SET `estado`='ENTREGADO' WHERE cod_trabajo = '$datos[0]'";
			return mysqli_query($conexion,$sql);
		}


	}

	public function recibir_pago_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `total`, `abono`, `responsable`, `cc_cliente` FROM `trabajos` WHERE cod_trabajo='$datos[0]'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$total = 0;
		$abono = 0;
		$recibido = 0;
		$total += $ver[0];
		$abono += $ver[1];
		$recibido += $datos[1];

		$saldo = $total - $abono;

		$orden_num = str_pad($datos[0],8,"0",STR_PAD_LEFT);

		$cc_empleado = $ver[2];

		if ($saldo > $recibido)
		{
			$abono += $recibido;
			$valor_deuda = 0;
			$valor_deuda = $total - ( $abono );
			$sql_deuda="UPDATE `deudas` SET `valor`='$valor_deuda' WHERE cod_trabajo = '$datos[0]'";
			mysqli_query($conexion,$sql_deuda);

			$descripcion_cuentas = 'Ingreso por abono deuda de trabajo #' . $orden_num ;
		}
		else
		{
			$abono += $recibido;
			$sql_abono_deuda="UPDATE `deudas` SET `estado`='PAGADO' WHERE cod_trabajo = '$datos[0]'";
			mysqli_query($conexion,$sql_abono_deuda);

			$descripcion_cuentas = 'Ingreso por pago deuda de trabajo #' . $orden_num ;
		}
		$sql_cuentas="INSERT INTO `cuentas_diarias`(`cod_trabajo`, `valor`, `descripcion`, `fecha`, `responsable`) VALUES (
		'$datos[0]',
		'$recibido',
		'$descripcion_cuentas',
		'".date('Y-m-d G:i:s')."',
		'$cc_empleado')";

		$result_cuentas=mysqli_query($conexion,$sql_cuentas);

		$cc_cliente = $ver[3];

		$sql="SELECT `puntos_actuales`, `puntos_totales` FROM `clientes` WHERE  cedula='$cc_cliente'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$ganados = $recibido/1000;
		$ganados = floor($ganados);
		$actuales = $ver[0] + $ganados;
		$totales = $ver[1] + $ganados;

		$result_cuentas=mysqli_query($conexion,$sql_cuentas);

		$sql="UPDATE `clientes` SET `puntos_actuales`='$actuales', `puntos_totales`='$totales' WHERE cedula='$cc_cliente'";
		mysqli_query($conexion,$sql);

		
		$sql="UPDATE `trabajos` SET `abono`='$abono' WHERE cod_trabajo = '$datos[0]'";
		return mysqli_query($conexion,$sql);


	}

	public function editar_trabajo_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$cod_trabajo = $datos[1];
		$descrip = $datos[0];
		$ruta = $datos[3];
		$total = $datos[2];
		$cc_empleado = $datos[4];

		$sql="SELECT `abono` FROM `trabajos` WHERE cod_trabajo='$cod_trabajo'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		if ($total >= $ver[0])
		{
			$sql="UPDATE `trabajos` SET `descripción`='$descrip', `ruta`='$ruta', `total`='$total', `responsable`='$cc_empleado' WHERE cod_trabajo = '$cod_trabajo'";
			return mysqli_query($conexion,$sql);
		}
		else
		{
			return '2';
		}
	}

	public function editar_empleado_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="UPDATE empleados set 
		nombre='$datos[1]',
		direccion='$datos[2]',
		telefono='$datos[3]',
		color='$datos[4]'
		where cedula='$datos[0]'";
		return mysqli_query($conexion,$sql);
	}

	public function editar_contraseña_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `contraseña` FROM `empleados` WHERE cedula='$datos[0]'";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		$contraseña_md5 = md5($datos[1]);

		$contraseña_md5_nueva = md5($datos[2]);

		if ($ver[0] == $contraseña_md5)
		{
			$sql="UPDATE empleados set 
			contraseña='$contraseña_md5_nueva'
			where cedula='$datos[0]'";
			return mysqli_query($conexion,$sql);
		}
		else
		{
			return 'Contraseña Actual INCORRECTA';
		}

		
	}

	public function trabajo_pendiente_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="UPDATE `trabajos` SET `estado`='PENDIENTE' WHERE cod_trabajo = '$datos'";
		return mysqli_query($conexion,$sql);
	}
	
	public function actualizar_repuesto($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="UPDATE `repuestos_colocados` SET `descripcion`='$datos[1]',`costo`='$datos[2]' WHERE cod_repuesto='$datos[0]'";
		return mysqli_query($conexion,$sql);
	}

	public function actualizar_cita($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="UPDATE `citas` SET `cod_cita`='$datos[0]',`placa`='$datos[1]',`fecha_cita`='$datos[2]',`fecha_fin`='$datos[3]',`hora_cita`='$datos[4]',`hora_fin`='$datos[5]',`observaciones`='$datos[7]',`area`='$datos[6]' WHERE cod_cita='$datos[0]'";
		return mysqli_query($conexion,$sql);
	}

	public function eliminar($codcliente){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="DELETE from clientes where cod_cliente='$codcliente'";
		return mysqli_query($conexion,$sql);
	}

	public function eliminar_producto($cod_producto){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="DELETE from productos where cod_producto='$cod_producto'";
		return mysqli_query($conexion,$sql);
	}

	public function eliminar_material($cod_material){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="DELETE FROM `material` WHERE cod_material='$cod_material'";
		return mysqli_query($conexion,$sql);
	}


	public function eliminar_emp($codempleado){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="DELETE from empleados where cod_empleado='$codempleado'";
		return mysqli_query($conexion,$sql);
	}

	public function eliminar_egreso($codegreso){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="DELETE FROM `egresos` WHERE cod_egreso='$codegreso'";
		return mysqli_query($conexion,$sql);
	}
	
	public function eliminarV($codvehiculo){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="DELETE from vehiculos where cod_vehiculo='$codvehiculo'";
		return mysqli_query($conexion,$sql);
	}

	public function eliminar_trabajo_crud($cod_trabajo){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="DELETE FROM `trabajos` WHERE cod_trabajo='$cod_trabajo'";
		return mysqli_query($conexion,$sql);
	}

	public function reiniciar_material($cod_material){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql_material="SELECT `cod_material`, `nombre`, `estado`, `Fecha` FROM `tipos_material` WHERE cod_material='$cod_material'";
		$result_material = mysqli_query($conexion,$sql_material);
		$ver_material=mysqli_fetch_row($result_material);

		$sql="UPDATE `tipos_material` SET `estado`='TERMINADO' WHERE cod_material='$cod_material'";
		mysqli_query($conexion,$sql);

		$nombre_material = $ver_material[1];

		$sql="INSERT INTO `tipos_material`(`nombre`, `estado`, `Fecha`) VALUES (
		'$nombre_material',
		'ACTIVO',
		'".date('Y-m-d')."')";

		return mysqli_query($conexion,$sql);

	}

	public function add_obs_mecanico($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="SELECT `obs_mecanico`
		FROM `ordenes` 
		WHERE cod_orden='$datos[0]'";

		$result = mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);

		if ($ver[0]==NULL) 
		{
			$text_g = "$datos[1]";
		}
		else
		{
			$text_g = "$ver[0]" . '<br>' . "$datos[1]";
		}

		$sql="UPDATE ordenes set obs_mecanico='$text_g'
		where cod_orden='$datos[0]'";
		return mysqli_query($conexion,$sql);
	}

	public function add_repuesto_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="INSERT INTO `repuestos_colocados`(`cod_orden`, `descripcion`, `costo`) VALUES 
		('$datos[0]',
		'$datos[1]',
		'$datos[2]')";

		return mysqli_query($conexion,$sql);
	}

	public function add_servicio_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql="INSERT INTO `servicios`(`Nombre`, `costo`, `descuento`, `id_linea`) VALUES 
		('$datos[1]',
		'$datos[2]',
		'0',
		'$datos[3]')";

		mysqli_query($conexion,$sql);

		$sql_O="SELECT MAX(cod_servicio)
		as cod_servicio from servicios";
		$result_O=mysqli_query($conexion,$sql_O);
		$ver_O=mysqli_fetch_row($result_O);

		$sql_s="INSERT INTO `servicios_hechos`(`cod_orden`, `cod_servicio`, `estado`) VALUES
		('$datos[0]',
		'$ver_O[0]',
		'P')";

		return mysqli_query($conexion,$sql_s);
	}

	public function add_servicio_2_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql_s="INSERT INTO `servicios_hechos`(`cod_orden`, `cod_servicio`, `estado`) VALUES
		('$datos[0]',
		'$datos[1]',
		'P')";

		return mysqli_query($conexion,$sql_s);
	}

	public function add_descuento_crud($datos){
		$obj= new conectar();
		$conexion=$obj->conexion();

		$sql_s="UPDATE `servicios_hechos` set `descuento`='$datos[1]'
		WHERE cod_servicio_h='$datos[0]'";

		return mysqli_query($conexion,$sql_s);
	}
	

	public function inicio_trabajo_crud($datos)
	{
		$obj= new conectar();
		$conexion=$obj->conexion();

		$fecha=date('Y-m-d H:i:s');

		$sql="UPDATE ordenes set fecha_inicio='$fecha',
		estado='ACTIVO'
		WHERE cod_orden='$datos[0]'";
		return mysqli_query($conexion,$sql);

	}
	public function calcular_saldo($datos)
	{
		//$saldo = $datos[0] - $datos[1];
		$saldo = $datos[0];
		$datos=array(
			'saldo' => $saldo
		);

		return $datos;
	}

	public function play_servicio_crud($datos)
	{
		$obj= new conectar();
		$conexion=$obj->conexion();

		$fecha=date('Y-m-d H:i:s');
		$cod_s=$datos;

		$sql="UPDATE `servicios_hechos` SET `fecha_inicio`='$fecha', `estado`='A'
		WHERE cod_servicio_h='$cod_s'";
		return mysqli_query($conexion,$sql);
	}

	public function pause_servicio_crud($datos)
	{
		$obj= new conectar();
		$conexion=$obj->conexion();

		$fecha_a = date('Y-m-d H:i:s');
		$cod_s=$datos;

		$sql_f="SELECT `fecha_inicio` FROM `servicios_hechos` WHERE cod_servicio_h=$cod_s";
		$result_f=mysqli_query($conexion,$sql_f);
		$ver_f=mysqli_fetch_row($result_f);

		$fecha_g = $ver_f[0];

		$timeFirst  = strtotime($fecha_g);
		$timeSecond = strtotime($fecha_a);
		$differenceInSeconds = $timeSecond - $timeFirst;

		$sql_s="SELECT `tiempo` FROM `servicios_hechos` WHERE cod_servicio_h=$cod_s";
		$result_s=mysqli_query($conexion,$sql_s);
		$ver_s=mysqli_fetch_row($result_s);

		$tiempo = $ver_s[0] + $differenceInSeconds;

		$sql="UPDATE `servicios_hechos` SET `fecha_inicio`='0000-00-00 00:00:00',`tiempo`='$tiempo', `estado`='P'
		WHERE cod_servicio_h='$cod_s'";
		return mysqli_query($conexion,$sql);
	}

	public function stop_servicio_crud($datos)
	{
		$obj= new conectar();
		$conexion=$obj->conexion();

		$fecha_a = date('Y-m-d H:i:s');
		$cod_s=$datos;

		$sql_f="SELECT `fecha_inicio` FROM `servicios_hechos` WHERE cod_servicio_h=$cod_s";
		$result_f=mysqli_query($conexion,$sql_f);
		$ver_f=mysqli_fetch_row($result_f);

		$fecha_g = $ver_f[0];

		$timeFirst  = strtotime($fecha_g);
		$timeSecond = strtotime($fecha_a);
		$differenceInSeconds = $timeSecond - $timeFirst;

		$sql_s="SELECT `tiempo` FROM `servicios_hechos` WHERE cod_servicio_h=$cod_s";
		$result_s=mysqli_query($conexion,$sql_s);
		$ver_s=mysqli_fetch_row($result_s);

		$tiempo = $ver_s[0] + $differenceInSeconds;

		$sql="UPDATE `servicios_hechos` SET `fecha_inicio`='0000-00-00 00:00:00',`tiempo`='$tiempo', `estado`='T'
		WHERE cod_servicio_h='$cod_s'";
		return mysqli_query($conexion,$sql);
	}
}

?>