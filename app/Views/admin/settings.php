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
                Settings
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
              

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">System variables </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?= form_open('settings'); ?>
                    
                        <div class="form-horizontal">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="ggr_share" class="col-sm-2 col-form-label">GGR Commission Share % </label>
                                    <div class="col-sm-10">
                                        <input type="number" min="0" max="52" class="form-control" name="ggr_share" id="ggr_share" value="<?= $ggr_share; ?>" placeholder="Share">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="minimum_payout" class="col-sm-2 col-form-label">Minimum Payout </label>
                                    <div class="col-sm-10">
                                        <input type="number" min="0" class="form-control" name="minimum_payout" id="minimum_payout" value="<?= $minimum_payout; ?>" placeholder="Payout">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">
                              Save
                            </button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                <?= form_close(); ?>




                </div>
                <!-- /.card-body -->
              </div>
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



<?= view('scripts/dashboard'); ?>