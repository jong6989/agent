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
              <h1>Players</h1>
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
                  <h3 class="card-title">Registered Players using your referral link or by agents.</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body  table-responsive">
                  <p>Use the link below as your referral link.</p>
                  <div onclick="copyLink()" >
                    <input type="text" class="form-control" style="padding:10px; background-color: #ddd; cursor:pointer; color: #f00; display:block; " disabled value="<?= base_url('register/' . $id); ?>"  id="inviteLink">
                  </div>
                  <hr>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Player ID</th>
                      <th>Player Name</th>
                      <th>Player Email</th>
                      <th>Player Contact</th>
                      <th>Transactions</th>
                      <th>Commissions</th>
                      <th>Source</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($list as $k => $v): ?>
                        <tr>
                          <td> <?= $v['id']; ?> </td>
                          <td> <?= $v['player_id']; ?> </td>
                          <td> <?= $v['name']; ?> </td>
                          <td> <?= $v['email']; ?> </td>
                          <td> <?= $v['phone']; ?> </td>
                          <td> <?= $v['transactions']; ?> </td>
                          <td> 
                            <?= PESO; ?><?= number_format($v['commission'],2); ?>
                          </td>
                          <td> 
                            <?=  ($v['agent'] == $id) ? 'link':'agent' ; ?>
                          </td>
                          <td> 
                            <span class="badge <?= ($v['player_id'] == 'none') ? 'bg-secondary' : 'bg-success'; ?>">
                              <?= ($v['player_id'] == 'none') ? 'Pending':'Paired'; ?>
                            </span> 
                          </td>
                          <td>
                            <a href="<?= base_url('edit_player/' . $v['id']); ?>">
                              <button class="btn btn-warning btn-xs">
                                <i class="fas fa-edit"></i>
                                Edit
                              </button>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>

                    
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Player ID</th>
                      <th>Player Name</th>
                      <th>Player Email</th>
                      <th>Player Contact</th>
                      <th>Transactions</th>
                      <th>Commissions</th>
                      <th>Source</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>
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

<?= view('scripts/data_table'); ?>
<script>
  function copyLink() {
    var copyText = document.getElementById("inviteLink");

    copyText.select();
    copyText.setSelectionRange(0, 99999);

    navigator.clipboard.writeText(copyText.value);

    alert("Link Copied! ");
  }
</script>