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

  $responsable_filtro = '0';
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Trabajos Entregados</title>
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
            <li class="active"><a href="trabajos_entregados.php"> <img width="22" height="22" src="img\Iconos/trabajos_entregados.svg" class="mx-2">Trabajos Entregados</a></li>
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
        <div class="container">
          <br>
          <div class="card container">
            <br>
            <form id="form_agregar_trabajo" class="text-right" action="procesos/buscar_trabajo.php" method="post">
              <div class="row container  justify-content-center">
                <label class="col-sm-3 col-form-label">Buscar Compromiso: </label>
                <div class="mx-3">
                  <input type="text" class="form-control form-control-sm" name="input_buscar_trabajo" id="input_buscar_trabajo" placeholder="Codigo de Compromiso" required="">
                  <input type="text" class="form-control form-control-sm" name="inputCod" id="inputCod" required="" hidden="">
                </div>
                <div class="col-auto">
                  <button class="btn btn-sm btn-primary" id="boton_buscar" onclick="buscar_trabajo()">Buscar</button>
                </div>
              </div>
            </form>
            <br>
          </div>
          <div id="div_tabla_trabajos_1" style="height: 345px;"></div>
        </div>
      </section>

      <!-- Modal NUEVO-->
      <div class="modal fade" id="mostrar_trabajo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" id="div_modal_trabajo">

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
      $('#div_tabla_trabajos_1').load('tablas/trabajos.php?num_tabla=5&estado_trabajo=2&responsable='+<?php echo $responsable_filtro ?>);
      $('#div_notificaciones').load('notificaciones.php');

      $("#input_buscar_trabajo").focus();
    });

    function mostrar_trabajo(cod_trabajo){

      $('#div_modal_trabajo').load('detalles_trabajo.php/?cod_trabajo='+cod_trabajo);

    }

    function buscar_trabajo()
    {
      busqueda=document.getElementById("input_buscar_trabajo").value;
      $.ajax({
        type:"POST",
        data:"input_buscar_trabajo="+busqueda,
        url:"procesos/buscar_trabajo.php",

        success:function(r)
        {
          if (r != -1 && r != -2)
          {
            $('#div_modal_trabajo').load('detalles_trabajo.php/?cod_trabajo='+r);
            $('#mostrar_trabajo_modal').modal('show');
            $("#input_buscar_trabajo" ).val('');
          }
          else
          {
            if (r==-1)
            {
              alertify.error("El Compromiso no existe");
              $("#input_buscar_trabajo" ).val('');
            }
          }
        }
      });
    }

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

    function f_recibir_pago(cod_trabajo,cod_cliente)
    {
      datos=$('#form_Valor_recibido').serialize();
      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/verificacion2.php",
        success:function(r)
        {
          if (r >= 0)
          {
            $.ajax({
              type:"POST",
              data:"cod_trabajo="+cod_trabajo+'&valor='+r,
              url:"procesos/recibir_pago.php",

              success:function(a)
              {
                if (a == 1)
                {
                  alertify.success("PAGO RECIBIDO CON ÉXITO"+a);
                  $('#div_tabla_trabajos_1').load('tablas/trabajos.php?num_tabla=5&estado_trabajo=2&responsable='+<?php echo $responsable_filtro ?>);
                  mostrar_trabajo(cod_trabajo);
                  alertify.confirm('Imprimir', '¿Desea Imprimir ticket?', function()
                  { 
                    imprimir_copia(cod_trabajo);
                    
                  }
                  , function(){
                  });
                }
                else
                {
                  alertify.error("ERROR AL RECIBIR PAGO"+a);
                }
              }
            });

          }
          else
          {
            if (r == (-1))
            {
              alertify.error("DIGITE EL VALOR RECIBIDO"+r);
            }
            else
            {
              alertify.error("VALOR RECIBIDO MAYOR AL SALDO"+r);
            }
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