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

  $sql_empleado="SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE cod_empleado>1 AND rol != 'inactivo'";
  $result_empleado=mysqli_query($conexion,$sql_empleado); 

  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contabilidad</title>
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
            <h2 class="h5">Arquidiseños</h2><span>Agencia de Arquitectura y Publicidad</span>
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
          <li class="active"><a href="contabilidad.php"> <img width="22" height="22" src="img\Iconos/contabilidad.svg" class="mx-2">Contabilidad</a></li>
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
        <br>
        <div class="container">
          <div class="card">
            <br>
            <form class="row text-center" action="contabilidad.php" method="post">
              <div class="col"></div>
              <div class="col-md-8">
                <div class="row align-items-center">
                  <label class="h5">Fecha Inicial</label>
                  <div class="font-italic col-md-4">
                    <input type="date" class="form-control form-control-sm" name="Inicial" id="Inicial" >
                  </div>
                  <label class="h5">Fecha Final</label>
                  <div class="font-italic col-md-4">
                    <input type="date" class="form-control form-control-sm" name="Final" id="Final" >
                  </div>
                  <input type="submit" name="btn_filtrar" class="btn btn-primary btn-sm" value="Buscar">
                </div>
                <br>
              </div>
              <div class="col"></div>
            </form>
          </div>
        </div>
        <?php if (isset($_POST['btn_filtrar'])) 
        { ?>
          <div class="row d-flex align-items-center justify-content-center">
            <?php 
            while ($mostrar_empleado=mysqli_fetch_row($result_empleado)) 
            {
              if (($_POST['Inicial'] != '') || ($_POST['Final'] != '')) 
              {
                $fecha_inicial = $_POST['Inicial'] . ' 00:00:00';
                $fecha_final = $_POST['Final'] . ' 23:59:59';
              }
              else
              {
                $fecha_inicial = '0001-01-01';
                $fecha_final = '';
              }

              $sql_cuentas = "SELECT `codigo`, `cod_trabajo`, `valor`, `descripcion`, `responsable`, `fecha`, SUM(`valor`) FROM `cuentas_diarias` WHERE responsable='$mostrar_empleado[1]' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";
              $result_cuentas=mysqli_query($conexion,$sql_cuentas);
              $mostrar_cuentas=mysqli_fetch_row($result_cuentas);

              $foto_empleado = $mostrar_empleado[4];
              $nombre_empleado = $mostrar_empleado[2];
              $total_ventas = 0;
              $total_ventas += $mostrar_cuentas[6];

              if ($_POST['Inicial'] == $_POST['Final'])
              {
                if ($_POST['Inicial'] == $fecha )
                {
                  $rango_tiempo = 'HOY';
                  $envio_fecha = '/?fecha=' . $fecha;
                }
                else
                {
                  $rango_tiempo = 'Dia: ' . $_POST['Inicial'];
                  $envio_fecha = '/?fecha='. $_POST['Inicial'];
                }
              }
              else
              {
                $rango_tiempo = 'Entre: ' . $_POST['Inicial'] . ' y ' . $_POST['Final'];
                $envio_fecha = '/?fecha_inicial='. $_POST['Inicial'] . '&fecha_final=' . $_POST['Final'];
              }
              ?>
              <div class="ml-3 card col-md-5">
                <br>
                <div rel="nofollow" href="#" class="d-flex"> 
                  <div class="msg-profile"> <img src="<?php echo $foto_empleado ?>" width="70" height="70" alt="..." class="img-fluid rounded-circle"></div>
                  <div class="msg-body">
                    <h3 class="h5 row ml-3"><?php echo $nombre_empleado ?></h3>
                    <span class="row ml-3" >Total de ventas: $ <?php echo number_format($total_ventas) ?></span>
                    <small class="row ml-3"><?php echo $rango_tiempo ?></small>
                  </div>
                </div>
                <br>
              </div>
              <?php 
            }
            ?>
          </div>
          <div class="row d-flex align-items-center justify-content-center" id="div_grafica">

          </div>
          <div class="container d-flex justify-content-between container">
            <form class="row text-center" action="graficas/contabilidad_xls.php" method="get">
              <input type="date" class="form-control form-control-sm" name="fecha_inicial" id="fecha_inicial" value="<?php echo $_POST['Inicial'] ?>" hidden="">
              <input type="date" class="form-control form-control-sm" name="fecha_final" id="fecha_final" value="<?php echo $_POST['Final'] ?>" hidden="">
              <button type="submit" name="btn_filtrar" class="btn btn-success mx-2 col-auto"><img src="img/Iconos/archivo_excel.svg" class="mx-2">GENERAR XLS (VENTAS)</button>
            </form>
          </div>
          <?php 
        } 
        ?>
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
      $('#div_notificaciones').load('notificaciones.php');
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function()
    {
      $('#div_notificaciones').load('notificaciones.php');
      $('#div_tabla_deudas').load('tablas/deudas.php');
      $('#div_grafica').load('graficas/barras_empleados.php<?php echo $envio_fecha ?>');
    });


    function imprimir_copia(cod_trabajo){
      $.ajax({
        type:"POST",
        data:"cod_trabajo_c="+cod_trabajo,
        url:"ticket.php",

        success:function(r)
        {
          if (r == 1)
          {
            alertify.warning("IMPRESION GENERADA");
          }
          else
          {
            alertify.error("ERROR de IMPRESION");
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