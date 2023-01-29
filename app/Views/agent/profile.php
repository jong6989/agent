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
                Master Agent Profile and Settings
              </h1>

              <?php if($default['phone'] ==''): ?>
                <hr>
                <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Profile Details!</h5>
                  Please Complete your Profile to continue...
                </div>
              <?php endif; ?>
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
                      <h3 class="card-title">Profile Info</h3>

                    </div>
                    <div class="card-body">
                        <?= form_open('agent_profile'); ?>
                        
                            <div style="color:#f00">
                                <?= ($validation != null) ? $validation->listErrors() : ''; ?>
                            </div>

                            <div class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name" value="<?= set_value('name',$default['name']); ?>" placeholder="Full name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="address" id="address" value="<?= set_value('address',$default['address']); ?>" placeholder="address">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email',$default['email']); ?>" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Phone Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="phone" id="phone" value="<?= set_value('phone',$default['phone']); ?>" placeholder="09-- --- ----">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fb" class="col-sm-2 col-form-label">Facebook Link</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="fb" id="fb" value="<?= set_value('fb',$default['fb']); ?>" placeholder="fb.com/">
                                        </div>
                                    </div>

                                    <hr>

                                    <h5>Payout Details</h5>
                                    <div class="form-group row">
                                        <label for="bank_name" class="col-sm-2 col-form-label">Bank Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?= set_value('bank_name',$default['bank_name']); ?>" placeholder="Gcash">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="account_number" class="col-sm-2 col-form-label">Account Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="account_number" id="account_number" value="<?= set_value('account_number',$default['account_number']); ?>" placeholder="09-- --- ----">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="account_name" class="col-sm-2 col-form-label">Account Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="account_name" id="account_name" value="<?= set_value('account_name',$default['account_name']); ?>" placeholder="---">
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">
                                Save
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



<?= view('scripts/dashboard'); ?>