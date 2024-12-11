<?php 

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$cod_orden = $_GET['cod_trabajo'];


$sql="SELECT `cod_trabajo`, `titulo`, `cc_cliente`, `descripción`, `estado`, `responsable`, `total`, `abono`, `fecha_entrega`, `hora_entrega`, `fecha_recepcion`, `ruta` FROM `trabajos` WHERE cod_trabajo='$cod_orden'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$sql_cliente ="SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cedula='$ver[2]'";
$result_cliente =mysqli_query($conexion,$sql_cliente);
$ver_cliente =mysqli_fetch_row($result_cliente);

$sql_empleado="SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE cedula='$ver[5]'";
$result_empleado=mysqli_query($conexion,$sql_empleado);
$ver_empleado=mysqli_fetch_row($result_empleado);

$cod_trabajo = str_pad($ver[0],8,"0",STR_PAD_LEFT);
$titulo = $ver[1];
$descripción = $ver[3];
//$descripción = str_replace(
$descripción = nl2br($descripción);

$ruta = $ver[11];

$estado = $ver[4];
$responsable = $ver[5];
$total = $ver[6];
$abono = $ver[7];
$empleado = substr($ver_empleado[2], 0, 26);
$cc_empleado = $ver[5];

$saldo = $total - $abono;
$fecha_entrega = $ver[8];

$hora = substr($ver[9], 0, 2) - 0;
$minuto = substr($ver[9], 3, 2);
if($hora > 12)
{
  $hora -= 12;
  $hora_entrega = $hora . ':' . $minuto . ' PM';
}
else
{
  $hora_entrega = $hora . ':' . $minuto . ' AM';
}

$cedula = $ver_cliente[1];
$nombre = $ver_cliente[2];
$direccion = $ver_cliente[3];
$telefono = $ver_cliente[4];
$actuales = $ver_cliente[6];
$totales = $ver_cliente[7];

$hay_productos = 0;

$sql_productos="SELECT `cod_producto_vendido`, `descripción`, `cantidad`, `valor`, `cod_trabajo`, `fecha` FROM `productos_vendidos` WHERE cod_trabajo='$cod_orden'";
$result_productos=mysqli_query($conexion,$sql_productos);
$ver_productos=mysqli_fetch_row($result_productos);
if ($ver_productos[0]!='')
{
  $hay_productos = 1;
}


$sql_productos="SELECT `cod_producto_vendido`, `descripción`, `cantidad`, `valor`, `cod_trabajo`, `fecha` FROM `productos_vendidos` WHERE cod_trabajo='$cod_orden'";
$result_productos=mysqli_query($conexion,$sql_productos);

$sql_empleados="SELECT `cedula`, `nombre` FROM `empleados`";
$result_empleados=mysqli_query($conexion,$sql_empleados);

