<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.html" class="logo">

          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a
              data-bs-toggle="collapse"

              class="collapsed"
              aria-expanded="false"
              >
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="dashboard">
              <ul class="nav nav-collapse">
                <li>
                  <a href="http://localhost:8080/home/dashboard">
                    <span class="sub-item">Dashboard</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Components</h4>
          </li>


          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts">
              <i class="fas fa-th-list"></i>
              <p>Activity & User</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts">
              <ul class="nav nav-collapse">
                <?php
                if(session()->get('level')=='1' || session()->get('level')=='3'){
                  ?>
                  <li>
                    <a href="http://localhost:8080/home/activity_log">
                      <span class="sub-item">Activity Log</span>
                    </a>
                  </li>
                  <li>
                    <a href="http://localhost:8080/home/user">
                      <span class="sub-item">User</span>
                    </a>
                  </li>
                <?php } ?>
                <li>
                  <a href="http://localhost:8080/home/logout">
                    <span class="sub-item">Logout</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <?php
          if(session()->get('level')=='1' || session()->get('level')=='4' || session()->get('level')=='3'){
            ?>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#forms">
                <i class="fas fa-pen-square"></i>
                <p>Print</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="forms">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="http://localhost:8080/home/laporan">
                      <span class="sub-item">Print</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          <?php } ?>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables">
              <i class="fas fa-table"></i>
              <p>Surat</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav nav-collapse">
                <li>
                  <a href="http://localhost:8080/home/surat_masuk">
                    <span class="sub-item">Surat Masuk</span>
                  </a>
                </li>
                <li>
                  <a href="http://localhost:8080/home/surat_keluar">
                    <span class="sub-item">Surat Keluar</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#maps">
              <i class="fas fa-map-marker-alt"></i>
              <p>Staff Sekolah</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="maps">
              <ul class="nav nav-collapse">
                <?php
                if(session()->get('level')=='1' || session()->get('level')=='5' || session()->get('level')=='3'){
                  ?>
                  <li>
                    <a href="http://localhost:8080/home/hrd">
                      <span class="sub-item">HRD Section</span>
                    </a>
                  </li>
                <?php } ?>
                <?php
                if(session()->get('level')=='1' || session()->get('level')=='2' || session()->get('level')=='3'){
                  ?>
                  <li>
                    <a href="http://localhost:8080/home/kesiswaan">
                      <span class="sub-item">Kesiswaan Section</span>
                    </a>
                  </li>
                <?php } ?>
                <?php
                if(session()->get('level')=='1' || session()->get('level')=='4' || session()->get('level')=='3'){
                  ?>
                  <li>
                    <a href="http://localhost:8080/home/administrasi">
                      <span class="sub-item">Administrasi Section</span>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts">
              <i class="far fa-chart-bar"></i>
              <p>Soft Delete</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav nav-collapse">
                <li>
                  <a href="http://localhost:8080/home/restore">
                    <span class="sub-item">Surat Masuk</span>
                  </a>
                </li>
                <li>
                  <a href="http://localhost:8080/home/restore1">
                    <span class="sub-item">Surat Keluar</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </div>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery (only if using Bootstrap 4) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <!-- End Sidebar -->
</body>