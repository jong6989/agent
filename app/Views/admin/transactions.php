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
                  <h3 class="card-title">Registered Agents using your referal link</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>NAME</th>
                      <th>Players</th>
                      <th>Wallet</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                      <td>1</td>
                      <td>Anna Fe
                      </td>
                      <td> 12</td>
                      <td> <?= PESO; ?> 200,000</td>
                      <td> <span class="badge bg-success">Online</span> </td>
                    </tr>

                    <tr>
                      <td>2</td>
                      <td>Marvin Sultan
                      </td>
                      <td> 15</td>
                      <td> <?= PESO; ?> 340,500</td>
                      <td> <span class="badge bg-secondary">Offline</span> </td>
                    </tr>

                    <tr>
                      <td>3</td>
                      <td>Kevin Chan
                      </td>
                      <td> 35</td>
                      <td> <?= PESO; ?> 412,450</td>
                      <td> <span class="badge bg-secondary">Offline</span> </td>
                    </tr>

                    <tr>
                      <td>4</td>
                      <td>Girlie Ocampo
                      </td>
                      <td> 6</td>
                      <td> <?= PESO; ?> 65,300</td>
                      <td> <span class="badge bg-success">Online</span> </td>
                    </tr>
                    
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>NAME</th>
                      <th>Players</th>
                      <th>Wallet</th>
                      <th>Status</th>
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