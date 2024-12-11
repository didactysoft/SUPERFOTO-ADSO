<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar(); 
$conexion=$obj->conexion();

session_start();
if (isset($_SESSION['productos']))
{
  unset($_SESSION['productos']);
}

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
else
{
  $rol = '';
}

$num_tabla=$_GET['num_tabla'];
$estado_trabajo=$_GET['estado_trabajo'];
$responsable_rec = $_GET['responsable'];

if ($responsable_rec == '0')
{
  $responsable_filtro='';
}
else
{
  $responsable_filtro = 'AND responsable = ' . $responsable_rec;
}



if ($estado_trabajo == '1')
{
  if ($num_tabla == 1) 
  {
    $nombre_tabla = 'HOY';
    $fecha_sql=date('Y-m-d');
    $sql = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE fecha_entrega<='$fecha_sql' AND estado != 'ENTREGADO' $responsable_filtro";
    $result=mysqli_query($conexion,$sql);

  }
  if ($num_tabla == 2) 
  {
    $nombre_tabla = 'MAÑANA';
    $fecha_sql= date("Y-m-d",strtotime($fecha."+ 1 days"));
    $sql = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE fecha_entrega='$fecha_sql' AND estado != 'ENTREGADO' $responsable_filtro";
    $result=mysqli_query($conexion,$sql);
  }
  if ($num_tabla == 3) 
  {
    $nombre_tabla = 'PASADO MAÑANA';
    $fecha_sql= date("Y-m-d",strtotime($fecha."+ 2 days"));
    $sql = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE fecha_entrega='$fecha_sql' AND estado != 'ENTREGADO' $responsable_filtro";
    $result=mysqli_query($conexion,$sql);
  }
  if ($num_tabla == 4) 
  {
    $nombre_tabla = 'PRÓXIMOS DIAS';
    $fecha_sql= date("Y-m-d",strtotime($fecha."+ 3 days"));
    $sql = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE fecha_entrega>='$fecha_sql' AND estado != 'ENTREGADO' $responsable_filtro";
    $result=mysqli_query($conexion,$sql);
  }
  $tamaño = 'style="height: 315px;"';
}
else
{
  if ($num_tabla == 5) 
  {
    $sql="SELECT MAX(cod_trabajo)
    as cod_trabajo  from trabajos";
    $result=mysqli_query($conexion,$sql);
    $ver=mysqli_fetch_row($result);

    $maximo = $ver[0]-50;

    $nombre_tabla = 'ENTREGADOS';
    $sql = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE estado = 'ENTREGADO' AND cod_trabajo > '$maximo' order by cod_trabajo DESC";
    $result=mysqli_query($conexion,$sql);
  }
  $tamaño = '';
}

?>
<div class="card text-xsmall" <?php echo $tamaño ?>>
  <div class="card-header text-center">
    <h4><?php echo $nombre_tabla ?></h4>
  </div>
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
            $color_emp = substr($mostrar_empleado[7],4,-1);
            ?>
            <tr>
              <td class="text-white text-center" style="background-color: rgba(<?php echo $color_emp ?>,1);"><?php echo $num_item ?></td>
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
                  <?php if ($mostrar[4] != 'ENTREGADO' && $rol == 'admin') 
                  {
                    ?>
                    <a class="badge badge-danger text-white" onclick="eliminar_trabajo('<?php echo $mostrar[0] ?>')"><i class="fa fa-trash"></i></a>
                    <?php 
                  }
                  ?>
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

  <?php 
  if ($num_tabla == 5)
  { 
    ?>
    <script type="text/javascript">
      $(document).ready(function()
      {
        //$('#tabla_trabajos').DataTable();
      });
    </script>
    <?php 
  } ?>
  