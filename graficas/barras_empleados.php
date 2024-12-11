<?php
date_default_timezone_set('America/Bogota');
$fecha_h=date('Y-m-d G:i:s');
$fecha=date('Y-m-d');

require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$sql_emp="SELECT `cod_empleado`, `cedula`, `nombre`, `contraseña`, `foto`, `direccion`, `telefono`, `color`, `fecha_registro` FROM `empleados` WHERE cod_empleado>1 AND rol != 'inactivo'";
$result_emp=mysqli_query($conexion,$sql_emp);

if (isset($_GET['fecha']))
{
  $fecha_rec = $_GET['fecha'];
  $fecha_i = $fecha_rec . ' 00:00:00';
  $fecha_f = $fecha_rec . ' 23:59:59';

  $sql_c = "SELECT SUM(`valor`) FROM `cuentas_diarias` WHERE fecha BETWEEN '$fecha_i' AND '$fecha_f'";
  $result_c=mysqli_query($conexion,$sql_c);
  $mostrar_c=mysqli_fetch_row($result_c);
  $total_dia = $mostrar_c[0];
  ?>

  <div class="card sales-report text-center">
    <br>
    <h2 class="display h4">Ventas del Dia</h2>
    <div class="bar-chart">
      <canvas id="id_grafica_ventas" width="990" height="330"></canvas>
    </div>
    <br>
    <div class="text-center text-primary">
      <h4>TOTAL VENTAS DEL DIA : $ <?php echo number_format($total_dia) ?></h4>
    </div>
  </div>

  <script type="text/javascript">

    function number_format(number, decimals, dec_point, thousands_sep)
    {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
  prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
  sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
  dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
  s = '',
  toFixedFix = function(n, prec)
  {
    var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
  };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

$(document).ready(function ()
{
    // Main Template Color
    var brandPrimary = '#33b35a';
    // ------------------------------------------------------- //
    // Line Chart
    // ------------------------------------------------------ //
    var BARCHARTEXMPLE = $('#id_grafica_ventas');
    var myLineChart = new Chart(BARCHARTEXMPLE, {
      type: 'bar',
      data: {
        labels: ['<?php echo $fecha_rec ?>'],
        datasets:
        [

        <?php 
        while ($mostrar_emp=mysqli_fetch_row($result_emp)) 
        {

          $fecha_i = $fecha_rec . ' 00:00:00';
          $fecha_f = $fecha_rec . ' 23:59:59';

          $sql_c = "SELECT `codigo`, `cod_trabajo`, `valor`, `descripcion`, `responsable`, `fecha`, SUM(`valor`) FROM `cuentas_diarias` WHERE responsable='$mostrar_emp[1]' AND fecha BETWEEN '$fecha_i' AND '$fecha_f'";
          $result_c=mysqli_query($conexion,$sql_c);
          $mostrar_c=mysqli_fetch_row($result_c);

          $foto_empleado = $mostrar_emp[4];
          $nombre_empleado = substr($mostrar_emp[2],0,11);
          $color_emp = $mostrar_emp[7];
          $color_emp = substr($color_emp,3,-1);
          $total_v = 0;
          $total_v += $mostrar_c[6];
          $total_dia
          ?>

          {
            label: '<?php echo $nombre_empleado ?>',
            backgroundColor: ['rgba<?php echo $color_emp ?>,0.3)'],
            borderColor: ['rgba<?php echo $color_emp ?>,1)'],
            borderWidth: 1,
            data: [<?php echo $total_v ?>]
          },

          <?php 
        } 
        ?>

        ]
      },
      options: {
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Empleados'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Pesos'
            },
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '$ ' + number_format(value);
          }
        }
      }]
    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});
  });
</script>

