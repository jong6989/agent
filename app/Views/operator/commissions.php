
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
            <h4>Account Name : <strong><?= $selected_account['name']; ?></strong> </h4>
            <h6>Email : <strong><?= $selected_account['email']; ?></strong> </h6>
            <h6>Contact : <strong><?= $selected_account['phone']; ?></strong> </h6>
            <h6>Address : <strong><?= $selected_account['address']; ?></strong> </h6>
            <h6>Commission Rate : <strong><?= $selected_account['commission']; ?>%</strong> </h6>
            <h6>Rank : <strong>
              <?= ($selected_account['access'] == 'agent')? 'Affiliate' : '' ; ?>
              <?= ($selected_account['access'] == 'super_agent')? 'Area Distributor' : '' ; ?>
              <?= ($selected_account['access'] == 'operator')? 'Hall Operator' : '' ; ?>
              <?= ($selected_account['access'] == 'agency')? 'Agency Distributor' : '' ; ?>
            </strong> </h6>

            
              
            <hr>
            <h4>Commissions : <strong><?= PESO . ' ' . number_format($commissions,2); ?></strong> </h4>
            <h4>PAID : <strong><?= PESO . ' ' . number_format( -$payouts,2); ?></strong> </h4>
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
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tableData" class="table table-bordered table-striped ">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Transaction ID</th>
                    <th>Network</th>
                    <th>Bank</th>
                    <th>Account No.</th>
                    <th>Ref. No.</th>
                    <th>Ref. Date</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php foreach ($list as $k => $v): ?>
                      <tr>
                        <td> <?= $v['id']; ?> </td>
                        <td> <?= $v['created_at']; ?> </td>
                        <td> <?= PESO . ' ' . $v['amount']; ?> </td>
                        <td> <?= $v['type']; ?> </td>
                        <td> <?= $v['transaction']; ?>-<?= $v['player_id']; ?></td>
                        <td>
                          
                          <?php  if($selected_account['id'] != $v['player']['agent']): ?>
                            <a href="<?= base_url('operator/commissions') . '?id=' . $v['player']['agent']; ?>">
                              <button class="btn btn-primary btn-xs">
                                <i class="fas fa-eye"></i>
                                View Affiliate
                              </button>
                            </a>
                          <?php endif; ?>

                          <?php if($selected_account['id'] != $v['player']['super_agent']): ?>
                            <a href="<?= base_url('operator/commissions') . '?id=' . $v['player']['super_agent']; ?>">
                              <button class="btn btn-warning btn-xs">
                                <i class="fas fa-eye"></i>
                                View Area Distributor
                              </button>
                            </a>
                          <?php endif; ?>

                          
                          
                        </td>
                        <td> <?= $v['bank']; ?></td>
                        <td> <?= $v['account_number']; ?></td>
                        <td> <?= $v['ref_no']; ?></td>
                        <td> <?= $v['ref_date']; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Transaction ID</th>
                    <th>Network</th>
                    <th>Bank</th>
                    <th>Account No.</th>
                    <th>Ref. No.</th>
                    <th>Ref. Date</th>
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