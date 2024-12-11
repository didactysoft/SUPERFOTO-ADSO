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

  $sql_e = "SELECT  cod_empleado,
  cedula,
  nombre,
  contraseña,
  foto,
  direccion,
  telefono
  FROM empleados WHERE 1";
  $result_e=mysqli_query($conexion,$sql_e);

  $sql = "SELECT `cod_material`, `nombre`, `estado`, `Fecha` FROM `tipos_material` WHERE estado = 'ACTIVO'";
  $result=mysqli_query($conexion,$sql);
  $result_1=mysqli_query($conexion,$sql);
  $result_2=mysqli_query($conexion,$sql);
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Historial de Materiales</title>
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
          <li><a href="productos.php"> <img width="22" height="22" src="img\Iconos/productos.svg" class="mx-2">Productos</a></li> 
          <li><a href="contabilidad.php"> <img width="22" height="22" src="img\Iconos/contabilidad.svg" class="mx-2">Contabilidad</a></li>
          <li><a href="egresos.php"> <img width="22" height="22" src="img\Iconos/egresos.svg" class="mx-2">Egresos</a></li>
          <li class="active"><a href="material.php"> <img width="22" height="22" src="img\Iconos/material.svg" class="mx-2">Material</a></li>
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
        <div class="container">
          <br>
          <div class="card container">
            <div class="card-header text-center">
              <h4>AGREGAR VENTA DE MATERIAL</h4>
              <span class="btn boton_peq btn-primary derecha_arriba" id="boton_material_nuevo" data-toggle="modal" data-target="#modal_agregar_material">Agregar Material Nuevo</span>
            </div>
            <br>
            <div>
              <form id="form_agregar_material" class="text-right">
                <div class="row container" hidden="">
                  <input type="number" class="form-control form-control-sm" name="inputEmpleado" id="inputEmpleado" required="" value="<?php echo $usuario ?>">
                </div>
                <div class="row container">
                  <label class="col-form-label">Largo: </label>
                  <div class="col-sm-2">
                    <input type="number" class="form-control form-control-sm" name="inputLargo" id="inputLargo" placeholder="cm" required="">
                  </div>
                  <label class="col-form-label">Ancho: </label>
                  <div class="col-sm-2">
                    <input type="number" class="form-control form-control-sm" name="inputAncho" id="inputAncho" placeholder="cm" required="">
                  </div>
                  <label class="col-form-label">Valor: </label>
                  <div class="col-sm-2">
                    <input type="number" class="form-control form-control-sm" name="inputValor" id="inputValor" placeholder="$" required="">
                  </div>
                  <label class="col-form-label">Material:</label>
                  <div class="col-sm-3">
                    <select class="form-control form-control-sm" id="tipo_material" name="tipo_material" required="">
                      <option value="">Selecionar Material</option>
                      <?php 
                      $cant_materiales = 0;
                      while ($mostrar=mysqli_fetch_row($result)) 
                      {
                       ?>
                       <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
                       <?php 
                       $cant_materiales += 1;
                     } 
                     ?>
                   </select>
                 </div>
               </div>
               <div class="row text-center">
                <div class="col"></div>
                <div class="col-sm-4 ">
                  <a class="btn btn-sm btn-primary text-white" onclick="agregar_material()">Agregar Venta Material</a>
                </div>
                <div class="col">
                  <br>
                </div>
                <br>
              </div>
              <br>
            </form>
          </div>
        </div>
      </div>
      <div class="row mx-2">
        <?php 
        while ($mostrar_1=mysqli_fetch_row($result_1)) 
        {
         ?>
         <div class="col-6" id="div_tabla_material<?php echo $mostrar_1[0] ?>"></div>
         <?php 
       } ?>
     </div>


     <!-- Modal NUEVO-->
     <div class="modal fade" id="modal_agregar_material" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="col bg-primary text-center text-white  p-2">
              <h4>AGREGAR MATERIAL NUEVO</h4>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frmnuevo">
              <div class="rounded-top bg-light text-muted container col-md-8 font-italic text-center ">Datos del Material</div>
              <div class="text-muted container bg-light">
                <br>
                <div class="form-row">
                  <label class="col-auto">Nombre Material</label>
                  <div class="font-italic form-group col">
                    <input type="text" class="form-control form-control-sm" name="inputNombre_Material_m" id="inputNombre_Material_m" placeholder="Nombre del Material">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnAgregarnuevo">Guardar Material</button>
          </div>
        </div>
      </div>
    </div>


  </section>
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
    <?php 
    while ($mostrar_2=mysqli_fetch_row($result_2)) 
    {
     ?>
     $('#div_tabla_material<?php echo $mostrar_2[0] ?>').load('tablas/material.php/?tipo_material='+<?php echo $mostrar_2[0] ?>);
     <?php 
   } ?>

   $('#div_notificaciones').load('notificaciones.php');

   $('#btnAgregarnuevo').click(function(){
    datos=$('#frmnuevo').serialize();
    $.ajax({
      type:"POST",
      data:datos,
      url:"procesos/agregar_nuevo_material.php",
      success:function(r){
        if(r==1)
        {
          alertify.success("Nuevo Material agregado");
          window.location="material.php";

        }else{
          alertify.error("Fallo al agregar Material" + r);
        }
      }
    });
  });
 });

  function eliminar_material(cod_material){
    alertify.confirm('Eliminar Material', '¿Seguro de eliminar este material?', function(){ 

      $.ajax({
        type:"POST",
        data:"cod_material=" + cod_material,
        url:"procesos/eliminar.php",
        success:function(r){
          if(r==1){
            alertify.success("Eliminado con exito !");
            setTimeout('window.location="material.php"',1000);
          }else{
            alertify.error("No se pudo eliminar...");
          }
        }
      });

    }
    , function(){

    });
  }

  function f_reiniciar_material(cod_material){

    $.ajax({
      type:"POST",
      data:"cod_material=" + cod_material,
      url:"procesos/reiniciar_material.php",
      success:function(r){
        if(r==1){
          alertify.success("Reiniciado con exito con exito !");
          setTimeout('window.location="material.php"',1000);
        }else{
          alertify.error("No se pudo Reiniciar...");
        }
      }
    });
  }

  function agregar_material()
  {

    datos=$('#form_agregar_material').serialize();
    $.ajax({
      type:"POST",
      data:datos,
      url:"procesos/verificacion5.php",

      success:function(r)
      {
        if (r == 4)
        {
          // Envio a Guardar en Base de Datos
          $.ajax({
            type:"POST",
            data:datos,
            url:"procesos/agregar_material.php",

            success:function(r)
            {
              if (r == 1)
              {
                alertify.success("MATERIAL AGREADO CON EXITO");
                $("#inputLargo" ).val('');
                $("#inputAncho" ).val('');
                $("#inputValor" ).val('');
                $("#tipo_material" ).val('');
                window.location="material.php";
              }
              else
              {
                alertify.error("ERROR AL AGREGAR EL MATERIAL"+r);
              }
            }
          });
        }
        else
        {
          alertify.error("FALTAN DATOS" + r);
        }
      }
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

