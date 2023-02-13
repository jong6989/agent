
<div class="wrapper">

  
<?= view('navbar/' . session()->get('access') ); ?>
<?= view('sidebar/' . session()->get('access')); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3> <?= $operators; ?> </h3>

              <p>Hall Operators</p>
            </div>
            <div class="icon">
              <i class="ion ion-merge"></i>
            </div>
            <a href="<?= base_url('admin/operators'); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $super_agents; ?></h3>

              <p>Super Agents</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
            <a href="<?= base_url('admin/super_agents'); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $paired_players . '/' . $all_players; ?></h3>

              <p>Players (<?= $all_players - $paired_players; ?>pending)</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
            <a href="<?= base_url( session()->get('access') .'/players'); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $agents; ?></h3>

              <p>Agents</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
            <a href="<?= base_url('admin/agents'); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Accounting Info</h3>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th></th>
                    <th>Today</th>
                    <th>This Month</th>
                    <th>This Year</th>
                    <th>Last Year</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Transactions</td>
                    <td><?= number_format($trans_day); ?></td>
                    <td><?= number_format($trans_month); ?></td>
                    <td><?= number_format($trans_year); ?></td>
                    <td><?= number_format($trans_last_year); ?></td>
                  </tr>
                  <tr>
                    <td>Total BET</td>
                    <td><?= PESO; ?> <?= number_format($bets_day); ?></td>
                    <td><?= PESO; ?> <?= number_format($bets_month); ?></td>
                    <td><?= PESO; ?> <?= number_format($bets_year); ?></td>
                    <td><?= PESO; ?> <?= number_format($bets_last_year); ?></td>
                  </tr>
                  <tr>
                    <td>GGR Share</td>
                    <td><?= PESO; ?> <?= number_format($commission_day); ?></td>
                    <td><?= PESO; ?> <?= number_format($commission_month); ?></td>
                    <td><?= PESO; ?> <?= number_format($commission_year); ?></td>
                    <td><?= PESO; ?> <?= number_format($commission_last_year); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>

          
          
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          

          <!-- <div class="card bg-gradient-info">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Income Graph
              </h3>

              <div class="card-tools">
                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="text-white">WIN/LOSS</div>
                </div>
                
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="text-white">Online Players</div>
                </div>
                
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="text-white">Active admins</div>
                </div>
                
              </div>
              
            </div>
            
          </div>
           -->



          
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= view('footer/copyright'); ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?= view('scripts/dashboard'); ?>
<script type="text/javascript">

  
$(function () {
'use strict'


$('.connectedSortable').sortable({
  placeholder: 'sort-highlight',
  connectWith: '.connectedSortable',
  handle: '.card-header, .nav-tabs',
  forcePlaceholderSize: true,
  zIndex: 999999
})
$('.connectedSortable .card-header').css('cursor', 'move')



// $('.knob').knob()


// // Donut Chart
// var pieData = {
//   labels: [
//     'Instore Sales',
//     'Download Sales',
//     'Mail-Order Sales'
//   ],
//   datasets: [
//     {
//       data: [30, 12, 20],
//       backgroundColor: ['#f56954', '#00a65a', '#f39c12']
//     }
//   ]
// }
// var pieOptions = {
//   legend: {
//     display: false
//   },
//   maintainAspectRatio: false,
//   responsive: true
// }


// // Sales graph chart
// var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');

// var salesGraphChartData = {
//   labels: ['Nov 14', 'Nov 21', 'Nov. 28', 'Dec 5', 'Dec 12', 'Dec 19', 'Dec 26', 'Jan 2', 'Jan 9', 'Jan 16'],
//   datasets: [
//     {
//       label: 'Income',
//       fill: false,
//       borderWidth: 2,
//       lineTension: 0,
//       spanGaps: true,
//       borderColor: '#efefef',
//       pointRadius: 3,
//       pointHoverRadius: 7,
//       pointColor: '#efefef',
//       pointBackgroundColor: '#efefef',
//       data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
//     }
//   ]
// }

// var salesGraphChartOptions = {
//   maintainAspectRatio: false,
//   responsive: true,
//   legend: {
//     display: false
//   },
//   scales: {
//     xAxes: [{
//       ticks: {
//         fontColor: '#efefef'
//       },
//       gridLines: {
//         display: false,
//         color: '#efefef',
//         drawBorder: false
//       }
//     }],
//     yAxes: [{
//       ticks: {
//         stepSize: 5000,
//         fontColor: '#efefef'
//       },
//       gridLines: {
//         display: true,
//         color: '#efefef',
//         drawBorder: false
//       }
//     }]
//   }
// }

// // This will get the first returned node in the jQuery collection.
// // eslint-disable-next-line no-unused-vars
// var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
//   type: 'line',
//   data: salesGraphChartData,
//   options: salesGraphChartOptions
// })


})
</script>

