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
    <title>Clientes</title>
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
            <li class="active"><a href="clientes.php"> <img width="22" height="22" src="img\Iconos/clientes.svg" class="mx-2"></i>Clientes</a></li>
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
          <div class="card">
            <span class="btn boton_peq btn-primary derecha_arriba" id="boton_productos" data-toggle="modal" data-target="#modal_agregar_cliente">Agregar Cliente Nuevo</span>
            <br>
            <div class="row container justify-content-center">
              <label class="col-auto col-form-label">Buscar: </label>
              <div class="mx-3 col-md-4">
                <input type="text" class="form-control form-control-sm" name="input_buscar" id="input_buscar" placeholder="Cedula/Nombre/telefono/correo" required="">
                <input type="text" class="form-control form-control-sm" name="inputCod" id="inputCod" hidden="">
              </div>
              <div class="col-auto">
                <button type="button" class="btn btn-sm btn-primary" id="boton_buscar" onclick="buscar_clientes()">Buscar</button>
              </div>
            </div>
            <br>
          </div>
          <div id="div_tabla_clientes"></div>
          <div id="detalles_cliente"></div>
        </div>

        <!-- Modal NUEVO-->
        <div class="modal fade" id="modal_agregar_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <div class="rounded-top bg-light container col-md-3 font-italic text-center ">Datos del Cliente</div>
                  <div class="container">
                    <br>
                    <div class="form-row">

                      <label>Cédula</label>
                      <div class="font-italic form-group col-md-2 ">
                        <input type="text" class="form-control form-control-sm" name="inputCedula_m" id="inputCedula_m" placeholder="Cédula" required>
                      </div>
                      <label>Nombre</label>
                      <div class="font-italic form-group col">
                        <input type="text" class="form-control form-control-sm" name="inputNombre_Cliente_m" id="inputNombre_Cliente_m" placeholder="Nombre" required>
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

        <!-- Modal Actualizar-->
        <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="frmnuevoU">
                  <input type="text" hidden="" id="cod_clienteU" name="cod_clienteU">
                  <label>Cedula:</label>
                  <input type="text" class="form-control input-sm" id="cedulaver" name="cedulaver" disabled="">
                  <input type="text" class="form-control input-sm" id="cedulaU" name="cedulaU" hidden="">
                  <label>Nombre</label>
                  <input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
                  <label>Direccion</label>
                  <input type="text" class="form-control input-sm" id="direccionU" name="direccionU">
                  <label>Telefono</label>
                  <input type="text" class="form-control input-sm" id="telefonoU" name="telefonoU">
                  <label>Corrreo</label>
                  <input type="text" class="form-control input-sm" id="correoU" name="correoU">
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal MOSTRAR TRABAJO-->
        <div class="modal fade" id="mostrar_trabajo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document" id="div_modal_trabajo">

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
      //$('#div_tabla_clientes').load('tablas/clientes.php');
      $('#div_notificaciones').load('notificaciones.php');
    });

  </script>

  <script type="text/javascript">
    $(document).ready(function(){

      $('#btnAgregarnuevo').click(function(){
        datos=$('#frmnuevo').serialize();
        $.ajax({
          type:"POST",
          data:datos,
          url:"procesos/agregar.php",
          success:function(r)
          {
            if(r==1)
            {
              $('#frmnuevo')[0].reset();
              busqueda=document.getElementById("input_buscar").value;
              if (busqueda != '')
              {
                $('#div_tabla_clientes').load('tablas/clientes.php/?input_buscar='+busqueda);
              }
              alertify.success("Cliente agregado con exito");
            }
            else
            {
              if (r==-1)
              {
                alertify.error("Existe un Cliente con esa Cédula");
              }
              else
              {
                alertify.error("Fallo al agregar Cliente" + r);
              }
            }
          }
        });
      });

      $('#btnActualizar').click(function(){
        datos=$('#frmnuevoU').serialize();

        $.ajax({
          type:"POST",
          data:datos,
          url:"procesos/actualizar.php",
          success:function(r){
            if(r==1)
            {
              busqueda=document.getElementById("input_buscar").value;
              if (busqueda != '')
              {
                $('#div_tabla_clientes').load('tablas/clientes.php/?input_buscar='+busqueda);
              }
              alertify.success("Actualizado con exito :D");
            }else{
              alertify.error("Fallo al actualizar :("+r);
            }
          }
        });
      });
    });

    function agregaFrmActualizar(cod_cliente){
      $.ajax({
        type:"POST",
        data:"cod_cliente=" + cod_cliente,
        url:"procesos/obtenDatos.php",
        success:function(r){
          datos=jQuery.parseJSON(r);
          $('#cod_clienteU').val(datos['cod_cliente']);
          $('#cedulaver').val(datos['cedula']);
          $('#cedulaU').val(datos['cedula']);
          $('#nombreU').val(datos['nombre']);
          $('#direccionU').val(datos['direccion']);
          $('#telefonoU').val(datos['telefono']);
          $('#correoU').val(datos['correo']);
        }
      });
    }

    function buscar_clientes()
    {
      busqueda=document.getElementById("input_buscar").value;
      busqueda = busqueda.replace(/ /gi, "+");
      if (busqueda != '')
      {
        $('#div_tabla_clientes').load('tablas/clientes.php/?input_buscar='+busqueda);
      }
      else
      {
        alertify.error('Ingrese una busqueda');
      }
    }

    function eliminarCliente(cod_cliente){
      alertify.confirm('Eliminar un cliente', '¿Seguro de eliminar este cliente?', function(){ 

        $.ajax({
          type:"POST",
          data:"cod_cliente=" + cod_cliente,
          url:"procesos/eliminar.php",
          success:function(r)
          {
            if(r==1){
              busqueda=document.getElementById("input_buscar").value;
              if (busqueda != '')
              {
                $('#div_tabla_clientes').load('tablas/clientes.php/?input_buscar='+busqueda);
              }
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


    function llamarcliente(cod_cliente) {

      $(document).ready(function(){
        $('#detalles_cliente').load('mostrar_cliente.php/?cod_cliente='+cod_cliente);});

    }

    function mostarcliente(cod_cliente) {

      $.ajax({
        type:"POST",
        data:"cod_cliente=" + cod_cliente,
        url:"procesos/obtenDatos.php",
        success:function(r){
          datos=jQuery.parseJSON(r)
          $("#vercedula" ).text(datos['cedula']);
          $("#vernombre" ).text(datos['nombre']);
          $("#verdireccion" ).text(datos['direccion']);
          $("#vertelefono" ).text(datos['telefono']);
          $("#vercorreo" ).text(datos['correo']);
          $("#veractuales" ).text(datos['puntos_actuales']);
          $("#vertotales" ).text(datos['puntos_totales']);
          $("#verfecha_registro" ).text(datos['fecha_registro']);
        }
      });
    }

    function mostrar_trabajo(cod_trabajo){

      $('#div_modal_trabajo').load('detalles_trabajo.php/?cod_trabajo='+cod_trabajo);

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

    function f_terminado(cod_trabajo,cod_cliente){
      $.ajax({
        type:"POST",
        data:"cod_trabajo="+cod_trabajo,
        url:"procesos/terminar_trabajo.php",

        success:function(r)
        {
          if (r == 1)
          {
            alertify.success("TRABAJO TERMINADO CON ÉXITO");
            $('#tablaTrabajos').load('tablas/trabajos_cliente.php/?cod_cliente='+cod_cliente);
          }
          else
          {
            alertify.error("ERROR AL TERMINAR TRABAJO"+r);
          }
        }
      });
    }

    function f_pendiente(cod_trabajo,cod_cliente){
      $.ajax({
        type:"POST",
        data:"cod_trabajo="+cod_trabajo,
        url:"procesos/trabajo_pendiente.php",

        success:function(r)
        {
          if (r == 1)
          {
            alertify.success("CAMBIADO CON ÉXITO");
            $('#tablaTrabajos').load('tablas/trabajos_cliente.php/?cod_cliente='+cod_cliente);
          }
          else
          {
            alertify.error("ERROR AL CAMBIAR TRABAJO"+r);
          }
        }
      });
    }

    function f_entregado(cod_trabajo,cod_cliente)
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
              url:"procesos/entregar_trabajo.php",

              success:function(a)
              {
                if (a == 1)
                {
                  alertify.success("TRABAJO ENTREGADO CON ÉXITO"+a);
                  $('#tablaTrabajos').load('tablas/trabajos_cliente.php/?cod_cliente='+cod_cliente);

                  alertify.confirm('Imprimir', '¿Desea Imprimir ticket?', function()
                  { 
                    imprimir_copia(cod_trabajo);
                  }
                  , function(){

                  });
                }
                else
                {
                  alertify.error("ERROR AL ENTREGAR TRABAJO"+a);
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
                  imprimir_copia(cod_trabajo);
                  $('#div_tabla_deudas').load('tablas/deudas.php');
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