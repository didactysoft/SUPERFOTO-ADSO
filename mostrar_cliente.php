<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$cod_cliente=$_GET['cod_cliente'];

session_start();
if (isset($_SESSION['usuario']))
{
	$usuario = $_SESSION['usuario'];

	$sql_e = "SELECT nombre, rol, foto FROM empleados WHERE cedula = '$usuario'";
	$result_e=mysqli_query($conexion,$sql_e);
	$ver_e=mysqli_fetch_row($result_e);

	$nombre_usuario = ' ' .  $ver_e[0];
	$rol = $ver_e[1];
	$foto_empleado = $ver_e[2];
}
?>
<!-- Panel Mostrar-->
<div class="container card">
	<br>
	<div class="container bg-primary text-center text-white p-1 h5 align-items-center">DETALLES DE CLIENTE</div>
	<br>
	<div class="bg-light container col-md-5 font-italic text-center ">Datos del Cliente</div>
	<div class="rounded container bg-light">
		<br>
		<div class="row">
			<label class="ml-2">Cédula o NIT: </label>
			<div class="font-italic form-group col-md-3 text-muted" name="vercedula" id="vercedula"><?php echo $cedula ?></div>
			<label>Nombre: </label>
			<div class="text-muted font-italic form-group col " name="vernombre" id="vernombre"><?php echo $nombre ?></div>
			<label>Teléfono: </label>
			<div class="font-italic form-group col text-muted" name="vertelefono" id="vertelefono"><?php echo $telefono ?></div>
		</div>
		<div class="row">
			<label class="ml-2">Dirección: </label>
			<div class="font-italic form-group col text-muted" name="verdireccion" id="verdireccion"><?php echo $direccion ?></div>
		</div>
		<div class="row">
			<label class="ml-2">Correo: </label>
			<div class="font-italic form-group col text-muted" name="vercorreo" id="vercorreo"><?php echo $actuales ?></div>
			<label>Puntos Actuales: </label>
			<div class="font-italic form-group col text-muted" name="veractuales" id="veractuales"><?php echo $actuales ?></div>
			<label>Puntos Totales: </label>
			<div class="font-italic form-group col text-muted" name="vertotales" id="vertotales"><?php echo $totales ?></div>
			<?php 
			if ($rol == 'admin')
			{
				?>
				<label class=" col-form-label">Cobrar Puntos: </label>
				<div class="mx-3">
					<input type="text" class="form-control form-control-sm" name="inputCant_puntos" id="inputCant_puntos" placeholder="Cantidad de Puntos" required="">
				</div>
				<div class="col-auto">
					<button class="btn btn-sm btn-primary" id="boton_buscar" onclick="cobrar_puntos('<?php echo $cod_cliente ?>')">Cobrar</button>
				</div>
				<?php 
			}
			?>
		</div>
	</div>
	<br>
	<div class="rounded-top bg-light container col-md-3 font-italic text-center ">Trabajos</div>
	<div class=" rounded bg-light">
		<br>
		<div id="tablaTrabajos"></div>
		<br>
	</div>
	<br>
</div>
<script type="text/javascript">

	function mostartrabajos(cod_cliente) {

		$(document).ready(function(){
			$('#tablaTrabajos').load('tablas/trabajos_cliente.php/?cod_cliente='+cod_cliente);
		});
	}
	mostarcliente('<?php echo $cod_cliente ?>');
	mostartrabajos('<?php echo $cod_cliente ?>');

	function cobrar_puntos()
	{
		cant_puntos = document.getElementById("inputCant_puntos").value;
		$.ajax({
			type:"POST",
			data:'cant_puntos='+cant_puntos,
			url:"procesos/cobrar_puntos.php",

			success:function(r)
			{
				if (r==2) 
				{
					alertify.error("Producto NO ENCONTRADO");
				}
				else
				{
					alertify.success("Producto AGREGADO"+r);
					$("#input_producto" ).val('');
					$("#cant_producto" ).val('');
					$('#tabla_productos_carrito').load('tablas/productos_trabajo.php');
					document.getElementById("div_productos_carrito").hidden = false;
					$('#div_tabla_productos_modal').load('tablas/productos.php/?agregar=1');
				}
			}
		});

	}

</script>