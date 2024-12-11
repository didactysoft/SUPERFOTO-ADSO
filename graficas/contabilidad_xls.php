<?php
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();



$sql_emp="SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE 1";
$result_emp=mysqli_query($conexion,$sql_emp);

$fecha_rec = 'Desde ' . $_GET['fecha_inicial'] . ' hasta ' . $_GET['fecha_final'];
$nombre_archivo = ' Ventas(' . $_GET['fecha_inicial'] . ' - ' . $_GET['fecha_final'] . ')';

$fecha_inicial = $_GET['fecha_inicial'];
$fecha_final = $_GET['fecha_final'];

$fecha_i = $fecha_inicial . ' 00:00:00';
$fecha_f = $fecha_final . ' 23:59:59';

$sql_c = "SELECT `codigo`, `cod_trabajo`, `valor`, `descripcion`, `responsable`, `fecha` FROM `cuentas_diarias` WHERE fecha BETWEEN '$fecha_i' AND '$fecha_f'";
$result_c=mysqli_query($conexion,$sql_c);

$sql_egresos = "SELECT `cod_egreso`, `descripción`, `valor`, `fecha` FROM `egresos` WHERE fecha BETWEEN '$fecha_i' AND '$fecha_f'";
$result_egresos=mysqli_query($conexion,$sql_egresos);


header('Content-type:application/xls');
header('Content-Disposition: attachment; filename='.$nombre_archivo.'.xls');

?>

<div class="card sales-report text-center row">
  <br>
  <h2 class="display h4">Reporte <?php echo $fecha_rec ?></h2>
  <div class="col">
    <table class="table table-striped table-sm table-bordered" id="tabla_trabajos" border="1">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Fecha</th>
          <th>Cod Orden</th>
          <th>Descripcion</th>
          <th>Valor</th>
          <th>Responsable</th>
        </tr>
      </thead>
      <tbody class="overflow-auto">
        <?php 
        $num_item = 1;
        $total_dia = 0; 
        while ($mostrar=mysqli_fetch_row($result_c)) 
        { 
          $sql_empleado = "SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE cedula='$mostrar[4]'";
          $result_empleado=mysqli_query($conexion,$sql_empleado);
          $mostrar_empleado=mysqli_fetch_row($result_empleado);

          $cod_trab = substr($mostrar[1],0,1);

          if ($cod_trab == 'V' )
          {
            $venta_cod = substr($mostrar[1],1);
            $sql_descrip = "SELECT `cod_venta`, `descripción`, `responsable`, `total`, `fecha_recepcion` FROM `ventas_directas` WHERE cod_venta='$venta_cod '";
            $result_descrip=mysqli_query($conexion,$sql_descrip);
            $mostrar_descrip=mysqli_fetch_row($result_descrip);
            $descrip = $mostrar_descrip[1];
          }
          else
          {
            $sql_descrip = "SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `fecha_entrega`, `fecha_recepcion` FROM `trabajos` WHERE cod_trabajo='$mostrar[1]'";
            $result_descrip=mysqli_query($conexion,$sql_descrip);
            $mostrar_descrip=mysqli_fetch_row($result_descrip);
            $descrip = $mostrar_descrip[3];
          }
          ?>
          <tr>
            <td><?php echo $num_item ?></td>
            <td><?php echo $mostrar[5] ?></td>
            <td><?php echo $mostrar[1] ?></td>
            <td><?php echo substr($descrip,0,50) ?></td>
            <td>$ <?php echo $mostrar[2] ?></td>
            <td><?php echo $mostrar_empleado[2] ?></td>
          </tr>
          <?php 
          $num_item += 1;
          $total_dia += $mostrar[2];
        }
        
        ?>
      </tbody>

    </table>
  </div>
  <div class="text-center text-primary">
    <h4>TOTAL: $ <?php echo number_format($total_dia) ?></h4>
  </div>
  <br><br>
  <div >
    <table class="table table-striped table-sm table-bordered" id="tabla_egresos" border="1">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Fecha</th>
          <th>Cod Egreso</th>
          <th>Descripcion</th>
          <th>Valor</th>
        </tr>
      </thead>
      <tbody class="overflow-auto">
        <?php 
        $num_item = 1;
        $total_egresos = 0; 
        while ($mostrar=mysqli_fetch_row($result_egresos)) 
        { 
          $cod_trab = substr($mostrar[1],0,1);
          $descrip = $mostrar[1];
          ?>
          <tr>
            <td><?php echo $num_item ?></td>
            <td><?php echo $mostrar[3] ?></td>
            <td><?php echo $mostrar[0] ?></td>
            <td><?php echo substr($descrip,0,50) ?></td>
            <td>$ <?php echo $mostrar[2] ?></td>
          </tr>
          <?php 
          $num_item += 1;
          $total_egresos += $mostrar[2];
        }
        
        ?>
      </tbody>

    </table>
  </div>
  <br>
  <div class="text-center text-primary">
    <h4>TOTAL EGRESOS: $ <?php echo number_format($total_egresos) ?></h4>
  </div>
  <br>
</div>


