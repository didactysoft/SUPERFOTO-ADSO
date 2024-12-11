<?php 
session_start();
if (isset($_SESSION['usuario']))
{
  header("Location:trabajos_pendientes.php");
}
else
{
 ?>

 <!DOCTYPE html>
 <html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inicia Sesión</title>
  <?php require_once "scripts.php"; ?>
</head>
<body>
  <div class="page login-page">
    <div class="container">
      <div class="form-outer text-center d-flex align-items-center">
        <div class="col"></div>
        <div class="form-inner col-md-10">
          <div class="sidenav-header-inner text-center"><img src="img/logo.svg" class="img-fluid"></div>
          <form id="form_login" class="text-left form-validate">
            <div class="form-group-material">
              <input id="input_cedula" type="number" name="input_cedula" required data-msg="Por favor ingrese su usuario" class="input-material">
              <label class="label-material">Cédula</label>
            </div>
            <div class="form-group-material">
              <input id="input_contraseña" type="password" name="input_contraseña" required data-msg="Por favor ingrese su contraseña" class="input-material">
              <label class="label-material">Contraseña</label>
            </div>
            <div class="form-group text-center">
              <button type="button" class="btn btn-sm btn-primary" onclick="f_iniciar_sesion()">Inicia sesión</button>
            </div>
          </form>
              </div>
        <div class="col"></div>
      </div>
    </div>
    <div class="copyrights text-center">
      <h5 class="text-dark"><img src="img/cavpsoft.svg" height="30" class="ml-3"></h5>
    </div>
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
  <!-- Main File-->
  <script src="js/front.js"></script>
</body>
</html>

<script type="text/javascript">

  function f_iniciar_sesion()
  {
    datos=$('#form_login').serialize();
    $.ajax({
      type:"POST",
      data:datos,
      url:"procesos/verificacion_login.php",
      success:function(r)
      {
        if (r == 0)
        {
          alertify.error("LA CÉDULA INGRESADA NO EXISTE");
        }
        else
        {
          if (r == 1)
          {
            alertify.error("LA CONTRASEÑA ES INCORRECTA");
          }
          else
          {
            alertify.success("SESION INICIADA");
            alertify.success("BIENVENIDO "+r);
            location.href="trabajos_pendientes.php";
          }
        }
      }
    });
  }

</script>

<?php 
}
?>