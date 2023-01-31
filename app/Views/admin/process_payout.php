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
                Process Payment
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
                      <h3 class="card-title">Payout for: <strong><?= $currentItem['name']; ?></strong> </h3>
                    </div>
                    <div class="card-header">
                      <h3 class="card-title">Maximum Payout: <strong><?= PESO . ' ' . number_format($currentItem['wallet']); ?></strong> </h3>
                    </div>
                    <div class="card-header">
                      <h3 class="card-title">Minimum Payout: <strong><?= PESO . ' ' . number_format($minimum_payout); ?></strong> </h3>
                    </div>
                    <div class="card-body">

                        
                        <?= form_open('process_payout/' . $currentItem['id']); ?>

                        
                            
                        
                            <div style="color:#f00">
                                <?= ($validation != null) ? $validation->listErrors() : ''; ?>
                            </div>

                            <div class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="bank" class="col-sm-2 col-form-label">Bank Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="bank" id="bank" value="<?= set_value('bank',$currentItem['bank_name']); ?>" placeholder="bank name" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="account_number" class="col-sm-2 col-form-label">Account Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="account_number" id="account_number" value="<?= set_value('account_number',$currentItem['account_number']); ?>" placeholder="account number" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="account_name" class="col-sm-2 col-form-label">Account Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="account_name" id="account_name" value="<?= set_value('account_name',$currentItem['account_name']); ?>" placeholder="account name" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="amount" class="col-sm-2 col-form-label">Payout Amount</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" min="<?= $minimum_payout; ?>" max="<?= $currentItem['wallet']; ?>" name="amount" id="amount" value="<?= set_value('amount',0); ?>" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ref_no" class="col-sm-2 col-form-label">Reference Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="ref_no" id="ref_no" value="<?= set_value('ref_no',''); ?>" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ref_date" class="col-sm-2 col-form-label">Reference Date</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="ref_date" id="ref_date" value="<?= set_value('ref_date',''); ?>" placeholder="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">
                                    Payment has been processed
                                </button>
                            </div>
                        </div>
                    <?= form_close(); ?>

                    </div>
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



<?= view('scripts/js'); ?>