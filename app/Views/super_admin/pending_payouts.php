
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
            <h1>Pending GGR Share: <?= PESO . ' ' . number_format($total_pending); ?></h1>
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
                    <label for="hallList">Select Hall Operator</label>
                    <select class="custom-select form-control-border" id="hallList">
                        <option value="" <?= ($operatorID)? '': 'selected'; ?> >All</option>
                        <?php foreach ($operators as $k => $v): ?>
                            <option value="<?= $v['id']; ?>" <?= ($v['id'] == $operatorID)? 'selected': ''; ?> >
                                <?= $v['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tableData" class="table table-bordered table-striped ">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Access</th>
                    <th>Name</th>
                    <th>Bank</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php foreach ($list as $k => $v): ?>
                      <tr>
                        <td> <?= $v['id']; ?> </td>
                        <td> <?= $v['created_at']; ?> </td>
                        <td> <?= $v['access']; ?> </td>
                        <td> <?= $v['name']; ?> </td>
                        <td> <?= $v['bank_name']; ?> </td>
                        <td> <?= PESO . ' ' . number_format($v['wallet']); ?> </td>
                        <td> 
                          <a href="<?= base_url('process_payout/' . $v['id']); ?>">
                            <button class="btn btn-warning btn-xs">
                              <i class="fas fa-shipping-fast"></i>
                              process
                            </button>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Access</th>
                    <th>Name</th>
                    <th>Bank</th>
                    <th>Amount</th>
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

    $('#hallList').change( (val)=>{
        window.location = "<?= base_url('payouts/pending'); ?>?operator=" + $('#hallList').val();
    } );

  $("#tableData").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tableData_wrapper .col-md-6:eq(0)');
  
</script>