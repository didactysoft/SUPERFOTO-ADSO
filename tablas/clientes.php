<?php 

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$sql="SELECT MAX(cod_cliente)
as cod_cliente  from clientes";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$busqueda = $_GET['input_buscar'];

$sql = "SELECT `cod_cliente`, `cedula`, `nombre`, `telefono` FROM `clientes`
WHERE `nombre` LIKE '%$busqueda%' OR `cedula` LIKE '%$busqueda%' OR `telefono` LIKE '%$busqueda%' ORDER BY `nombre` ASC";
$result=mysqli_query($conexion,$sql);

$nombre_tabla = 'CLIENTES';

?>
<div class="card container" >
	<div class="card-header text-center">
		<h4><?php echo $nombre_tabla ?></h4>
	</div>
	<br>
	<table class="table table-striped table-sm table-bordered" id="tabla_clientes">
		<thead>
			<tr class="text-center">
				<th>Cédula o NIT</th>
				<th>Nombre</th>
				<th>Teléfono</th>
				<th>Detalles</th>
			</tr>
		</thead>
		<div class="overflow-auto">
			<tbody class="overflow-auto">
				<?php 
				while ($mostrar=mysqli_fetch_row($result)) 
				{ 
					?>
					<tr>
						<td><?php echo $mostrar[1] ?></td>
						<td><?php echo $mostrar[2] ?></td>
						<td><?php echo $mostrar[3] ?></td>
						<td class="text-center">
							<a class="badge badge-info text-white" onclick="llamarcliente('<?php echo $mostrar[0] ?>')">
								<span class="fa fa-info-circle"></span>
							</a>
							<a class="badge badge-warning text-black" data-toggle="modal" data-target="#modalEditar" onclick="agregaFrmActualizar('<?php echo $mostrar[0] ?>')">
								<span class="fa fa-pencil-square-o"></span>
							</a>
							<a class="badge badge-danger text-white" onclick="eliminarCliente('<?php echo $mostrar[0] ?>')">
								<span class="fa fa-trash"></span>
							</a>
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
		$('#tabla_clientes').DataTable();
	} );
</script>