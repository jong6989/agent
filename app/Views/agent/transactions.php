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
              <h1>Transactions</h1>
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
                  <h3 class="card-title">Processed transactions</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>DATE</th>
                      <th>TRANSACTION ID</th>
                      <th>CHANNEL</th>
                      <th>PLAYER ID</th>
                      <th>GGR</th>
                      <th>Commission</th>
                    </tr>
                    </thead>
                    <tbody>

                    <!-- <tr>
                      <td>1</td>
                      <td>Anna Fe
                      </td>
                      <td> 12</td>
                      <td> <?= PESO; ?> 200,000</td>
                      <td> <span class="badge bg-success">Online</span> </td>
                    </tr> -->

                    
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>DATE</th>
                      <th>TRANSACTION ID</th>
                      <th>CHANNEL</th>
                      <th>PLAYER ID</th>
                      <th>GGR</th>
                      <th>Commission</th>
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