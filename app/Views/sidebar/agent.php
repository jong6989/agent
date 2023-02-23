<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>" class="brand-link">
      <img src="<?= base_url('logo.png') ?>" alt="Buenas Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Affiliate</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"> <?= session()->get('name') ?></a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="<?= base_url(session()->get('access') . '/dashboard'); ?>" class="nav-link <?= ($menu == 'dashboard') ? 'active':''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url( session()->get('access') . '/players'); ?>" class="nav-link <?= ($menu == 'players') ? 'active':''; ?>">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Players
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('agent_profile'); ?>" class="nav-link <?= ($menu == 'agent_profile') ? 'active':''; ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url(session()->get('access') . '/commissions'); ?>" class="nav-link <?= ($menu == 'commissions') ? 'active':''; ?>">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Commissions
              </p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="<?= base_url(session()->get('access') .  '/transactions'); ?>" class="nav-link <?= ($menu == 'transactions') ? 'active':''; ?>">
              <i class="nav-icon fas fa-exchange-alt"></i>
              <p>
                Transactions
              </p>
            </a>
          </li>
 -->

          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>