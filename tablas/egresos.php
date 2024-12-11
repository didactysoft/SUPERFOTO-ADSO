<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();


$nombre_tabla = 'EGRESOS';

$fecha_inicial = $fecha . ' 00:00:00';
$fecha_final = $fecha . ' 23:59:59';
$sql = "SELECT `cod_egreso`, `descripción`, `valor`, `fecha` FROM `egresos` WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' order by fecha DESC";
$result=mysqli_query($conexion,$sql);
$total_egresos = 0;

?>
<div class="card text-xsmall">
  <div class="card-header text-center">
    <h4><?php echo $nombre_tabla ?></h4>
  </div>
  <div class="table-responsive">
    <br>
    <table class="table table-striped table-sm table-bordered" id="tabla_egresos">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Codigo</th>
          <th>Descripción</th>
          <th>Valor</th>
          <th>Fecha</th>
          <th width="50px">Opciones</th>
        </tr>
      </thead>
      <div class="overflow-auto">
        <tbody class="overflow-auto text-center">
          <?php 
          $num_item = 1;
          while ($mostrar=mysqli_fetch_row($result)) 
          {
            $total_egresos += $mostrar[2];
            $fecha_egreso = strtotime($mostrar[3]);
            $fecha_egreso = date('d-m-Y g:i A',$fecha_egreso);
            ?>
            <tr>
              <td><?php echo $num_item ?></td>
              <td><?php echo str_pad($mostrar[0],5,"0",STR_PAD_LEFT) ?></td>
              <td><?php echo $mostrar[1] ?></td>
              <td>$ <?php echo number_format($mostrar[2]); ?></td>
              <td><?php echo $fecha_egreso ?></td>
              <td class="text-center">
                <a class="badge badge-warning text-black" data-toggle="modal" data-target="#modalEditar" onclick="actualizar_egreso('<?php echo $mostrar[0] ?>')">
                  <span class="fa fa-pencil-square-o"></span>
                </a>
                <a class="badge badge-danger text-white" onclick="eliminar_egreso('<?php echo $mostrar[0] ?>')">
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
  <div class="text-center text-primary">
    <h4>TOTAL EGRESOS DIA : $ <?php echo number_format($total_egresos) ?></h4>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function()
  {
    $('#tabla_egresos').DataTable();
  });
</script>
