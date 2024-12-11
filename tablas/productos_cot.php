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
      <th>Descripción</th>
      <th>Cant</th>
      <th style="width: 100px">Valor Unitario</th>
      <th style="width: 100px">Valor Total</th>
    </tr>
  </thead>
  <tbody class="overflow-auto">
    <?php 
    foreach ($productos as $num_item => $producto)
    {
      $total_x_producto = 0;
      $descripcion = $producto['descripcion'];
      $valor_unitario = $producto['valor_unitario'];
      $cant = $producto['cant_producto'];

      $total_productos += $valor_unitario*$cant;
      $total_x_producto += $valor_unitario*$cant;
      ?>
      <tr>
        <td class="text-center"><?php echo $num_item ?></td>
        <td class="text-center"><?php echo $descripcion ?></td>
        <td class="text-center"><?php echo $cant ?></td>
        <td class="text-right">$ <?php echo number_format($valor_unitario); ?></td>
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
      <form id="form_check_total">
        <th colspan="4" class="text-right h3"><small class="text-muted">Mostrar Total </small><input class="mx-2" type="checkbox" name="inputCheck_total" id="inputCheck_total" checked="">TOTAL</th>
        <th class="text-right h3">$ <?php echo number_format($total_productos); ?></th>
      </form>
    </tr> 
  </tbody>
</table>