?>
<div class="modal-content">
  <div class="modal-body">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <div class="container text-small row">
    <div class="col-md-4">
      <div class="rounded-top bg-light container col-md-5 font-italic text-center ">Datos de orden</div>
      <div class="rounded container bg-light">
        <br>
        <div class="row">
          <label class="ml-2 col">Num. de Orden: </label>
          <div class="font-italic form-group text-right text-muted col-md-5" id="ver_cod_orden"><?php echo $cod_trabajo ?></div>
        </div>
        <div class="row">
          <label class="ml-2 col">Fecha de Entrega: </label>
          <div class="font-italic form-group text-right text-muted col-md-5" id="ver_fecha_entrega" name="ver_fecha_entrega"><?php echo $fecha_entrega ?></div>
        </div>
        <div class="row">
          <label class="ml-2 col">Hora de Entrega: </label>
          <div class="font-italic form-group text-right text-muted col-md-5" id="ver_hora_entrega" name="ver_hora_entrega"><?php echo $hora_entrega ?></div>
        </div>
      </div>
    </div>
    <br>
    <div class="col-md-8">
      <div class="rounded-top bg-light container col-md-5 font-italic text-center ">Datos del Cliente</div>
      <div class="rounded container bg-light">
        <br>
        <div class="row">
          <label class="ml-2">Cédula o NIT: </label>
          <div class="font-italic form-group col-md-3 text-muted" name="vercedula" id="vercedula"><?php echo $cedula ?></div>
          <label>Nombre: </label>
          <div class="text-muted font-italic form-group col " name="vernombre" id="vernombre"><?php echo $nombre ?></div>

        </div>
        <div class="row">
          <label class="ml-2">Dirección: </label>
          <div class="font-italic form-group col text-muted" name="verdireccion" id="verdireccion"><?php echo $direccion ?></div>
        </div>
        <div class="row">
          <label class="ml-2">Teléfono: </label>
          <div class="font-italic form-group col text-muted" name="vertelefono" id="vertelefono"><?php echo $telefono ?></div>
          <label>Puntos Actuales: </label>
          <div class="font-italic form-group col text-muted" name="vercorreo" id="vercorreo"><?php echo $actuales ?></div>
          <label>Puntos Totales: </label>
          <div class="font-italic form-group col text-muted" name="verfacebook" id="verfacebook"><?php echo $totales ?></div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <form class="row" id="form_editar">
    <div class="col-lg-9">
      <div class="container text-small row">
        <label class="ml-2 text-muted">Título: </label>
        <div class="font-italic form-group col"> <?php echo $titulo ?></div>
      </div>
      <label class="ml-2 text-muted">Descripción del Trabajo: </label>
      <div class="container text-small row">
        <div class="font-italic form-group col" id="div_descrip"> <?php echo $descripción ?></div>
      </div>

      <div class="container text-small row" hidden="" id="div_editar_descrip">
        <input type="number" class="form-control form-control-sm" name="inputcod_trabajo" id="inputcod_trabajo" required="" value="<?php echo $cod_trabajo ?>" hidden="">
        <textarea class="form-control mb-2" id="inputDescripcion" name="inputDescripcion" required="" rows="5"><?php echo str_replace("<br />","",$descripción) ?></textarea>
      </div>
      <?php 
      if ($hay_productos == 1) 
      {
        ?>
        <div class="container text-small row border-top ml-1">
          <label class="ml-2 text-muted">Productos: </label>
          <table class="table table-striped table-sm table-bordered" id="tabla_trabajos">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Descripción</th>
                <th>Cant</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody class="overflow-auto">
              <?php 
              $num_item = 1;
              $total_productos = 0;
              while ($ver_productos=mysqli_fetch_row($result_productos)) 
              {
                $cant = $ver_productos[2];
                $total_productos += $ver_productos[3]*$cant;
                ?>
                <tr>
                  <td class="text-center"><?php echo $num_item ?></td>
                  <td class="text-center"><?php echo $ver_productos[1] ?></td>
                  <td class="text-center"><?php echo $cant ?></td>
                  <td class="text-right">$ <?php echo number_format($ver_productos[3]*$cant); ?></td>
                </tr>  
                <?php
                $num_item +=1; 
              } ?>
              <tr>
                <th colspan="3" class="text-right">TOTAL PRODUCTOS</th>
                <th class="text-right">$ <?php echo number_format($total_productos);?></th>
              </tr> 
            </tbody>
          </table>
        </div>
      <?php } ?>
      <div class="container text-small row border-top ml-1">
        <label class="ml-2 text-muted">Ruta de Archivo: </label>
        <div class="font-italic form-group col" id="div_ruta"><?php echo $ruta ?></div>
        <input type="text" class="form-control form-control-sm" name="input_ruta" id="input_ruta" required="" value="<?php echo $ruta ?>" hidden=''>
      </div>
    </div>

    <div class="col-lg-3 border-left h2">
      <div class="container text-small row">
        <label class="text-muted">TOTAL: </label>
        <div class="font-italic form-group col text-right" id="div_total">$ <?php echo number_format($total) ?></div>
        <input type="number" class="form-control form-control-sm col" name="input_total" id="input_total" required="" value="<?php echo $total ?>" hidden=''>
      </div>
      <div class="container text-small row ">
        <label class="text-muted">ABONO: </label>
        <div class="font-italic form-group col text-right">$ <?php echo number_format($abono) ?></div>
      </div>
      
      <?php if ($saldo == 0) 
      { ?>
        <div class="container text-small row">
          <div class="font-italic form-group col text-center h3 text-white bg-success p-1"> <?php echo 'CANCELADO' ?></div>
        </div>
        <?php 
      }
      else
      {
        ?>
        <div class="container text-small row border-top">
          <label class="mt-2 text-muted">SALDO: </label>
          <div class="font-italic mt-2 form-group col text-right text-danger h1">$ <?php echo number_format($saldo) ?></div>
        </div>
        <?php 
      } ?>
      <div class="container text-small row text-center">
        <div class="text-muted">RESP / </div>
        <div class="font-italic form-group" id="div_empleado"><?php echo $empleado ?></div>
        <select class="form-control form-control-sm" id="input_empleado" name="input_empleado" required hidden="">
          <?php 
          while ($mostrar_empleados=mysqli_fetch_row($result_empleados)) 
          { 
            ?>
            <option value="<?php echo $mostrar_empleados[0] ?>" <?php if ($cc_empleado == $mostrar_empleados[0]){
              ?>
              selected <?php } ?>><?php echo $mostrar_empleados[1] ?></option>
              <?php 
            }
            ?>
          </select>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <label>ESTADO: </label>
    <div class="font-italic form-group col text-muted " id="verestado" name="verestado">
      <?php 
      if ($estado == 'PENDIENTE') 
      {
       ?>
       <strong class="text-danger"><?php echo $estado ?></strong>
       <?php 
     }
     if ($estado == 'TERMINADO') 
     {
       ?>
       <strong class="text-success"><?php echo $estado ?></strong>
       <?php 
     }
     if ($estado == 'ENTREGADO') 
     {
       ?>
       <strong class="text-info"><?php echo $estado ?></strong>
       <?php 
     }
     ?>
   </div>
   <?php 
   if ($estado != 'ENTREGADO') 
   {
     ?>
     <button type="button" class="btn btn-warning" id="btn_editar_descrip" onclick="f_editar_descrip('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">Editar</button>
     <button type="button" class="btn btn-warning" hidden="" id="btn_fin_editar_descrip" onclick="f_fin_editar_descrip('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">Finalizar Edicion</button>
     <?php 
   }
   if ($estado == 'PENDIENTE') 
   {
     if ($saldo == 0) 
      { ?>
        <form id="form_Valor_recibido" class="col-sm-2">
          <input type="number" class="form-control form-control-sm" name="inputValor_recibido" id="inputValor_recibido" required="" value="0" hidden="">
          <input type="number" class="form-control form-control-sm" name="inputcod_trabajo" id="inputcod_trabajo" required="" value="<?php echo $cod_trabajo ?>" hidden="">
        </form>
        <?php 
      } else
      {
        ?>
        <form id="form_Valor_recibido" class="col-sm-2">
          <label class=" col-form-label">Valor Recibido: </label>
          <input type="number" class="form-control form-control-sm" name="inputValor_recibido" id="inputValor_recibido" required="">
          <input type="number" class="form-control form-control-sm" name="inputcod_trabajo" id="inputcod_trabajo" required="" value="<?php echo $cod_trabajo ?>" hidden="">
        </form>
        <button type="button" class="btn btn-success" id="btn_recibir_pago" onclick="f_recibir_pago('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">RECIBIR PAGO</button>
        <?php 
      } ?>
      <button type="button" class="btn btn-dark" id="btn_entregado" data-dismiss="modal" aria-label="Close" onclick="f_entregado('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">ENTREGADO</button>
      <button type="button" class="btn btn-success" id="btn_terminado" data-dismiss="modal" aria-label="Close" onclick="f_terminado('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">TERMINADO</button>
      <?php 
    }
    if ($estado == 'TERMINADO') 
    {
     if ($saldo == 0) 
      { ?>
        <form id="form_Valor_recibido" class="col-sm-2">
          <input type="number" class="form-control form-control-sm" name="inputValor_recibido" id="inputValor_recibido" required="" value="0" hidden="">
          <input type="number" class="form-control form-control-sm" name="inputcod_trabajo" id="inputcod_trabajo" required="" value="<?php echo $cod_trabajo ?>" hidden="">
        </form>
        <?php 
      } else
      {
        ?>
        <label class=" col-form-label">Valor Recibido: </label>
        <form id="form_Valor_recibido" class="col-sm-2">
          <input type="number" class="form-control form-control-sm" name="inputValor_recibido" id="inputValor_recibido" required="">
          <input type="number" class="form-control form-control-sm" name="inputcod_trabajo" id="inputcod_trabajo" required="" value="<?php echo $cod_trabajo ?>" hidden="">
        </form>
        <button type="button" class="btn btn-success" id="btn_recibir_pago" onclick="f_recibir_pago('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">RECIBIR PAGO</button>
        <?php 
      } ?>
      <button type="button" class="btn btn-dark" id="btn_entregado" data-dismiss="modal" aria-label="Close" onclick="f_entregado('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">ENTREGADO</button>
      <button type="button" class="btn btn-danger" id="btn_pendiente" data-dismiss="modal" aria-label="Close" onclick="f_pendiente('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">PENDIENTE</button>
      <?php 
    }
    if ($estado == 'ENTREGADO') 
    {
     if ($saldo != 0) 
      { ?>
        <label class=" col-form-label">Valor Recibido: </label>
        <form id="form_Valor_recibido" class="col-sm-2">
          <input type="number" class="form-control form-control-sm" name="inputValor_recibido" id="inputValor_recibido" required="">
          <input type="number" class="form-control form-control-sm" name="inputcod_trabajo" id="inputcod_trabajo" required="" value="<?php echo $cod_trabajo ?>" hidden="">
        </form>
        <button type="button" class="btn btn-success" id="btn_recibir_pago" onclick="f_recibir_pago('<?php echo $cod_orden ?>','<?php echo $ver_cliente[0] ?>')">RECIBIR PAGO</button>
        <?php 
      }
    }
    ?>
    <div class="border-left"> </div>
    <button type="button" class="btn btn-info" id="btn_imprimir_copia" onclick="imprimir_copia('<?php echo $cod_orden ?>')">IMPRIMIR COPIA</button>
  </div>
</div>