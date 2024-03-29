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
                                <div class="card ">
                                    <div class="card-header mb-2">
                                        <h3 class="card-title">Edit News form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form class="form" method="post" action="" enctype="multipart/form-data">

                                        <!-- VALIDATION -->
                                        <div style="color:#f00">
                                            <?= (isset($validation)) ? $validation->listErrors() : ''; ?>
                                        </div>



                                        <div class="card-body px-5">
                                            <img class="img-responsive" src="<?= base_url('images/' . $newsToEdit['img_path']) ?>" alt="" width="250px" height="250px">

                                            <div class="form-group mt-2">
                                                <label for="exampleInputFile">Feature image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input name="image" type="file" class="custom-file-input" id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Title</label>
                                                <input type="text" class="form-control" value="<?= set_value('title', $newsToEdit['title']) ?>" name="title" placeholder="Enter title">
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="form-label">Content</label>
                                                <textarea class="form-control" name="content" id="" rows="3"><?= set_value('content', $newsToEdit['content']) ?></textarea>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                            <input type="submit" value="Submit" name="editNews" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
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