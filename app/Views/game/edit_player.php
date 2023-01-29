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
                Edit Player Details
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
              
                <?php if($valid_access): ?>

                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Edit Player</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">



                            <?php if($saved): ?> 
                                <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Saved!</h5>
                                Player details successfully updated.
                                </div>
                            <?php endif; ?> 



                            <?= form_open('edit_player/' . $player_id); ?>
                            
                                <div style="color:#f00">
                                    <?= ($validation != null) ? $validation->listErrors() : ''; ?>
                                </div>

                                <div class="form-horizontal">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" id="name" value="<?= set_value('name',$default['name']); ?>" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="<?= set_value('phone',$default['phone']); ?>" name="phone" id="phone" placeholder="phone number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email',$default['email']); ?>" placeholder="Email">
                                            </div>
                                        </div>

                                        
                                        <div class="form-group row">
                                            <label for="player_id" class="col-sm-2 col-form-label">Player ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="player_id" id="player_id" value="<?= set_value('player_id',$default['player_id']); ?>" placeholder="player id" <?= ($default['player_id'] == '')? '':'readonly'; ?> >
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
                            
                            <?= form_close(); ?>
                        </div>


                        

                    </div>
                <?php endif; ?>

                <?php if(!$valid_access): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Invalid Access!</h5>
                        Sorry, you dont have the access to edit this player.
                    </div>
                <?php endif; ?>

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



<?= view('scripts/js'); ?>

<script>

  var return_url = '<?= base_url( session()->get('access') . "/players"); ?>';
  function returnPage(){
    location.href = return_url;
  }
  
  <?= ($saved) ? 'setTimeout(() => {returnPage()}, 1500);' : ""; ?>
  
</script>