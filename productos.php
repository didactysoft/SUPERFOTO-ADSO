<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$num_tabla = 1;

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
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Productos</title>
    <?php require_once "scripts.php";  ?>
  </head>
  <body>
    <!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img width="30" height="30" src="img/Icono.png" alt="person" class="img-fluid">
          <h2 class="h5">Superfoto</h2><span>Pamplona</span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.php" class="brand-small text-center"> <img width="30" height="30" src="img/Icono.png" alt="person" class="img-fluid"></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <!-- <li><a href="index.php"> <img width="22" height="22" src="img\Iconos/inicio.svg" class="mx-2"></i>Inicio</a></li> -->
            <h5 class="sidenav-heading">TRABAJOS</h5>
             <li><a href="agregar_trabajo.php"> <img width="22" height="22" src="img\Iconos/agregar_trabajo.svg" class="mx-2"></i>Agregar Trabajo</a></li>
            <li><a href="cotizacion.php"> <img width="22" height="22" src="img\Iconos/cotizacion.svg" class="mx-2"></i>Cotización</a></li>
            <li><a href="venta_directa.php"> <img width="22" height="22" src="img\Iconos/venta_directa.svg" class="mx-2">Venta Directa</a></li>
            <li><a href="trabajos_pendientes.php"> <img width="22" height="22" src="img\Iconos/trabajos_pendientes.svg" class="mx-2">Trabajos Pendientes</a></li>
            <li><a href="trabajos_entregados.php"> <img width="22" height="22" src="img\Iconos/trabajos_entregados.svg" class="mx-2">Trabajos Entregados</a></li>
            <li><a href="clientes.php"> <img width="22" height="22" src="img\Iconos/clientes.svg" class="mx-2"></i>Clientes</a></li>
            <li><a href="por_cobrar.php"> <img width="22" height="22" src="img\Iconos/por_cobrar.svg" class="mx-2"></i>Por Cobrar</a></li>
          </ul>
        </div>
      <!--
      <div class="admin-menu">
        <h5 class="sidenav-heading">INVENTARIO</h5>
        <ul id="side-admin-menu" class="side-menu list-unstyled"> 
          <li><a href="trabajos_pendientes.php"> <img width="22" height="22" src="img\Iconos/productos.svg" class="mx-2">Productos</a></li>
          <li><a href="trabajos_pendientes.php"> <img width="22" height="22" src="img\Iconos/agregar_producto.svg" class="mx-2"></i>Agregar Producto</a></li>
          <li><a href="trabajos_pendientes.php"> <img width="22" height="22" src="img\Iconos/agregar_proveedor.svg" class="mx-2"></i>Agregar Proveedor</a></li>
          <li><a href="trabajos_pendientes.php"> <img width="22" height="22" src="img\Iconos/proveedores.svg" class="mx-2">Proveedores</a></li>
        </div>
      </div>
    -->
    <div class="config-menu">
      <h5 class="sidenav-heading">CONFIGURACION</h5>
      <ul id="side-admin-menu" class="side-menu list-unstyled"> 
        <li><a href="perfil.php"> <img width="22" height="22" src="img\Iconos/perfil.svg" class="mx-2">Configurar Perfil</a></li> 
        
      </div>
      <?php 
      if ($rol == 'admin')
      {
       ?>
       <div>
        <h5 class="sidenav-heading">EMPRESA</h5>
        <ul id="side-admin-menu" class="side-menu list-unstyled"> 
          <li><a href="empleados.php"> <img width="22" height="22" src="img\Iconos/empleados.svg" class="mx-2">Empleados</a></li>
          <li class="active"><a href="productos.php"> <img width="22" height="22" src="img\Iconos/productos.svg" class="mx-2">Productos</a></li> 
          <li><a href="contabilidad.php"> <img width="22" height="22" src="img\Iconos/contabilidad.svg" class="mx-2">Contabilidad</a></li>
          <li><a href="egresos.php"> <img width="22" height="22" src="img\Iconos/egresos.svg" class="mx-2">Egresos</a></li>
          <li><a href="material.php"> <img width="22" height="22" src="img\Iconos/material.svg" class="mx-2">Material</a></li>
        </ul>
      </div>
      <?php 
    }
    ?>
  </nav>
  <div class="page">

    <!-- navbar-->
    <header class="header">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-holder d-flex align-items-center justify-content-between">
            <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="perfil.php" class="navbar-brand">
              <div class="brand-text d-none d-md-inline-block"><img width="30" height="30" src="<?php echo $foto_empleado ?>" class="mx-2 img-fluid rounded-circle" ><strong class="text-black"><?php echo $nombre_usuario ?></strong></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <div id="div_notificaciones"></div>
                <!-- Log out-->
                <li class="nav-item"><a href="procesos/cerrar_sesion.php" class="nav-link logout"> <span class="d-none d-sm-inline-block">Cerrar Sesión</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>

      <section>
        <div class="card mx-5 mt-5">
          <br>
          <div class="card-header text-center">
            <h4>PRODUCTOS</h4>
            <span class="btn boton_peq btn-primary derecha_arriba" id="boton_productos" data-toggle="modal" data-target="#modal_agregar_producto">Agregar Productos</span>
          </div>
          <div id="div_tabla_productos" style="height: 345px;"></div>
        </div>
      </section>

      <!-- Modal NUEVO-->
      <div class="modal fade" id="modal_agregar_producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
          <div class="modal-header">
            <div class="col bg-primary text-center text-white  p-2">
              <h4>AGREGAR PRODUCTO</h4>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form  id="frmnuevo">
              <div class="rounded-top container col-md-3 font-italic text-center ">Datos del producto</div>
              <div class="container">
                <br>
                <div class="row container">
                  <label class="col-sm-2 col-form-label">Descripción: </label>
                  <div class="col-sm-10">
                    <textarea class="form-control mb-2" id="inputDescripcion" name="inputDescripcion" rows="5" placeholder="Descripcion del Producto" required=""></textarea>
                  </div>
                </div>
                <div class="row container">
                  <label class="col-sm-2 col-form-label">Valor: </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control form-control-sm" name="inputValor" id="inputValor" placeholder="Valor Unitario del Producto" required="">
                  </div>
                </div>
                <div class="row container">
                  <label class="col-sm-2 col-form-label">Stock: </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control form-control-sm" name="inputStock" id="inputStock" placeholder="Cantidad Existente" required="">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnAgregarnuevo">Guardar Producto</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Detalles de Producto-->
    <div class="modal fade" id="detalles_trabajo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" id="div_modal_detalles_producto"></div>
    </div>

    <!-- Modal Actualizar-->
    <div class="modal fade" id="modalEditar_prod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmnuevoU">
              <input type="text" hidden="" id="cod_productoU" name="cod_productoU">
              <label>Descripción</label>
              <textarea class="form-control input-sm" rows="3" id="descripcionU" name="descripcionU"></textarea>
              <label>Valor</label>
              <input type="text" class="form-control input-sm" id="valorU" name="valorU">
              <label>Stock</label>
              <input type="text" class="form-control input-sm" id="stockU" name="stockU">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnActualizar" data-dismiss="modal">Actualizar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- JavaScript files-->
  <script src="vendor/popper.js/umd/popper.min.js"> </script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
  <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
  <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="js/charts-home.js"></script>
  <!-- Main File-->
  <script src="js/front.js"></script>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function()
  {
    $('#div_tabla_productos').load('tablas/productos.php');
    $('#div_notificaciones').load('notificaciones.php');

    $('#btnAgregarnuevo').click(function(){
      datos=$('#frmnuevo').serialize();
      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/agregar_producto.php",
        success:function(r){
          if(r==1)
          {
            $('#frmnuevo')[0].reset();
            $('#modal_agregar_producto').modal('hide');
            alertify.success("Producto agregado con exito");
            $('#div_tabla_productos').load('tablas/productos.php');
          }else{
            alertify.error("Fallo al agregar Producto" + r);
          }
        }
      });
    });

    $('#btnActualizar').click(function(){
      datos=$('#frmnuevoU').serialize();

      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/actualizar_prod.php",
        success:function(r){
          if(r==1){
            alertify.success("Actualizado con exito :D");
            $('#div_tabla_productos').load('tablas/productos.php');
          }else{
            alertify.error("Fallo al actualizar :("+r);
          }
        }
      });
    });

  });

  function detalles_producto(cod_producto)
  {
    $('#div_modal_detalles_producto').load('detalles_producto.php/?cod_producto='+cod_producto);
  }

  function editar_prod(cod_producto){
    $.ajax({
      type:"POST",
      data:"cod_producto=" + cod_producto,
      url:"procesos/obtenDatos_p.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        $('#cod_productoU').val(datos['cod_producto']);
        $('#descripcionU').val(datos['descripción']);
        $('#valorU').val(datos['valor']);
        $('#stockU').val(datos['stock']);
      }
    });
  }

  function eliminar_producto(cod_producto){
    alertify.confirm('Eliminar un producto', '¿Seguro de eliminar este producto?', function(){ 

      $.ajax({
        type:"POST",
        data:"cod_producto=" + cod_producto,
        url:"procesos/eliminar.php",
        success:function(r){
          if(r==1){
            $('#div_tabla_productos').load('tablas/productos.php');
            alertify.success("Eliminado con exito !");
          }else{
            alertify.error("No se pudo eliminar...");
          }
        }
      });

    }
    , function(){

    });
  }

</script>

<?php 
}
else
{
  header("Location:login.php");
} 
?>