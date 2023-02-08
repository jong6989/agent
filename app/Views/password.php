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
                Password Change
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


                <?php if($updated): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Updated!</h5>
                        Password has been changed!
                    </div>
                <?php endif; ?>
            
                    

                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Account Name: <?= $currentItem['name']; ?> </h3>

                    </div>
                    <div class="card-body">
                        <?= form_open('password/' . $currentItem['id']); ?>
                        
                            <div style="color:#f00">
                                <?= ($validation != null) ? $validation->listErrors() : ''; ?>
                            </div>

                            <div class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label">New Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password2" class="col-sm-2 col-form-label">Re-New Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="re_password" id="password2" placeholder="Re-Password">
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