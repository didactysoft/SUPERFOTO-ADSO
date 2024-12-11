<?php 

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$sql = "SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `rol`, `fecha_registro` FROM `empleados` WHERE cod_empleado>1 AND rol != 'inactivo'";
$result=mysqli_query($conexion,$sql);

$nombre_tabla = 'EMPLEADOS';

?>
<div class="card container" >
	<span class="btn boton_peq btn-primary derecha_arriba" id="boton_productos" data-toggle="modal" data-target="#modal_agregar_empleado">Agregar Empleado Nuevo</span>
	<div class="card-header text-center">
		<h4><?php echo $nombre_tabla ?></h4>
	</div>
	<br>
	<table class="table table-striped table-sm table-bordered" id="tabla_empleados">
		<thead>
			<tr class="text-center">
				<th>Color</th>
				<th>Cédula o NIT</th>
				<th>Nombre</th>
				<th>Direccion</th>
				<th>Teléfono</th>
				<!--<th>Detalles</th>-->
			</tr>
		</thead>
		<div class="overflow-auto">
			<tbody class="overflow-auto">
				<?php 
				while ($mostrar=mysqli_fetch_row($result)) 
				{ 
					?>
					<tr>
						<td style="background-color: <?php echo $mostrar[7] ?>"></td>
						<td><?php echo $mostrar[1] ?></td>
						<td><?php echo $mostrar[2] ?></td>
						<td><?php echo $mostrar[5] ?></td>
						<td><?php echo $mostrar[6] ?></td>
						<!--<td class="text-center">
							<a class="badge badge-info text-white" onclick="llamarempleado('<?php echo $mostrar[0] ?>')">
								<span class="fa fa-info-circle"></span>
							</a>
							 
							<a class="badge badge-warning text-black" data-toggle="modal" data-target="#modalEditar" onclick="agregaFrmActualizar('<?php echo $mostrar[0] ?>')">
								<span class="fa fa-pencil-square-o"></span>
							</a>
						
						<a class="badge badge-danger text-white" onclick="eliminarempleado('<?php echo $mostrar[0] ?>')">
							<span class="fa fa-trash"></span>
						</a>
					-->
				</td>
			</tr>
			<?php 
		} 
		?>
	</tbody>
</div>
</table>
<br>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#tabla_empleados').DataTable();
	} );
</script>