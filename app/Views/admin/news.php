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
                        <h1>News</h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="row">


                            <div class="col-lg-12">



                                <div class="card">
                                    <div class="card-header">
                                        <a href="<?= base_url('news') ?>" class="my-2 btn btn-primary">Add news</a>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <table id="tableData" class="table table-bordered table-striped ">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Content</th>
                                                    <th>Name</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($allNews)) : ?>

                                                    <!-- DISPLAY NEWS -->
                                                    <?php foreach ($allNews as $news) : ?>
                                                        <tr>
                                                            <td><?= $news['id'] ?></td>
                                                            <td>
                                                                <img class="img-fluid" src="<?= base_url('images/' . $news['img_path']) ?>" alt="" width="100px" height="50px">
                                                            </td>
                                                            <td><?= $news['title'] ?></td>
                                                            <td><?= $news['content'] ?></td>
                                                            <td><?= $news['name'] ?></td>
                                                            <td><?= $news['created_at'] ?></td>
                                                            <td>
                                                                <a href="<?= base_url('news?edit=' . $news['id']) ?>" class="btn btn-warning btn-xs">
                                                                    <i class="fas fa-edit"></i>
                                                                    Edit
                                                                </a>

                                                                <form action="<?= base_url('news'); ?>" method="post">
                                                                    <input type="text" name="d-id" value="<?= $news['id'] ?>" hidden>
                                                                    <input type="text" hidden readonly value="Delete" class="btn btn-danger" name="d-news">
                                                                    <button type="submit" class="btn btn-danger btn-xs">
                                                                        <i class="fas fa-trash"></i>
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </td>

                                                        </tr>

                                                    <?php endforeach; ?>


                                                <?php else : ?>
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
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Content</th>
                                                    <th>Name</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>


                                    </div>

                                </div>
                            </div>

                        </div>
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

    $('#clear-search').click(function(e) {
        $('#search-form').submit();


    });
</script>