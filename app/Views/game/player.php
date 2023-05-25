<div class="wrapper">

  
<?= view('navbar/' . session()->get('access') ); ?>
<?= view('sidebar/' . session()->get('access')); ?>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                Player ID: <strong><?= $player['player_id']; ?></strong>
              </h1>
            </div>
            
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              
              <?php if(session()->get('access') =='admin'): ?>
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Player Summary </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      
                    <h4>
                      Name: <strong><?= $player['name']; ?></strong>
                    </h4>
                    <h4>
                      Email: <strong><?= $player['email']; ?></strong>
                    </h4>
                    <h4>
                      Phone: <strong><?= $player['phone']; ?></strong>
                    </h4>
                    <hr>
                    <h5>
                      Operator: <strong><?= $operator['name']; ?> (<?= $operator_commission - $super_agent_commission; ?>%) , Commission: <?= PESO . $operator_wallet; ?></strong>
                    </h5>
                    <h5>
                      Area Distributor: <strong><?= $super_agent['name']; ?> (<?= $super_agent_commission - $agent_commission; ?>%) , Commission: <?= PESO . $super_agent_wallet; ?></strong>
                    </h5>
                    <h5>
                      Affiliate: <strong><?= $agent['name']; ?> (<?= $agent_commission; ?>%) , Commission: <?= PESO . $agent_wallet; ?></strong>
                    </h5>
                    <hr>
                    
                    <div class="row">

                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?= number_format($transactions); ?></h3>

                            <p>Total Transactions</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-ticket-alt"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                          <div class="inner">
                            <h3><?= number_format($total_bets,2); ?></h3>

                            <p>Total Bets</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-money-bill"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3><?= number_format($total_payout,2); ?></h3>

                            <p>Total Payout</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-money-bill-alt"></i>
                          </div>
                        </div>
                      </div>
                      
                      
                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3><?= number_format($total_ggr,2); ?></h3>

                            <p>Total GGR</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-wallet"></i>
                          </div>
                        </div>
                      </div>

                    </div>


                    <div class="row">

                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?= number_format($total_ggr * ( $ggr_share / 100 ) ,2); ?></h3>

                            <p>Admin Commission</p>
                          </div>
                          <div class="icon">
                            <i class="far fa-money-bill-alt"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                          <div class="inner">
                            <h3><?= number_format($total_ggr * ( $operator_share / 100 ),2 ); ?></h3>

                            <p>Operator Commission</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3><?= number_format($total_ggr * ($super_agent_share / 100),2 ); ?></h3>

                            <p>Area Distributor Commission</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3><?= number_format($total_ggr * ($agent_commission / 100),2 ); ?></h3>

                            <p>Affiliate Commission</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                          </div>
                        </div>
                      </div>

                    </div>


                  </div>
                </div>
              <?php endif; ?>

              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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



<?= view('scripts/js'); ?>
