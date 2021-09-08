<?php if($admin_status == 2){?>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span>Dashboard</span>
      </h4>
    </div>
  </div>

</div>
</main>
<?php } else { ?>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <a>Home Page</a>
        <span>/</span>
        <span>Dashboard</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Students</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['total_students']; ?></h4>       
        </div>
      </div>
    </div><!--Column-->
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Current Online</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['current_online']; ?></h4>
        </div>
      </div>
    </div><!--Column-->
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Active Modules</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['total_modules']; ?></h4>
        </div>
      </div>
    </div><!--Column-->
  </div><!--Row-->
</div>
</main>
<?php } ?>
<!-- 
 <script type="text/javascript">
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart-2')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : <?php echo $year; ?>,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor    : '#007bff',
          data           : <?php echo $yearly_sales; ?>        },
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })

})

</script>

<script type="text/javascript">
  $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart-3')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : <?php echo $month; ?>,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor    : '#007bff',
          data           : <?php echo $monthly_sales; ?>        },
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })

})

</script> -->

  </body>

</html>
