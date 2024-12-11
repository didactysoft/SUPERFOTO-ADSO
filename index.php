<?php
// Establecer la zona horaria
date_default_timezone_set('America/Bogota');

// Obtener fechas actuales
$fecha_h = date('Y-m-d G:i:s');
$fecha = date('Y-m-d');

// Cargar archivo de conexión a la base de datos
require_once "clases/conexion.php";

try {
    // Crear instancia de conexión
    $obj = new conectar();
    $conexion = $obj->conexion();
} catch (Exception $e) {
    // Manejo de errores en la conexión
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Inicializar variables necesarias
$num_tabla = 1;

// Iniciar sesión
session_start();

// Verificar si la sesión 'productos' está activa y limpiarla
if (!empty($_SESSION['productos'])) {
    unset($_SESSION['productos']);
}

// Redirigir según el estado de la sesión del usuario
if (isset($_SESSION['usuario'])) {
    header("Location: trabajos_pendientes.php");
    exit; // Asegurar que no se ejecuten líneas posteriores
} else {
    header("Location: login.php");
    exit; // Asegurar que no se ejecuten líneas posteriores
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Superfoto Pamplona</title>
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
              <div class="brand-text d-none d-md-inline-block"><span>Bootstrap </span><strong class="text-primary">Dashboard</strong></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <div id="div_notificaciones"></div>
                              <!-- Log out-->
                              <li class="nav-item"><a href="procesos/cerrar_sesion.php" class="nav-link logout"> <span class="d-none d-sm-inline-block">Cerrar Sesión</span><i class="fa fa-sign-out"></i></a></li>
                            </ul>
                          </div>
                        </div>
                      </nav>
                    </header>
                    <section class="dashboard-counts section-padding">
                      <div class="container-fluid">
                        <div class="row">
                          <!-- Count item widget-->
                          <div class="col-xl-2 col-md-4 col-6">
                            <div class="wrapper count-title d-flex">
                              <div class="icon"><i class="icon-user"></i></div>
                              <div class="name"><strong class="text-uppercase">New Clients</strong><span>Last 7 days</span>
                                <div class="count-number">25</div>
                              </div>
                            </div>
                          </div>
                          <!-- Count item widget-->
                          <div class="col-xl-2 col-md-4 col-6">
                            <div class="wrapper count-title d-flex">
                              <div class="icon"><i class="icon-padnote"></i></div>
                              <div class="name"><strong class="text-uppercase">Work Orders</strong><span>Last 5 days</span>
                                <div class="count-number">400</div>
                              </div>
                            </div>
                          </div>
                          <!-- Count item widget-->
                          <div class="col-xl-2 col-md-4 col-6">
                            <div class="wrapper count-title d-flex">
                              <div class="icon"><i class="icon-check"></i></div>
                              <div class="name"><strong class="text-uppercase">New Quotes</strong><span>Last 2 months</span>
                                <div class="count-number">342</div>
                              </div>
                            </div>
                          </div>
                          <!-- Count item widget-->
                          <div class="col-xl-2 col-md-4 col-6">
                            <div class="wrapper count-title d-flex">
                              <div class="icon"><i class="icon-bill"></i></div>
                              <div class="name"><strong class="text-uppercase">New Invoices</strong><span>Last 2 days</span>
                                <div class="count-number">123</div>
                              </div>
                            </div>
                          </div>
                          <!-- Count item widget-->
                          <div class="col-xl-2 col-md-4 col-6">
                            <div class="wrapper count-title d-flex">
                              <div class="icon"><i class="icon-list"></i></div>
                              <div class="name"><strong class="text-uppercase">Open Cases</strong><span>Last 3 months</span>
                                <div class="count-number">92</div>
                              </div>
                            </div>
                          </div>
                          <!-- Count item widget-->
                          <div class="col-xl-2 col-md-4 col-6">
                            <div class="wrapper count-title d-flex">
                              <div class="icon"><i class="icon-list-1"></i></div>
                              <div class="name"><strong class="text-uppercase">New Cases</strong><span>Last 7 days</span>
                                <div class="count-number">70</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <!-- Header Section-->
                    <section class="dashboard-header section-padding">
                      <div class="container-fluid">
                        <div class="row d-flex align-items-md-stretch">
                          <!-- To Do List-->
                          <div class="col-lg-3 col-md-6">
                            <div class="card to-do">
                              <h2 class="display h4">To do List</h2>
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                              <ul class="check-lists list-unstyled">
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-1" name="list-1" class="form-control-custom">
                                  <label for="list-1">Similique sunt in culpa qui officia</label>
                                </li>
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-2" name="list-2" class="form-control-custom">
                                  <label for="list-2">Ed ut perspiciatis unde omnis iste</label>
                                </li>
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-3" name="list-3" class="form-control-custom">
                                  <label for="list-3">At vero eos et accusamus et iusto </label>
                                </li>
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-4" name="list-4" class="form-control-custom">
                                  <label for="list-4">Explicabo Nemo ipsam voluptatem</label>
                                </li>
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-5" name="list-5" class="form-control-custom">
                                  <label for="list-5">Similique sunt in culpa qui officia</label>
                                </li>
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-6" name="list-6" class="form-control-custom">
                                  <label for="list-6">At vero eos et accusamus et iusto </label>
                                </li>
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-7" name="list-7" class="form-control-custom">
                                  <label for="list-7">Similique sunt in culpa qui officia</label>
                                </li>
                                <li class="d-flex align-items-center"> 
                                  <input type="checkbox" id="list-8" name="list-8" class="form-control-custom">
                                  <label for="list-8">Ed ut perspiciatis unde omnis iste</label>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <!-- Pie Chart-->
                          <div class="col-lg-3 col-md-6">
                            <div class="card project-progress">
                              <h2 class="display h4">Project Beta progress</h2>
                              <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                              <div class="pie-chart">
                                <canvas id="pieChart" width="300" height="300"> </canvas>
                              </div>
                            </div>
                          </div>
                          <!-- Line Chart -->
                          <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
                            <div class="card sales-report">
                              <h2 class="display h4">Sales marketing report</h2>
                              <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet officiis</p>
                              <div class="line-chart">
                                <canvas id="lineCahrt"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <!-- Statistics Section-->
                    <section class="statistics">
                      <div class="container-fluid">
                        <div class="row d-flex">
                          <div class="col-lg-4">
                            <!-- Income-->
                            <div class="card income text-center">
                              <div class="icon"><i class="icon-line-chart"></i></div>
                              <div class="number">126,418</div><strong class="text-primary">All Income</strong>
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do.</p>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <!-- Monthly Usage-->
                            <div class="card data-usage">
                              <h2 class="display h4">Monthly Usage</h2>
                              <div class="row d-flex align-items-center">
                                <div class="col-sm-6">
                                  <div id="progress-circle" class="d-flex align-items-center justify-content-center"></div>
                                </div>
                                <div class="col-sm-6"><strong class="text-primary">80.56 Gb</strong><small>Current Plan</small><span>100 Gb Monthly</span></div>
                              </div>
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <!-- User Actibity-->
                            <div class="card user-activity">
                              <h2 class="display h4">User Activity</h2>
                              <div class="number">210</div>
                              <h3 class="h4 display">Social Users</h3>
                              <div class="progress">
                                <div role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
                              </div>
                              <div class="page-statistics d-flex justify-content-between">
                                <div class="page-statistics-left"><span>Pages Visits</span><strong>230</strong></div>
                                <div class="page-statistics-right"><span>New Visits</span><strong>73.4%</strong></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <!-- Updates Section -->
                    <section class="mt-30px mb-30px">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-lg-4 col-md-12">
                            <!-- Recent Updates Widget          -->
                            <div id="new-updates" class="card updates recent-updated">
                              <div id="updates-header" class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="h5 display"><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box" aria-expanded="true" aria-controls="updates-box">News Updates</a></h2><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box" aria-expanded="true" aria-controls="updates-box"><i class="fa fa-angle-down"></i></a>
                              </div>
                              <div id="updates-box" role="tabpanel" class="collapse show">
                                <ul class="news list-unstyled">
                                  <!-- Item-->
                                  <li class="d-flex justify-content-between"> 
                                    <div class="left-col d-flex">
                                      <div class="icon"><i class="icon-rss-feed"></i></div>
                                      <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                                      </div>
                                    </div>
                                    <div class="right-col text-right">
                                      <div class="update-date">24<span class="month">Jan</span></div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li class="d-flex justify-content-between"> 
                                    <div class="left-col d-flex">
                                      <div class="icon"><i class="icon-rss-feed"></i></div>
                                      <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                                      </div>
                                    </div>
                                    <div class="right-col text-right">
                                      <div class="update-date">24<span class="month">Jan</span></div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li class="d-flex justify-content-between"> 
                                    <div class="left-col d-flex">
                                      <div class="icon"><i class="icon-rss-feed"></i></div>
                                      <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                                      </div>
                                    </div>
                                    <div class="right-col text-right">
                                      <div class="update-date">24<span class="month">Jan</span></div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li class="d-flex justify-content-between"> 
                                    <div class="left-col d-flex">
                                      <div class="icon"><i class="icon-rss-feed"></i></div>
                                      <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                                      </div>
                                    </div>
                                    <div class="right-col text-right">
                                      <div class="update-date">24<span class="month">Jan</span></div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li class="d-flex justify-content-between"> 
                                    <div class="left-col d-flex">
                                      <div class="icon"><i class="icon-rss-feed"></i></div>
                                      <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                                      </div>
                                    </div>
                                    <div class="right-col text-right">
                                      <div class="update-date">24<span class="month">Jan</span></div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li class="d-flex justify-content-between"> 
                                    <div class="left-col d-flex">
                                      <div class="icon"><i class="icon-rss-feed"></i></div>
                                      <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                                      </div>
                                    </div>
                                    <div class="right-col text-right">
                                      <div class="update-date">24<span class="month">Jan</span></div>
                                    </div>
                                  </li>
                                </ul>
                              </div>
                            </div>
                            <!-- Recent Updates Widget End-->
                          </div>
                          <div class="col-lg-4 col-md-6">
                            <!-- Daily Feed Widget-->
                            <div id="daily-feeds" class="card updates daily-feeds">
                              <div id="feeds-header" class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="h5 display"><a data-toggle="collapse" data-parent="#daily-feeds" href="#feeds-box" aria-expanded="true" aria-controls="feeds-box">Your daily Feeds </a></h2>
                                <div class="right-column">
                                  <div class="badge badge-primary">10 messages</div><a data-toggle="collapse" data-parent="#daily-feeds" href="#feeds-box" aria-expanded="true" aria-controls="feeds-box"><i class="fa fa-angle-down"></i></a>
                                </div>
                              </div>
                              <div id="feeds-box" role="tabpanel" class="collapse show">
                                <div class="feed-box">
                                  <ul class="feed-elements list-unstyled">
                                    <!-- List-->
                                    <li class="clearfix">
                                      <div class="feed d-flex justify-content-between">
                                        <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-5.jpg" alt="person" class="img-fluid rounded-circle"></a>
                                          <div class="content"><strong>Aria Smith</strong><small>Posted a new blog </small>
                                            <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                                          </div>
                                        </div>
                                        <div class="date"><small>5min ago</small></div>
                                      </div>
                                    </li>
                                    <!-- List-->
                                    <li class="clearfix">
                                      <div class="feed d-flex justify-content-between">
                                        <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-2.jpg" alt="person" class="img-fluid rounded-circle"></a>
                                          <div class="content"><strong>Frank Williams</strong><small>Posted a new blog </small>
                                            <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                                            <div class="CTAs"><a href="#" class="btn btn-xs btn-dark"><i class="fa fa-thumbs-up"> </i>Like</a><a href="#" class="btn btn-xs btn-dark"><i class="fa fa-heart"> </i>Love</a></div>
                                          </div>
                                        </div>
                                        <div class="date"><small>5min ago</small></div>
                                      </div>
                                    </li>
                                    <!-- List-->
                                    <li class="clearfix">
                                      <div class="feed d-flex justify-content-between">
                                        <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-3.jpg" alt="person" class="img-fluid rounded-circle"></a>
                                          <div class="content"><strong>Ashley Wood</strong><small>Posted a new blog </small>
                                            <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                                          </div>
                                        </div>
                                        <div class="date"><small>5min ago</small></div>
                                      </div>
                                    </li>
                                    <!-- List-->
                                    <li class="clearfix">
                                      <div class="feed d-flex justify-content-between">
                                        <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-1.jpg" alt="person" class="img-fluid rounded-circle"></a>
                                          <div class="content"><strong>Jason Doe</strong><small>Posted a new blog </small>
                                            <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                                          </div>
                                        </div>
                                        <div class="date"><small>5min ago</small></div>
                                      </div>
                                      <div class="message-card"> <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</small></div>
                                      <div class="CTAs pull-right"><a href="#" class="btn btn-xs btn-dark"><i class="fa fa-thumbs-up"> </i>Like</a></div>
                                    </li>
                                    <!-- List-->
                                    <li class="clearfix">
                                      <div class="feed d-flex justify-content-between">
                                        <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-6.jpg" alt="person" class="img-fluid rounded-circle"></a>
                                          <div class="content"><strong>Sam Martinez</strong><small>Posted a new blog </small>
                                            <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                                          </div>
                                        </div>
                                        <div class="date"><small>5min ago</small></div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <!-- Daily Feed Widget End-->
                          </div>
                          <div class="col-lg-4 col-md-6">
                            <!-- Recent Activities Widget      -->
                            <div id="recent-activities-wrapper" class="card updates activities">
                              <div id="activites-header" class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="h5 display"><a data-toggle="collapse" data-parent="#recent-activities-wrapper" href="#activities-box" aria-expanded="true" aria-controls="activities-box">Recent Activities</a></h2><a data-toggle="collapse" data-parent="#recent-activities-wrapper" href="#activities-box" aria-expanded="true" aria-controls="activities-box"><i class="fa fa-angle-down"></i></a>
                              </div>
                              <div id="activities-box" role="tabpanel" class="collapse show">
                                <ul class="activities list-unstyled">
                                  <!-- Item-->
                                  <li>
                                    <div class="row">
                                      <div class="col-4 date-holder text-right">
                                        <div class="icon"><i class="icon-clock"></i></div>
                                        <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                                      </div>
                                      <div class="col-8 content"><strong>Meeting</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                                      </div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li>
                                    <div class="row">
                                      <div class="col-4 date-holder text-right">
                                        <div class="icon"><i class="icon-clock"></i></div>
                                        <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                                      </div>
                                      <div class="col-8 content"><strong>Meeting</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                                      </div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li>
                                    <div class="row">
                                      <div class="col-4 date-holder text-right">
                                        <div class="icon"><i class="icon-clock"></i></div>
                                        <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                                      </div>
                                      <div class="col-8 content"><strong>Meeting</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                                      </div>
                                    </div>
                                  </li>
                                  <!-- Item-->
                                  <li>
                                    <div class="row">
                                      <div class="col-4 date-holder text-right">
                                        <div class="icon"><i class="icon-clock"></i></div>
                                        <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                                      </div>
                                      <div class="col-8 content"><strong>Meeting</strong>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                                      </div>
                                    </div>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <footer class="main-footer">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-sm-6">
                            <p>Your company &copy; 2017-2019</p>
                          </div>
                          <div class="col-sm-6 text-right">
                            <p>Design by <a href="https://bootstrapious.com/p/bootstrap-4-dashboard" class="external">Bootstrapious</a></p>
                            <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions and it helps me to run Bootstrapious. Thank you for understanding :)-->
                          </div>
                        </div>
                      </div>
                    </footer>
                  </div>
                  <!-- JavaScript files-->
                  <script src="vendor/jquery/jquery.min.js"></script>
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

                