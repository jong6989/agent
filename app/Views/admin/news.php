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

                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="<?= base_url('news') ?>" class="my-2 btn btn-primary">Add news</a>
                                    </div>

                                    <div class="col-lg-6">

                                        <!-- SEARCH TAG -->
                                        <form class="d-flex my-2 lg-float-right" method="get" id="search-form">
                                            <input class="form-control me-sm-2" type="text" name="q" placeholder="Search">
                                            <button class="btn btn-outline-success lg-my-2 my-sm-0 ml-2" type="submit">Search</button>
                                        </form>

                                        <!-- PER-PAGE FORM -->
                                        <form class="d-flex my-2 lg-float-right">
                                            <?php if (isset($searchNews)) : ?>
                                                <input type="text" hidden readonly value="<?= $searchNews ?>" class="hidden" name="q" id="" aria-describedby="helpId" placeholder="">
                                            <?php endif; ?>
                                            <input class="form-control me-sm-2" type="number" id="per-page" name="per-page" placeholder="Number per page">
                                            <button class="btn btn-outline-success lg-my-2 my-sm-0 ml-2" type="submit">Set</button>
                                        </form>
                                    </div>

                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <!-- <h3 class="card-title">News list</h3> -->
                                        <?php if (isset($searchNews)) : ?>

                                            Search tag:<h3 class="d-inline"> <i> <?= $searchNews ?></i> </h3>
                                            <button class="d-inline btn btn-danger btn-sm" id="clear-search">
                                                <i class="fas fa-times"></i>
                                            </button>



                                        <?php endif; ?>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <?php if (!empty($allNews)) : ?>

                                            <!-- DISPLAY NEWS -->
                                            <?php foreach ($allNews as $news) : ?>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h3>#<?= $news['id'] ?></h3>
                                                            </div>
                                                            <div class="card-body">

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <img class="img-fluid" src="<?= base_url('images/' . $news['img_path']) ?>" alt="" width="" height="">
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <h1><?= $news['title'] ?></h1>
                                                                        <p><?= $news['content'] ?> </p>
                                                                        <hr>
                                                                        <div class="additional-info">
                                                                            <h6 class="fs-5">
                                                                                <h4>Created By: <?= $news['name'] ?></h4>
                                                                            </h6>
                                                                            <p>Date created: <?= $news['created_at'] ?></p>
                                                                        </div>
                                                                        <div class="action-btn d-flex">
                                                                            <a href="<?= base_url('news?edit=' . $news['id']) ?>" class="btn btn-warning mr-2">Edit News</a>

                                                                            <form action="<?= base_url('news'); ?>" method="post">
                                                                                <input type="text" name="d-id" value="<?= $news['id'] ?>" hidden>
                                                                                <input type="submit" value="Delete" class="btn btn-danger" name="d-news">
                                                                            </form>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                        <?php else : ?>
                                            <h1>No news</h1>
                                        <?php endif; ?>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <div class="float-right">
                                            <?= $pager->links('allNews', 'default_full') ?>
                                        </div>
                                    </div>
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