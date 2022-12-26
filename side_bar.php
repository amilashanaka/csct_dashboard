<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?=APP_NAME?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
  
          </li>
          <li class="nav-item">
            <a href="row_data.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Data Set
               
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-brain"></i>
              <p>
                LSTM Model
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="run.php" class="nav-link">
                  <i class="fa fa-play nav-icon"></i>
                  <p>Run Model</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="settings.php" class="nav-link">
                  <i class="fa fa-cog nav-icon"></i>
                  <p>Model Settings</p>
                </a>
              </li>
          </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon 	fas fa-chart-line"></i>
              <p>
              Forecasting 
             
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="forecast.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Given Value</p>
                </a>
              </li>
  
            </ul>
          </li>

          <li class="nav-header">Data Analytics</li>
          <li class="nav-item">
            <a href="products.php" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Products
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Warehouse
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="category.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
               Category
              </p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
