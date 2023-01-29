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
                Reports
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
                  <h3 class="card-title">Upload Buenas report via spreedsheet with the following KEYS: ( 'TRANSACTION ID','PLAYER ID','BET TIME','CHANNEL TYPE','BET AMOUNT','PAYOUT','REFUND','GROSS GAMING REVENUE' ) </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    

                    <div id="import_success" class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h5><i class="icon fas fa-check"></i> Data Imported!</h5>
                      Saved: <span id="imported_numbers"></span>
                    </div>

                    <div class="outer-container">

                        <?= form_open_multipart( 'reports' )  ?>
                            <div>
                                <label>Choose Excel
                                    File</label> <input type="file" name="file"
                                    id="file" accept=".xls,.xlsx">
                                <button type="submit" id="submit" name="import" class="btn btn-info"
                                    class="btn-submit">Import</button>
                        
                            </div>
                        <?= form_close(); ?>
                        <div id="spinner" class="row">
                          <div  class="spinner-border text-primary" role="status"></div>
                          <h5> ------- Importing...</h5>
                        </div>
                        
                    </div>


                </div>
                <!-- /.card-body -->
              </div>


              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Current Imported Transactions </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                      <h4>
                        Pending Transactions: <strong><?= number_format($current_trans_pending); ?></strong>
                      </h4>

                      <h4>
                        Processed Transactions: <strong><?= number_format($current_trans_processed); ?></strong>
                      </h4>

                      <button id="process_available" class="btn btn-warning">
                        <i class="fas fa-share"></i>
                        Process Available Transactions ( <strong><?= number_format($available_for_processing); ?></strong> )
                      </button>

                      <div id="process_spinner" class="row">
                        <div  class="spinner-border text-primary" role="status"></div>
                        <h5> ------- Processing...</h5>
                      </div>

                      <hr>
                      <h4>
                        Pending Players: <strong><?= number_format($game_players_pending); ?></strong>
                      </h4>

                      <h4>
                        Processed Players: <strong><?= number_format($game_players_linked); ?></strong>
                      </h4>
                      
                </div>
                <!-- /.card-body -->
              </div>




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
<script>
  $('#import_success').hide();
  $('#spinner').hide();
  $('#process_spinner').hide();
  var targetPath = '<?= $targetPath ?? ""; ?>';
  if(targetPath !== ""){
    $('#spinner').show();
    $.post( "<?= base_url('api/import_report'); ?>",{targetPath}, function( data ) {
      console.log('targetPath post',data);
      $('#spinner').hide();
      $("#imported_numbers").text(data.imported + ' / ' + data.items);
      $('#import_success').show();
      setTimeout(() => {
        location.href = '<?= base_url('reports'); ?>';
      }, 5000);
    }); 
  }

  $('#process_available').click( ()=>{
    $('#process_spinner').show();
    $('#process_available').hide();
    $.post( "<?= base_url('api/process_commission'); ?>", function( data ) {
      location.reload();
    });
  } );

</script>