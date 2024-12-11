<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

session_start();
$productos = $_SESSION['productos'];

$total_productos = 0;

?>
<table class="table table-striped table-sm table-bordered" id="tabla_trabajos">
  <thead>
    <tr class="text-center">
      <th>#</th>
      <th>Codigo</th>
      <th>Descripción</th>
      <th>Cant</th>
      <th>Valor Unitario</th>
      <th>Valor Total</th>
    </tr>
  </thead>
  <tbody class="overflow-auto">
    <?php 
    foreach ($productos as $num_item => $producto)
    {
      $total_x_producto = 0;
      $cod_producto = $producto['cod_producto'];
      $sql_producto = "SELECT `cod_producto`, `descripción`, `valor`, `stock`, `fecha_modificacion` FROM `productos` WHERE cod_producto = '$cod_producto'";
      $result_producto=mysqli_query($conexion,$sql_producto);
      $ver_producto=mysqli_fetch_row($result_producto);
      $cant = $producto['cant_producto'];

      $total_productos += $ver_producto[2]*$cant;
      $total_x_producto += $ver_producto[2]*$cant;
      ?>
      <tr>
        <td class="text-center"><?php echo $num_item ?></td>
        <td class="text-center"><?php echo str_pad($cod_producto,4,"0",STR_PAD_LEFT) ?></td>
        <td class="text-center"><?php echo $ver_producto[1] ?></td>
        <td class="text-center"><?php echo $cant ?></td>
        <td class="text-right">$ <?php echo number_format($ver_producto[2]); ?></td>
        <td class="text-right">$ <?php echo number_format($total_x_producto); ?></td>
        <td class="text-center">
          <a class="badge badge-danger text-white" onclick="eliminar_producto('<?php echo $num_item ?>')">
            <span class="fa fa-trash"></span>
          </a>
        </td>
      </tr>  
      <?php 
    } ?>
    <tr>
      <th colspan="5" class="h3">TOTAL</th>
      <th class="text-right h3">$ <?php echo number_format($total_productos); ?></th>
    </tr> 
  </tbody>
</table>