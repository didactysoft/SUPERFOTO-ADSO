<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();


$nombre_tabla = 'POR COBRAR';
$sql = "SELECT `cod_deuda`, `cod_trabajo`, `valor`, `fecha_creacion`, `estado` FROM `deudas` WHERE 1 order by estado ASC,fecha_creacion ASC";
$result=mysqli_query($conexion,$sql);

?>
<div class="card text-xsmall">
  <div class="card-header text-center">
    <h4><?php echo $nombre_tabla ?></h4>
  </div>
  <div class="table-responsive">
    <br>
    <table class="table table-striped table-sm table-bordered" id="tabla_deudas">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Codigo</th>
          <th>Orden</th>
          <th>Cliente</th>
          <th>Valor</th>
          <th>Estado</th>
          <th>Fecha Radicado</th>
          <th>Info</th>
        </tr>
      </thead>
      <div class="overflow-auto">
        <tbody class="overflow-auto text-center">
          <?php 
          $num_item = 1;
          while ($mostrar=mysqli_fetch_row($result)) 
          {
            $fecha_v = strtotime($mostrar[3]);
            $fecha_v = date('d-m-Y g:i A',$fecha_v);

            $sql_trabajo = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE cod_trabajo='$mostrar[1]'";
            $result_trabajo=mysqli_query($conexion,$sql_trabajo);
            $mostrar_trabajo=mysqli_fetch_row($result_trabajo);

            $sql_cliente = "SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cedula='$mostrar_trabajo[2]'";
            $result_cliente=mysqli_query($conexion,$sql_cliente);
            $mostrar_cliente=mysqli_fetch_row($result_cliente);
            ?>
            <tr>
              <td><?php echo $num_item ?></td>
              <td><?php echo str_pad($mostrar[0],5,"0",STR_PAD_LEFT) ?></td>
              <td><?php echo str_pad($mostrar[1],5,"0",STR_PAD_LEFT) ?></td>
              <td><?php echo substr($mostrar_cliente[2], 0, 20); ?></td>
              <td>$ <?php echo number_format($mostrar[2]); ?></td>
              <?php 
              if ($mostrar[4] == 'EN MORA') 
                {?>
                  <td class="text-danger text-center"><?php echo $mostrar[4] ?></td>
                  <?php 
                } 
                if ($mostrar[4] == 'PAGADO') 
                {
                  ?>
                  <td class="text-success text-center"><?php echo $mostrar[4] ?></td>
                  <?php 
                }?>
                <td><?php echo $fecha_v; ?></td>
                <td class="text-center">
                  <a class="badge badge-info text-white" data-toggle="modal" data-target="#mostrar_trabajo_modal" onclick="mostrar_trabajo('<?php echo $mostrar_trabajo[0] ?>')"><i class="fa fa-info-circle"></i></a>
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
      $('#tabla_deudas').DataTable();
    });
  </script>
  