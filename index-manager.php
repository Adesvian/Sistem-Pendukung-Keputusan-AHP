<?php
include 'assets\Database\funtion.php';

// jika belum login redirect ke login.php
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Purple Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="assets/css/style.css" />
  <!-- End layout styles -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.php -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index-administrator.php"><img src="assets/images/logo.svg" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index-administrator.php"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="assets/images/faces/face1.jpg" alt="image" />
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo $_SESSION['user'] ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-account-settings mr-2 text-success"></i>
                Account Settings
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">
                <i class="mdi mdi-logout mr-2 text-primary"></i> Signout
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.php -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="assets/images/faces/face1.jpg" alt="profile" />
                <span class="login-status online"></span>
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2"><?php echo $_SESSION['user'] ?></span>
                <span class="text-secondary text-small"><?php echo getRoleUser($_SESSION['user']) ?></span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="index-manager.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages-manager\print\print-data.php">
              <span class="menu-title">Print Data</span>
              <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages-manager\user\data-user.php">
              <span class="menu-title">Edit User</span>
              <i class="mdi mdi-database menu-icon"></i>
            </a>
          </li>

        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb"></ul>
            </nav>
          </div>
          <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">
                    Data Alternatif
                    <i class="mdi mdi-database mdi-24px float-right"></i>
                  </h4>
                  <h1 class="mb-5"><?php echo getJumlahAlternatif() ?></h1>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">
                    Data Kriteria
                    <i class="mdi mdi-format-list-bulleted mdi-24px float-right"></i>
                  </h4>
                  <h1 class="mb-5"><?php echo getJumlahKriteria() ?></h1>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">
                    Data Pengguna
                    <i class="mdi mdi-account mdi-24px float-right"></i>
                  </h4>
                  <h1 class="mb-5"><?php echo getJumlahUser() ?></h1>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title ">Ranking</h4>
                  <div class="table-responsive">
                    <table class="table ">
                      <thead>
                        <tr>
                          <th>Alternatif</th>
                          <th>Nilai</th>
                          <th>Peringkat</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (getJumlahAlternatif() > 2) {
                          $query  = "SELECT id,nama,id_alternatif,nilai FROM alternatif,ranking WHERE alternatif.id = ranking.id_alternatif ORDER BY nilai DESC";
                          $result = mysqli_query($koneksi, $query);

                          $i = 0;
                          $badge = array('badge-gradient-success', 'badge-gradient-info', 'badge-gradient-warning', 'badge-gradient-danger');
                          $key = 0; // start counter 
                          $class_count = count($badge);
                          while ($row = mysqli_fetch_array($result)) {
                            $i++;
                        ?>
                            <tr>
                              <td>
                                <?php echo $row['nama'] ?>
                              </td>
                              <td><?php echo $row['nilai'] ?></td>
                              <?php if ($i ==  1) { ?>
                                <td>
                                  <label class="badge <?php echo $badge[$key] ?>"> &ensp; &ensp; &ensp;<?php echo $i ?> &ensp; &ensp; &ensp;</label>
                                </td>
                              <?php
                              } elseif ($i ==  2) {
                              ?>
                                <td>
                                  <label class="badge <?php echo $badge[$key] ?>">&ensp; &ensp; &ensp;<?php echo $i ?> &ensp; &ensp; &ensp;</label>
                                </td>
                              <?php
                              } elseif ($i ==  3) {
                              ?>
                                <td>
                                  <label class="badge <?php echo $badge[$key] ?>">&ensp; &ensp; &ensp;<?php echo $i ?> &ensp; &ensp; &ensp;</label>
                                </td>
                              <?php
                              } else {
                              ?>
                                <td>
                                  <label class="badge <?php echo $badge[3] ?>">&ensp; &ensp; &ensp;<?php echo $i ?> &ensp; &ensp; &ensp;</label>
                                </td>
                              <?php
                              }
                              ?>
                            </tr>
                          <?php
                            $key++;
                          }
                          ?>

                        <?php
                        } else { ?>
                          <td></td>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.php -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2022 . Made with <i class="mdi mdi-heart text-danger"></i>.
          </div></span>
      </div>
      </footer>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/misc.js"></script>

  <!-- End custom js for this page -->
</body>

</html>