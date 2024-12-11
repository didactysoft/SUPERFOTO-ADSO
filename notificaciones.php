<?php 
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$fecha_p = date("Y-m-d",strtotime($fecha."- 15 days"));

$sql_not = "SELECT COUNT(*) FROM `deudas` WHERE fecha_creacion < '$fecha_p' AND estado = 'EN MORA'";
$result_not=mysqli_query($conexion,$sql_not);
$mostrar_not=mysqli_fetch_row($result_not);

$cant_notificaciones = 0;
$cant_notificaciones += $mostrar_not[0];

$sql_not = "SELECT `cod_deuda`, `cod_trabajo`, `valor`, `fecha_creacion`, `estado` FROM `deudas` WHERE fecha_creacion < '$fecha_p' AND estado = 'EN MORA' order by fecha_creacion ASC";
$result_not=mysqli_query($conexion,$sql_not);

?>
<!-- Notifications dropdown-->
<li class="nav-item dropdown"> 
  <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
    <i class="fa fa-dollar"></i><span class="badge badge-warning"><?php echo $cant_notificaciones ?></span>
  </a>
  <ul aria-labelledby="notifications" class="dropdown-menu">
    <?php 
    while ($mostrar_not=mysqli_fetch_row($result_not))
    {
      $date1 = new DateTime($fecha);
      $date2 = new DateTime(substr($mostrar_not[3],0,10));
      $diff = $date1->diff($date2);

      $tiempo_dias = $diff->days . ' días ';

      $sql_trabajo = "SELECT `cod_trabajo`, `titulo`, `ruta`, `cc_cliente`, `descripción`, `estado`, `responsable`, `total`, `abono`, `fecha_entrega`, `hora_entrega`, `fecha_recepcion` FROM `trabajos` WHERE cod_trabajo = '$mostrar_not[1]'";
      $result_trabajo=mysqli_query($conexion,$sql_trabajo);
      $mostrar_trabajo=mysqli_fetch_row($result_trabajo);

      $sql_cliente = "SELECT `cod_cliente`, `cedula`, `nombre`, `direccion`, `telefono`, `correo`, `puntos_actuales`, `puntos_totales`, `fecha_registro` FROM `clientes` WHERE cedula = '$mostrar_trabajo[3]'";
      $result_cliente=mysqli_query($conexion,$sql_cliente);
      $mostrar_cliente=mysqli_fetch_row($result_cliente);

      $nombre_cliente = substr($mostrar_cliente[2], 0,20);

      $valor_deuda = number_format($mostrar_not[2]);

      ?>
      <li><a rel="nofollow" href="por_cobrar.php" class="dropdown-item"> 
        <div class="notification d-flex justify-content-between">
          <div class="notification-content h3">$ <?php echo $valor_deuda ?></div>
          <div class="notification-content"><?php echo $nombre_cliente ?></div>
          <div class="notification-time"><small>Hace <?php echo $tiempo_dias ?></small></div>
        </div></a>
      </li>
      <?php 
    }
    ?>
    <!-- 
    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-bell"></i>view all notifications                                            </strong></a>
    </li>
  -->
</ul>
</li>

<!-- Messages dropdown-->

<!--
              <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope"></i><span class="badge badge-info">10</span></a>
                <ul aria-labelledby="notifications" class="dropdown-menu">
                  <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                    <div class="msg-profile"> <img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>
                    <div class="msg-body">
                      <h3 class="h5">Jason Doe</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                    </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                      <div class="msg-profile"> <img src="img/avatar-2.jpg" alt="..." class="img-fluid rounded-circle"></div>
                      <div class="msg-body">
                        <h3 class="h5">Frank Williams</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                      </div></a></li>
                      <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                        <div class="msg-profile"> <img src="img/avatar-3.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h3 class="h5">Ashley Wood</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                        </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-envelope"></i>Read all messages    </strong></a></li>
                      </ul>
                    </li>

                  -->