<?php 
}
if (isset($_GET['fecha_inicial']))
{
  $fecha_inicial = $_GET['fecha_inicial'];
  $fecha_final = $_GET['fecha_final'];

  $fecha_i = $fecha_inicial . ' 00:00:00';
  $fecha_f = $fecha_final . ' 23:59:59';
  $sql_c = "SELECT SUM(`valor`) FROM `cuentas_diarias` WHERE fecha BETWEEN '$fecha_i' AND '$fecha_f'";
  $result_c=mysqli_query($conexion,$sql_c);
  $mostrar_c=mysqli_fetch_row($result_c);
  $total_dia = $mostrar_c[0];

  $fecha_sql= date("Y-m-d",strtotime($fecha_inicial));
  $fecha_final= date("Y-m-d",strtotime($fecha_final));

  $dias_labels = '"';
  $num_empleado = 0;

  $cant_dias = 0;

  $data_empleado[$num_empleado] = '';

  while ($mostrar_emp=mysqli_fetch_row($result_emp))
  {
    $color_emp[$num_empleado] = substr($mostrar_emp[7], 3, -1);
    $dias_labels = '"';
    $nombre_emp[$num_empleado] = $mostrar_emp[2];
    while ($fecha_sql <= $fecha_final)
    {
      $fecha_i = $fecha_sql . ' 00:00:00';
      $fecha_f = $fecha_sql . ' 23:59:59';

      $sql_sql = "SELECT SUM(valor) FROM `cuentas_diarias` WHERE responsable='$mostrar_emp[1]' AND fecha BETWEEN '$fecha_i' AND '$fecha_f'";
      $result_sql=mysqli_query($conexion,$sql_sql);
      $mostrar_sql=mysqli_fetch_row($result_sql);

      if ($mostrar_sql[0] == '')
      {
        $suma = 0;
      }
      else
      {
        $suma = $mostrar_sql[0];
      }

      if ($cant_dias == 0)
      {
        $dias_labels .= $fecha_sql . '"';
        $data_empleado[$num_empleado] .= $suma;
      }
      else
      {
        $dias_labels .= ', "' . $fecha_sql . '"';
        $data_empleado[$num_empleado] .= ',' . $suma;
      }

      $cant_dias += 1;
      $fecha_sql = date("Y-m-d",strtotime($fecha_sql."+ 1 days"));
    }
    $num_empleado += 1;
    $cant_dias = 0;
    $fecha_sql = date("Y-m-d",strtotime($fecha_inicial));
    $data_empleado[$num_empleado] = '';
  }
  ?>

  <div class="card sales-report text-center">
    <br>
    <h2 class="display h4">Ventas x Dias</h2>
    <div class="bar-chart">
      <canvas id="id_grafica_ventas_2" width="990" height="330"></canvas>
    </div>
    <br>
    <div class="text-center text-primary">
      <h4>TOTAL VENTAS: $ <?php echo number_format($total_dia) ?></h4>
    </div>
  </div>

  <script type="text/javascript">

    function number_format(number, decimals, dec_point, thousands_sep)
    {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
  prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
  sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
  dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
  s = '',
  toFixedFix = function(n, prec)
  {
    var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
  };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

$(document).ready(function ()
{
  var LINECHARTEXMPLE = $('#id_grafica_ventas_2');
  var lineChartExample = new Chart(LINECHARTEXMPLE, {
    type: 'line',
    data: {
      labels: [<?php echo $dias_labels ?>],
      datasets: [
      <?php 
      $for_1 = 0;
      while ($for_1 < 6)
      {
        $color = '"rgba' . $color_emp[$for_1] . ',0)"';
        $color_1 = '"rgba' . $color_emp[$for_1] . ',1)"'; 
        $nombre_e = '"' . $nombre_emp[$for_1] . '"';
        $data_e = $data_empleado[$for_1];
        ?>
        {
          label: <?php echo $nombre_e; ?>,
          fill: true,
          lineTension: 0.3,
          backgroundColor: [<?php echo $color; ?>],
          borderColor: [<?php echo $color_1; ?>],
          borderCapStyle: 'butt',
          borderDash: [],
          borderDashOffset: 0.0,
          borderJoinStyle: 'miter',
          borderWidth: 1,
          pointBorderColor: <?php echo $color_1; ?>,
          pointBackgroundColor: "#fff",
          pointBorderWidth: 1,
          pointHoverRadius: 3,
          pointHoverBackgroundColor: <?php echo $color_1; ?>,
          pointHoverBorderColor: <?php echo $color_1; ?>,
          pointHoverBorderWidth: 2,
          pointRadius: 2,
          pointHitRadius: 10,
          data: [<?php echo $data_e ?>],
          spanGaps: false
        },
        <?php
        $for_1 += 1;
      }
      ?>
      ]
    },
    options: {
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Dias'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Pesos'
          },
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '$ ' + number_format(value);
          }
        }
      }]
    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }

});
});
</script>

<?php 
}
?>

