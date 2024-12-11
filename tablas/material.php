<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$tipo = $_GET['tipo_material'];

$sql = "SELECT `cod_material`, `nombre`, `estado`, `Fecha` FROM `tipos_material` WHERE cod_material='$tipo'";
$result=mysqli_query($conexion,$sql);
$mostrar=mysqli_fetch_row($result);
$nombre_tabla = $mostrar[1];

$fecha_inicial = $fecha . ' 00:00:00';
$fecha_final = $fecha . ' 23:59:59';
$sql = "SELECT `cod_material`, `largo`, `ancho`, `valor`, `fecha`, `tipo_material` FROM `material` WHERE tipo_material = '$tipo' AND fecha<='$fecha_final' order by fecha DESC";
$result=mysqli_query($conexion,$sql);
$total_venta = 0;

?>
<div class="card text-xsmall">
  <div class="card-header text-center">
    <h4><?php echo $nombre_tabla ?></h4>
    <span class="btn boton_peq boton_edit derecha_arriba" id="boton_editar" onclick="f_reiniciar_material('<?php echo $tipo ?>')">Reiniciar</span>
  </div>
  <div class="table-responsive">
    <br>
    <table class="table table-striped table-sm table-bordered" id="tabla_material_<?php echo $tipo ?>">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Codigo</th>
          <th>Largo</th>
          <th>Ancho</th>
          <th>Valor</th>
          <th>Fecha Creacion</th>
          <th width="50px">Opciones</th>
        </tr>
      </thead>
      <div class="overflow-auto">
        <tbody class="overflow-auto text-center">
          <?php 
          $num_item = 1;
          while ($mostrar=mysqli_fetch_row($result)) 
          {
            $total_venta += $mostrar[3];
            $fecha_creacion = strtotime($mostrar[4]);
            $fecha_creacion = date('d-m-Y g:i A',$fecha_creacion);
            $valor_material = $mostrar[3];
            ?>
            <tr>
              <td><?php echo $num_item ?></td>
              <td><?php echo str_pad($mostrar[0],5,"0",STR_PAD_LEFT) ?></td>
              <td><?php echo $mostrar[1] ?> cm</td>
              <td><?php echo $mostrar[2] ?> cm</td>
              <td>$ <?php echo number_format($valor_material); ?></td>
              <td><?php echo $fecha_creacion ?></td>
              <td class="text-center">
                <a class="badge badge-danger text-white" onclick="eliminar_material('<?php echo $mostrar[0] ?>')">
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
  <div class="text-center text-info">
    <h4>TOTAL PRODUCIDO MATERIAL : $ <?php echo number_format($total_venta) ?></h4>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function()
  {
    $('#tabla_material_<?php echo $tipo ?>').DataTable();
  });
</script>
