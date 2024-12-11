<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

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

$nombre_tabla = 'Productos';

$sql = "SELECT `cod_producto`, `descripción`, `valor`, `stock`, `fecha_modificacion` FROM `productos` WHERE 1 order by descripción ASC";
$result=mysqli_query($conexion,$sql);

?>
<div class="card text-xsmall">
  <div class="table-responsive">
    <br>
    <table class="table table-striped table-sm table-bordered" id="tabla_productos">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Codigo</th>
          <th>Descripción</th>
          <th>Valor</th>
          <th>Stock</th>
          <th>Fecha</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <div class="overflow-auto">
        <tbody class="overflow-auto text-center">
          <?php 
          $num_item = 1;
          while ($mostrar=mysqli_fetch_row($result)) 
          {
            $fecha_modificacion = strtotime($mostrar[4]);
            $fecha_modificacion = date('d-m-Y g:i A',$fecha_modificacion);
            ?>
            <tr>
              <td><?php echo $num_item ?></td>
              <td class="h3"><?php echo str_pad($mostrar[0],5,"0",STR_PAD_LEFT) ?></td>
              <td class="text-left"><?php echo $mostrar[1] ?></td>
              <td class="text-right h4">$ <?php echo number_format($mostrar[2]); ?></td>
              <td><?php echo $mostrar[3] ?></td>
              <td><?php echo $fecha_modificacion ?></td>
              <td class="text-center">
                <?php 
                if (isset($_GET['agregar']))
                { 
                  ?>
                  <input type="number" class="form-control-xsm" id="int_cant_<?php echo $mostrar[0] ?>" name="int_cant_<?php echo $mostrar[0] ?>">
                  <a class="badge badge-success text-white" data-toggle="modal" data-target="#detalles_trabajo_modal" onclick="agregar_producto_desde_tabla('<?php echo $mostrar[0] ?>')">
                    <span class="fa fa-plus"></span>
                  </a>
                  <?php 
                }
                ?>
                <a class="badge badge-info text-white" data-toggle="modal" data-target="#detalles_trabajo_modal" onclick="detalles_producto('<?php echo $mostrar[0] ?>')">
                  <span class="fa fa-info-circle"></span>
                </a>
                <?php 
                if ($rol == 'admin')
                {
                 ?>
                 <a class="badge badge-warning text-black" data-toggle="modal" data-target="#modalEditar_prod" onclick="editar_prod('<?php echo $mostrar[0] ?>')">
                  <span class="fa fa-pencil-square-o"></span>
                </a>
                <?php 
              }
              ?>
              <a class="badge badge-danger text-white" onclick="eliminar_prod('<?php echo $mostrar[0] ?>')">
                <span class="fa fa-trash"></span>
              </a>
            </td>
          </tr>
          <?php 
          $num_item += 1;
        } 
        ?>
      </tbody>
    </div>
  </table>
</div>
<br>
</div>
<script type="text/javascript">
  $(document).ready(function()
  {
    $('#tabla_productos').DataTable();
  });
</script>
