<div class="wrapper">

  <?= view('navbar/' . session()->get('access')); ?>
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

                <form action="" method="get" class="mb-2 form-row">
                    <div class="col-3">
                    <label for="">Search by name:</label>
                   <input type="text" class="form-control" name="name" id="" value="<?= (isset($nameSearch)) ? $nameSearch : '' ?>">
                    </div>  

                    <div class="col-3">
                      <div class="mb-3">
                        <label for="" class="form-label">Number per page</label>
                        <select class="form-select form-control" name="per-page" id="">
                          <option value="10" <?php echo ($perPage == '10') ? 'selected'  : '' ?> >10</option>
                          <option value="50" <?php echo ($perPage == '50') ? 'selected'  : '' ?>>50</option>
                          <option value="100" <?php echo ($perPage == '100') ? 'selected'  : '' ?>>100</option>
                          <option value="200" <?php echo ($perPage == '200') ? 'selected'  : '' ?>>200</option>
                        </select>
                      </div>
                    </div>

                   <div class="col-3">
                    <label for="" class="form-label invisible">submit</label>
                   <input type="submit" value="set" class="btn btn btn-success form-control">
                   </div>

                </form>



                <table id="tableData" class="table table-bordered table-striped ">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Operator</th>
                      <th>Area Distributor</th>
                      <th>Affiliate</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Player ID</th>
                      <!-- <th>Transactions</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php if(!empty($list)) : ?>
                      <?php foreach ($list as $k => $v) : ?>
                      <tr>
                        <td> <?= $v['id']; ?> </td>
                        <td> <?= $v['operator']['name']; ?> </td>
                        <td> <?= $v['super_agent']['name']; ?> </td>
                        <td> <?= $v['agent']['name']; ?> </td>
                        <td> <?= $v['name']; ?> </td>
                        <td> <?= $v['email']; ?> </td>
                        <td> <?= $v['phone']; ?> </td>
                        <td> <?= $v['player_id']; ?> </td>
                        <!-- <td> <?//= number_format($v['transactions']); ?> </td> -->
                        <td>

                          <a href="<?= base_url('edit_player/' . $v['id']); ?>">
                            <button class="btn btn-warning btn-xs">
                              <i class="fas fa-edit"></i>
                              Edit
                            </button>
                          </a>

                          <?php if ($v['player_id'] !== 'none') : ?>
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
                    <?php else: ?>
                      <tr>
                        <td colspan="10">
                          NO DATA 
                        </td>
                      </tr>
                    <?php endif; ?>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Operator</th>
                      <th>Area Distributor</th>
                      <th>Affiliate</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Player ID</th>
                      <!-- <th>Transactions</th> -->
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer ">
                <div class="float-right">
                  <?= $playersPager->links('allPlayers', 'default_full') ?>
                </div>
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

<script>
  // $("#tableData").DataTable({
  //   "responsive": true,
  //   "lengthChange": false,
  //   "autoWidth": false,
  //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  // }).buttons().container().appendTo('#tableData_wrapper .col-md-6:eq(0)');
</script>