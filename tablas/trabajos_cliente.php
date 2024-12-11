<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$cod_cliente=$_GET['cod_cliente'];

  $fecha_sql=date('Y-m-d');
  $sql_cliente = "SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cod_cliente='$cod_cliente'";
  $result_cliente=mysqli_query($conexion,$sql_cliente);
  $mostrar_cliente=mysqli_fetch_row($result_cliente);

  $sql = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE cc_cliente='$mostrar_cliente[1]'";
  $result=mysqli_query($conexion,$sql);

?>
<div class="text-xsmall">
  <div class="table-responsive">
    
    <table class="table table-striped table-sm table-bordered" id="tabla_trabajos">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Codigo</th>
          <th>Título</th>
          <th>Cliente</th>
          <th>Estado</th>
          <th>Responsable</th>
          <th>Info</th>
        </tr>
      </thead>
      <div class="overflow-auto">
        <tbody class="overflow-auto">
          <?php 
          $num_item = 1;
          while ($mostrar=mysqli_fetch_row($result)) 
          { 
            $sql_empleado = "SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE cedula='$mostrar[5]'";
            $result_empleado=mysqli_query($conexion,$sql_empleado);
            $mostrar_empleado=mysqli_fetch_row($result_empleado);

            $sql_cliente = "SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cedula='$mostrar[2]'";
            $result_cliente=mysqli_query($conexion,$sql_cliente);
            $mostrar_cliente=mysqli_fetch_row($result_cliente);
            ?>
            <tr>
              <td><?php echo $num_item ?></td>
              <td><?php echo str_pad($mostrar[0],8,"0",STR_PAD_LEFT) ?></td>
              <td><?php echo substr($mostrar[1], 0, 21); ?></td>
              <td><?php echo substr($mostrar_cliente[2], 0, 20); ?></td>
              <?php 
              if ($mostrar[4] == 'PENDIENTE') 
                {?>
                  <td class="text-danger text-center"><?php echo $mostrar[4] ?></td>
                  <?php 
                } 
                if ($mostrar[4] == 'TERMINADO') 
                {
                  ?>
                  <td class="text-success text-center"><?php echo $mostrar[4] ?></td>
                  <?php 
                }
                if ($mostrar[4] == 'ENTREGADO') 
                {
                  ?>
                  <td class="text-info text-center"><?php echo $mostrar[4] ?></td>
                  <?php 
                }?>
                <td><?php echo substr($mostrar_empleado[2], 0, 15); ?></td>
                <td class="text-center">
                  <a class="badge badge-info text-white" data-toggle="modal" data-target="#mostrar_trabajo_modal" onclick="mostrar_trabajo('<?php echo $mostrar[0] ?>')"><i class="fa fa-info-circle"></i></a>
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
  </div>
  <script type="text/javascript">
    $(document).ready(function()
    {
      $('#tabla_trabajos').DataTable();
    });
  </script>
  