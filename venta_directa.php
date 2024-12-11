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

  if ($rol == 'admin')
  {
    $sql_e = "SELECT  cod_empleado,
    cedula,
    nombre,
    contraseña,
    foto,
    direccion,
    telefono,
    color,
    rol
    FROM empleados WHERE 1";
    $result_e=mysqli_query($conexion,$sql_e);
  }
  else
  {
    $sql_e = "SELECT  cod_empleado,
    cedula,
    nombre,
    contraseña,
    foto,
    direccion,
    telefono,
    color,
    rol
    FROM empleados WHERE cedula = '$usuario'";
    $result_e=mysqli_query($conexion,$sql_e);
  }
  
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Venta Directa</title>
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
            <li class="active"><a href="venta_directa.php"> <img width="22" height="22" src="img\Iconos/venta_directa.svg" class="mx-2">Venta Directa</a></li>
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
            <div class="card-header text-center">
              <h4>VENTA DIRECTA</h4>
            </div>
            <br>
            <div>
              <form id="form_venta_directa" class="text-right">
                <div class="row container">
                  <label class="col-sm-3 col-form-label">Cedula o NIT: </label>
                  <div class="mx-3">
                    <input type="text" class="form-control form-control-sm" name="ver_Cedula" id="ver_Cedula" placeholder="Cedula/NIT" required="">
                    <input type="text" class="form-control form-control-sm" name="inputCedula" id="inputCedula" placeholder="Cedula/NIT" required="" hidden="">
                  </div>
                  <div class="col-auto">
                    <button class="btn btn-sm btn-primary" id="boton_buscar" onclick="buscar_cliente()">Buscar</button>
                    <button class="btn btn-sm btn-danger" id="boton_editar" onclick="editar_cliente()" disabled="">X</button>
                  </div>
                  <label class="col-form-label">Nombre: </label>
                  <div class="col">
                    <input type="text" class="form-control form-control-sm" name="ver_Nombre" id="ver_Nombre" placeholder="Nombre">
                    <input type="text" class="form-control form-control-sm" name="inputNombre" id="inputNombre" placeholder="Nombre" required="" hidden="">
                  </div>
                </div>
                <div class="row container">
                  <div class="col-sm-3">
                    <select class="form-control form-control-sm" id="inputSelect" name="inputSelect" required>
                      <option value="0">Recepción</option>
                      <option value="1">Fotografía</option>
                      <option value="2">Sublimación</option>
                      <option value="3">Digital</option>
                    </select>
                  </div>
                  <div class="col-sm-9">
                    <textarea class="form-control mb-2" id="inputDescripcion" name="inputDescripcion" rows="5" placeholder="Descripcion de venta"></textarea>
                  </div>
                </div>
                <div class="row container" hidden="">
                  <input type="number" class="form-control form-control-sm" name="inputEmpleado" id="inputEmpleado" required="" value="<?php echo $usuario ?>">
                </div>
                <hr>
                <div class="row container">
                  <label class="col-sm-3 col-form-label">Valor: </label>
                  <div class="col-sm-3">
                    <input type="number" class="form-control form-control-sm" name="inputValor" id="inputValor" placeholder="Valor">
                  </div>
                </div>
                <div class="row text-center">
                  <div class="col"></div>
                  <div class="col-sm-2 ">
                    <button type="button" class="btn btn-sm btn-primary text-white" onclick="generar_venta()">Generar Venta</button>
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

        <!-- Modal NUEVO-->
        <div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <div class="col bg-primary text-center text-white  p-2">
                  <h4>AGREGAR CLIENTE</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form  id="frmnuevo">
                  <div class="rounded-top container col-md-3 font-italic text-center ">Datos del Cliente</div>
                  <div class="container">
                    <br>
                    <div class="form-row">

                      <label>Cédula</label>
                      <div class="font-italic form-group col-md-2 ">
                        <input type="text" class="form-control form-control-sm" name="inputCedula_v" id="inputCedula_v" placeholder="Cédula" required disabled="">
                        <input type="text" class="form-control form-control-sm" name="inputCedula_m" id="inputCedula_m" placeholder="Cédula" required hidden="">

                      </div>
                      <label>Nombre</label>
                      <div class="font-italic form-group col">
                        <input type="text" class="form-control form-control-sm" name="inputNombre_Cliente_m" id="inputNombre_Cliente_m" placeholder="Nombre" required>
                      </div>
                      <label>Ocupación</label>
                      <div class="font-italic form-group col-md-2 ">
                        <input type="text" class="form-control form-control-sm" name="inputOcupacion_m" id="inputOcupacion_m" placeholder="Ej: Conductor" required>
                      </div>
                    </div>
                    <div class="form-row">
                      <label>Dirección</label>
                      <div class="font-italic form-group col-md-7">
                        <input type="text" class="form-control form-control-sm" name="inputDireccion_m" id="inputDireccion_m" placeholder="Ej: Cra 9 # 3- 111" required>
                      </div>
                      <label>Teléfono</label>
                      <div class="font-italic form-group col">
                        <input type="tel" class="form-control form-control-sm" name="inputTelefono_m" id="inputTelefono_m" placeholder="Ej: xxx xxxx xxx" required>
                      </div>
                    </div>
                    <div class="form-row">
                      <label>Correo</label>
                      <div class="font-italic form-group col-md-6">
                        <input type="email" class="form-control form-control-sm" name="inputCorreo_m" id="inputCorreo_m" placeholder="Ej: cliente@mail.com" required>
                      </div>
                      <label>Facebook</label>
                      <div class="font-italic form-group col">
                        <input type="text" class="form-control form-control-sm" name="inputFacebook_m" id="inputFacebook_m" placeholder="Ej: facebook/cliente" required>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarnuevo">Guardar Cliente</button>
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
      $('#div_notificaciones').load('notificaciones.php');

      $('#btnAgregarnuevo').click(function(){
        datos=$('#frmnuevo').serialize();
        $.ajax({
          type:"POST",
          data:datos,
          url:"procesos/agregar.php",
          success:function(r){
            if(r==1)
            {
              $('#frmnuevo')[0].reset();
              $('#agregarnuevosdatosmodal').modal('hide');
              alertify.success("Cliente agregado con exito");
              buscar_cliente();
            }else{
              alertify.error("Fallo al agregar Cliente" + r);
            }
          }
        });
      });
    });

    function generar_venta()
    {

      datos=$('#form_venta_directa').serialize();
      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/verificacion3.php",

        success:function(r)
        {
          if (r == 6)
          {
            // Envio a Guardar en Base de Datos
            $.ajax({
              type:"POST",
              data:datos,
              url:"procesos/agregar_venta.php",

              success:function(r)
              {
                if (r >= 0)
                {
                  r=r-0;
                  alertify.success("VENTA REALIZADA CON EXITO");
                  $.ajax({
                    type:"POST",
                    data:"cod_venta="+r,
                    url:"ticket.php",

                    success:function(r)
                    {
                      if (r == 1)
                      {
                        alertify.warning("IMPRESION GENERADA");
                        $("#inputDescripcion" ).val('');
                        $("#inputValor" ).val('');
                        $("#inputCedula" ).val('');
                        $("#ver_Cedula" ).val('');
                        $("#inputNombre" ).val('');
                        $("#ver_Nombre" ).val('');
                        $('#inputSelect').val(0);
                        document.getElementById("ver_Cedula").disabled = false;
                        document.getElementById("ver_Nombre").disabled = false;
                        document.getElementById("boton_buscar").disabled = false;
                        document.getElementById("boton_editar").disabled = true;
                      }
                      else
                      {
                        alertify.error("ERROR de IMPRESION"+r);
                      }
                    }
                  });
                }
                else
                {
                  alertify.error("ERROR AL GUARDAR EN BASE DE DATOS"+r);
                }
              }
            });
          }
          else
          {
            alertify.error("FALTAN DATOS");
          }
        }
      });
    }

    function buscar_cliente()
    {
      datos=$('#form_venta_directa').serialize();
      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/obtenDatos.php",

        success:function(r)
        {
          datos=jQuery.parseJSON(r)
          if (datos['nombre']=='NO ENCONTRADO') 
          {
            alertify.error("Cliente NO ENCONTRADO");
            alertify.confirm('Cliente NO ENCONTRADO', '¿Desea agregar un nuevo cliente?', function()
            {
              $('#agregarnuevosdatosmodal').modal('show');
              $("#inputCedula_v" ).val(datos['cedula']);
              $("#inputCedula_m" ).val(datos['cedula']);
            }
            , function(){

            });
          }
          else
          {
            alertify.success("Cliente ENCONTRADO");
            $("#inputCedula" ).val(datos['cedula']);
            $("#inputNombre" ).val(datos['nombre']);
            $("#ver_Cedula" ).val(datos['cedula']);
            $("#ver_Nombre" ).val(datos['nombre']);
            document.getElementById("ver_Cedula").disabled = true;
            document.getElementById("ver_Nombre").disabled = true;
            document.getElementById("boton_buscar").disabled = true;
            document.getElementById("boton_editar").disabled = false;
          }
        }
      });

    }

    function editar_cliente()
    {
      $("#inputCedula" ).val('');
      $("#inputNombre" ).val('');
      $("#ver_Nombre" ).val('');
      document.getElementById("ver_Cedula").disabled = false;
      document.getElementById("ver_Nombre").disabled = false;
      document.getElementById("boton_buscar").disabled = false;
      document.getElementById("boton_editar").disabled = true;
    }


  </script>

  <?php 
}
else
{
  header("Location:login.php");
} 
?>