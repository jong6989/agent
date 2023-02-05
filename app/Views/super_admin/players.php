
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
                <div class="form-group">
                    <label for="hallList">Manage Players</label>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tableData" class="table table-bordered table-striped ">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Player ID</th>
                    <th>Transactions</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php foreach ($list as $k => $v): ?>
                      <tr>
                        <td> <?= $v['id']; ?> </td>
                        <td> <?= $v['name']; ?> </td>
                        <td> <?= $v['email']; ?> </td>
                        <td> <?= $v['phone']; ?> </td>
                        <td> <?= $v['player_id']; ?> </td>
                        <td> <?= number_format($v['transactions']); ?> </td>
                        <td> 

                          <a href="<?= base_url('edit_player/' . $v['id']); ?>">
                            <button class="btn btn-warning btn-xs">
                              <i class="fas fa-edit"></i>
                              Edit
                            </button>
                          </a>

                          <?php if($v['player_id'] !== 'none'): ?>
                            <a href="<?= base_url('player/' . $v['id']); ?>">
                              <button class="btn btn-info btn-xs">
                                <i class="fas fa-eye"></i>
                                View
                              </button>
                            </a>
                          <?php endif; ?>
                          
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Player ID</th>
                    <th>Transactions</th>
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

<?= view('scripts/js'); ?>

<script>

  $("#tableData").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tableData_wrapper .col-md-6:eq(0)');
  
</script>