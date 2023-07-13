
<div class="login-box">
  <div class="login-logo">
    <a href="<?= base_url(''); ?>"><b>Buenas PH</b></a>
    <div>
      <?= $operator['name']; ?>
    </div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Welcome Player! Please fill up the form to proceed with registration.</p>

      <?= form_open('register/' . $agent['id']); ?>
                    
        <div style="color:#f00">
            <?= ($validation != null) ? $validation->listErrors() : ''; ?>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" value="<?= set_value('name'); ?>" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" value="<?= set_value('email'); ?>" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="phone" value="<?= set_value('phone'); ?>" placeholder="Phone Number">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Proceed</button>
          </div>
          <!-- /.col -->
        </div>
      <?= form_close(); ?>

    </div>
  </div>
</div>
