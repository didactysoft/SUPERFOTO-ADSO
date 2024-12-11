<?php 

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$cod_producto = $_GET['cod_producto'];


$sql="SELECT `cod_producto`, `descripción`, `valor`, `stock`, `fecha_modificacion`, `imagen` FROM `productos` WHERE cod_producto='$cod_producto'";
$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$descripción = $ver[1];
$valor = '$ '. number_format($ver[2]);
$stock = $ver[3];
$fecha_modificacion = $ver[4];
$imagen = $ver[5];

?>
<div class="modal-content">
  <div class="modal-body">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
    <div class="container text-small row align-items-center">
      <div class="col-md-8">
        <div class="rounded-top bg-light container col-md-5 font-italic text-center ">Datos del Cliente</div>
        <div class="rounded container bg-light">
          <br>
          <div class="row">
            <label class="ml-2">Código: </label>
            <div class="font-italic form-group col-md-3 text-muted" name="vercodigo" id="vercodigo"><?php echo str_pad($cod_producto,5,"0",STR_PAD_LEFT) ?></div>
          </div>
          <div class="row">
            <label class="ml-2">Descripción: </label>
            <div class="font-italic form-group col text-muted" name="verdireccion" id="verdireccion"><?php echo $descripción ?></div>
          </div>
          <div class="row">
            <label class="ml-2">Valor: </label>
            <div class="font-italic form-group col text-muted h5" name="vertelefono" id="vertelefono"><?php echo $valor ?></div>
          </div>
        </div>
      </div>
      <div class="col-auto">
        <br>
        <div class="rounded container bg-light">
          <div class="row">
            <div class="font-italic form-group text-right text-muted imagen_producto" id="ver_imagen">
              <img src="<?php echo $imagen ?>" class="img-fluid cuadrada" alt="Responsive image">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>