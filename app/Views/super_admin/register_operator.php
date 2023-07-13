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
                <?= ($item_id == '') ? 'Register New Hall Operator': 'Edit Hall Operator' ; ?>
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
                  <h3 class="card-title"><?= ($item_id == '') ? 'Please fill-up the form.': 'Edit Form' ; ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?= form_open($formUrl); ?>
                    
                        <div style="color:#f00">
                            <?= ($validation != null) ? $validation->listErrors() : ''; ?>
                        </div>

                        <div class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Hall Operator Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" value="<?= set_value('name',$default['name']); ?>" placeholder="name of Operator">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="commission" class="col-sm-2 col-form-label">Commission (%)</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" value="10" minimum="0" maximum="100" value="<?= set_value('commission',$default['commission']); ?>" name="commission" id="commission" placeholder="%">
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
                                <?php if($item_id == ''): ?>
                                  <div class="form-group row">
                                      <label for="password" class="col-sm-2 col-form-label">Password</label>
                                      <div class="col-sm-10">
                                          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <label for="password2" class="col-sm-2 col-form-label">Re-Password</label>
                                      <div class="col-sm-10">
                                      <input type="password" class="form-control" name="re_password" id="password2" placeholder="Re-Password">
                                      </div>
                                  </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">
                              <?= ($item_id == '') ? 'Register': 'Save' ; ?>
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