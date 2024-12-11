<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$num_tabla = 1;
$fecha_i = date('Y-m-d') . ' 00:00:00';
$fecha_f = date('Y-m-d') . ' 23:59:59';

session_start();
if (isset($_SESSION['productos']))
{
  unset($_SESSION['productos']);
}

if (isset($_SESSION['usuario']))
{
	$usuario = $_SESSION['usuario'];

	$sql_e = "SELECT nombre, rol, foto, direccion, telefono, color, contraseña FROM empleados WHERE cedula = '$usuario'";
	$result_e=mysqli_query($conexion,$sql_e);
	$ver_e=mysqli_fetch_row($result_e);

	$nombre_usuario = ' ' .  $ver_e[0];
	$rol = $ver_e[1];
  $foto_empleado = $ver_e[2];
  $foto_empleado = $ver_e[2];
  $direccion = $ver_e[3];
  $telefono = $ver_e[4];
  $color = $ver_e[5];
  $contraseña = $ver_e[6];

  $sql_trabajos = "SELECT count(*) FROM `trabajos` WHERE responsable = '$usuario' AND estado = 'PENDIENTE'";
  $result_trabajos=mysqli_query($conexion,$sql_trabajos);
  $ver_trabajos=mysqli_fetch_row($result_trabajos);

  $num_pendientes = $ver_trabajos[0];

  $sql_trabajos = "SELECT count(*) FROM `trabajos` WHERE responsable = '$usuario' AND estado = 'TERMINADO'";
  $result_trabajos=mysqli_query($conexion,$sql_trabajos);
  $ver_trabajos=mysqli_fetch_row($result_trabajos);

  $num_terminados = $ver_trabajos[0];

  $sql_trabajos = "SELECT count(*) FROM `ventas_directas` WHERE responsable = '$usuario' AND fecha_recepcion BETWEEN '$fecha_i' AND '$fecha_f'";
  $result_trabajos=mysqli_query($conexion,$sql_trabajos);
  $ver_trabajos=mysqli_fetch_row($result_trabajos);

  $num_ventas = 0;
  $num_ventas += $ver_trabajos[0];

  $sql_trabajos = "SELECT SUM(`valor`) FROM `cuentas_diarias` WHERE responsable = '$usuario' AND fecha BETWEEN '$fecha_i' AND '$fecha_f'";
  $result_trabajos=mysqli_query($conexion,$sql_trabajos);
  $ver_trabajos=mysqli_fetch_row($result_trabajos);

  $efectivo = 0;
  $efectivo += $ver_trabajos[0];
  $efectivo = number_format($efectivo);

  $color_rgb = substr($color, 4,-1);

  $color_rgb = explode(",",$color);
  $R = $color_rgb[0];
  $G = $color_rgb[1];
  $B = $color_rgb[2];

  $R = dechex($R);
  if (strlen($R)<2)
    $R = '0'.$R;

  $G = dechex($G);
  if (strlen($G)<2)
    $G = '0'.$G;

  $B = dechex($B);
  if (strlen($B)<2)
    $B = '0'.$B;

  $color_hex = '#' . $R . $G . $B;

  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Perfil</title>
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
      <!--<li class="active"><a href="index.php"> <img width="22" height="22" src="img\Iconos/inicio.svg" class="mx-2"></i>Inicio</a></li>-->
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
       <li class="active"><a href="perfil.php"> <img width="22" height="22" src="img\Iconos/perfil.svg" class="mx-2">Configurar Perfil</a></li> 
       
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
<!-- Header Section-->
<section>
  <br>
  <!-- Client Profile -->

  <div class="card container">
    <div class="card-body text-center">
      <span class="btn boton_peq boton_edit derecha_arriba" id="boton_editar" onclick="f_editar_empleado()">Editar</span>
      <span class="btn boton_peq boton_ok derecha_arriba text-white" id="boton_ok_editar" onclick="f_editar_empleado_fin('<?php echo $usuario ?>')" hidden="">Guardar</span>
      <div class="client-avatar">
        <img src="<?php echo $foto_empleado ?>" width="150" height="150" alt="..." class="img-fluid rounded-circle borde_color" style=" border-color: <?php echo $color ?>;">
        <div class="status bg-green"></div>
      </div>
      <div class="client-title">
        <h3><?php echo $nombre_usuario ?></h3>
      </div>
      <hr>
      <div class="client-info">
        <div class="row">
          <div class="col-4 text-danger"><strong><?php echo $num_pendientes ?></strong><br><div class="texto_junto"><small>Trabajos Pendientes</small></div></div>
          <div class="col-4 text-success"><strong><?php echo $num_terminados ?></strong><br><div class="texto_junto"><small>Trabajos Terminados</small></div></div>
          <div class="col-4 "><strong><?php echo $num_ventas ?></strong><br><div class="texto_junto"><small>N° Ventas Directas</small></div></div>
        </div>
      </div>
      <hr>
      
      
      <div class="client-info">
        <form id="form_editar_empleado">
          <input type="text" name="cc_usuario" id="cc_usuario" value="<?php echo $usuario ?>" hidden="">
          <div class="row d-flex align-items-center justify-content-between">
            <div class="text-muted col-auto col-form-label">Nombre:</div>
            <div class="col-9 text-left" id="div_nombre_usuario"><?php echo $nombre_usuario ?></div>
            <input type="text" class="col-9" name="input_nombre_usuario" id="input_nombre_usuario" value="<?php echo $nombre_usuario ?>" hidden="">
          </div>
          <div class="row d-flex align-items-center justify-content-between">
            <div class="text-muted col-auto col-form-label">Dirección:</div>
            <div class="col-9 text-left" id="div_direccion"><?php echo $direccion ?></div>
            <input type="text" class="col-9" name="input_direccion" id="input_direccion" value="<?php echo $direccion ?>" hidden="">
          </div>
          <div class="row d-flex align-items-center justify-content-between">
            <div class="text-muted col-auto col-form-label">Telefono:</div>
            <div class="col-9 text-left" id="div_telefono"><?php echo $telefono ?></div>
            <input type="text" class="col-9" name="input_telefono" id="input_telefono" value="<?php echo $telefono ?>" hidden="">
          </div>
          <div class="row d-flex align-items-center justify-content-between">
            <div class="text-muted col-auto col-form-label">Color:</div>
            <div class="col-9 text-left" id="div_color_emp"><?php echo $color ?><span class="circulo" style="background-color: <?php echo $color ?>;"></span></div>
            <input type="color" class="col-9" name="input_color_emp" id="input_color_emp" hidden="" value="<?php echo $color_hex ?>">
          </div>
        </form>
        <form id="form_contraseña">
          <input type="text" name="cc_usuario" id="cc_usuario" value="<?php echo $usuario ?>" hidden="">
          <div class="row d-flex align-items-center justify-content-between">
            <div class="text-muted col-auto col-form-label">Contraseña:</div>
            <div class="col-5 text-left" id="div_contraseña">*********</div><span class="btn boton_peq boton_edit" id="boton_editar_contraseña" onclick="f_editar_contraseña()">Cambiar Contraseña</span>
            <div class="col-9" id="div_input_contraseña" hidden="">
              <div class="row text-muted">
                <label class="col-3 mx-2">Actual</label>
                <label class="col-3 mx-2">Nueva</label>
                <label class="col-3 mx-2">Repetir Nueva</label>
              </div>
              <div class="row">
                <input type="password" class="col-3 mx-2 form-control form-control-sm" name="input_contraseña" id="input_contraseña" required="">
                <input type="password" class="col-3 mx-2 form-control form-control-sm" name="input_contraseña_1" id="input_contraseña_1" required="">
                <input type="password" class="col-3 mx-2 form-control form-control-sm" name="input_contraseña_2" id="input_contraseña_2" required="">
                <span class="btn boton_peq boton_ok text-white" id="boton_ok_editar_contraseña" onclick="f_editar_contraseña_fin('<?php echo $usuario ?>')"  hidden="">Guardar</span>
              </div>
            </div>
          </div>
        </form>
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
    $('#div_grafica').load('graficas/perfil_empleados.php/?usuario='+<?php echo $usuario ?>);
    $('#div_notificaciones').load('notificaciones.php');
  });

  function f_editar_empleado()
  {
    document.getElementById("boton_editar").hidden = true;
    document.getElementById("boton_ok_editar").hidden = false;
    document.getElementById("div_nombre_usuario").hidden = true;
    document.getElementById("input_nombre_usuario").hidden = false;
    document.getElementById("div_direccion").hidden = true;
    document.getElementById("input_direccion").hidden = false;
    document.getElementById("div_telefono").hidden = true;
    document.getElementById("input_telefono").hidden = false;
    document.getElementById("div_color_emp").hidden = true;
    document.getElementById("input_color_emp").hidden = false;
    document.getElementById("div_contraseña").hidden = true;
    document.getElementById("input_contraseña").hidden = false;
  }

  function f_editar_contraseña()
  {
    document.getElementById("div_contraseña").hidden = true;
    document.getElementById("div_input_contraseña").hidden = false;
    document.getElementById("boton_editar_contraseña").hidden = true;
    document.getElementById("boton_ok_editar_contraseña").hidden = false;
  }

  function f_editar_empleado_fin(cc_empleado)
  {
    datos=$('#form_editar_empleado').serialize();
    $.ajax({
      type:"POST",
      data:datos,
      url:"procesos/editar_empleado.php",

      success:function(r)
      {
        if (r == 1)
        {
          alertify.success("Editado con exito");
          window.location="perfil.php";
        }
        else
        {
          alertify.error("ERROR AL EDITAR"+r);
        }
      }
    });

  }

  function f_editar_contraseña_fin()
  {
    datos=$('#form_contraseña').serialize();
    $.ajax({
      type:"POST",
      data:datos,
      url:"procesos/editar_contraseña.php",

      success:function(r)
      {
        if (r == 1)
        {
          alertify.success("Contraseña Editada con exito");
          window.location="perfil.php";
        }
        else
        {
          alertify.error("ERROR AL EDITAR CONTRASEÑA("+r+")");
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