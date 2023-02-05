<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>" class="brand-link">
      <img src="<?= base_url('logo.png') ?>" alt="Buenas Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SUPER ADMIN</span>
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
            <a href="<?= base_url( session()->get('access') . '/dashboard'); ?>" class="nav-link <?= ($menu == 'dashboard') ? 'active':''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url( session()->get('access') . '/operators'); ?>" class="nav-link <?= ($menu == 'operators') ? 'active':''; ?>">
              <i class="nav-icon fas fa-store-alt"></i>
              <p>
                Hall Operators
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url( session()->get('access') . '/super_agents'); ?>" class="nav-link <?= ($menu == 'super_agents') ? 'active':''; ?>">
              <i class="nav-icon fas fa-mask"></i>
              <p>
                Super Agents
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url( session()->get('access') . '/agents'); ?>" class="nav-link <?= ($menu == 'agents') ? 'active':''; ?>">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Master Agents
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('reports'); ?>" class="nav-link <?= ($menu == 'reports') ? 'active':''; ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Reports
              </p>
            </a>
          </li>



          <li class="nav-item">
            <a href="#" class="nav-link <?= ($menu == 'payouts') ? 'active':''; ?>">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                GGR Share
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('payouts/pending'); ?>" class="nav-link <?= ($action == 'pending') ? 'active':''; ?>">
                  <i class="far fa-clock nav-icon"></i>
                  <p>Pending GGR Share</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('payouts/released'); ?>" class="nav-link <?= ($action == 'released') ? 'active':''; ?>">
                  <i class="fas fa-check nav-icon"></i>
                  <p>Released GGR Share</p>
                </a>
              </li>
            </ul>
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
            <a href="<?= base_url('settings'); ?>" class="nav-link <?= ($menu == 'settings') ? 'active':''; ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
              </p>
            </a>
          </li>

          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>