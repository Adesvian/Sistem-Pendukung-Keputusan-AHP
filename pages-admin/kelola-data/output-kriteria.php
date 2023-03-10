<?php

// jika belum login redirect ke login.php
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
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
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.php -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="../../index.php"><img src="../../assets/images/logo.svg" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="../../index.php"><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="../../assets/images/faces/face1.jpg" alt="image" />
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
                            <a class="dropdown-item" href="#">
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
            <!-- partial:../../partials/_sidebar.php -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="../../assets/images/faces/face1.jpg" alt="profile" />
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
                        <a class="nav-link" href="../../index-administrator.php">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages-admin/kriteria/data-kriteria.php">
                            <span class="menu-title">Data Kriteria Pabrik</span>
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../alternatif/data-alternatif.php">
                            <span class="menu-title">Data Alternatif Pabrik</span>
                            <i class="mdi mdi-database menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../p_kriteria/p-kriteria.php">
                            <span class="menu-title">Perbandingan Kriteria</span>
                            <i class="mdi mdi-matrix menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Perbandingan Alternatif</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-matrix menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <?php
                                if (getJumlahKriteria() > 0) {
                                    for ($i = 0; $i <= (getJumlahKriteria() - 1); $i++) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pembobotan.php?c=<?php echo ($i + 1) ?>"> <?php echo getKriteriaNama($i) ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../result/result.php">
                            <span class="menu-title">Hasil</span>
                            <i class="mdi mdi-table-large menu-icon"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Matriks Perbandingan Berpasangan</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            <?php
                                            for ($i = 0; $i <= ($n - 1); $i++) { ?>
                                                <th><?php echo getKriteriaNama($i) ?> </th>
                                            <?php }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($x = 0; $x <= ($n - 1); $x++) { ?>
                                            <tr>
                                                <td> <?php echo getKriteriaNama($x) ?> </td>
                                                <?php
                                                for ($y = 0; $y <= ($n - 1); $y++) { ?>
                                                    <td> <?php echo round($matrik[$x][$y], 5) ?> </td>
                                                <?php }
                                                ?>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th>Jumlah</th>
                                            <?php
                                            for ($i = 0; $i <= ($n - 1); $i++) { ?>
                                                <th><?php echo round($jmlmpb[$i], 5) ?></th>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Normalisasi Nilai Matriks Perbandingan Berpasangan</h4>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            <?php
                                            for ($i = 0; $i <= ($n - 1); $i++) { ?>
                                                <th><?php echo getKriteriaNama($i) ?> </th>
                                            <?php }
                                            ?>
                                            <th>Jumlah</th>
                                            <th>Vektor Prioritas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($x = 0; $x <= ($n - 1); $x++) { ?>
                                            <tr>
                                                <td> <?php echo getKriteriaNama($x) ?> </td>
                                                <?php
                                                for ($y = 0; $y <= ($n - 1); $y++) { ?>
                                                    <td> <?php echo round($matrikb[$x][$y], 5) ?> </td>
                                                <?php }
                                                ?>
                                                <td><?php echo round($jmlmnk[$x], 5) ?></td>
                                                <td><?php echo round($pv[$x], 5) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th colspan="<?php echo ($n + 2) ?>">Nilai (?? maks)</th>
                                            <th><?php echo (round($eigenvektor, 5)) ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="<?php echo ($n + 2) ?>">Consistency Index</th>
                                            <th><?php echo (round($consIndex, 5)) ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="<?php echo ($n + 2) ?>">Consistency Ratio</th>
                                            <th><?php echo (round(($consRatio * 100), 2)) ?> %</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($consRatio > 0.1) {
                    ?>
                        <div class="col-lg-12 grid-margin">
                            <div class="row" id="proBanner">
                                <div class="col-12">
                                    <span class="d-flex align-items-center purchase-popup btn-youtube">
                                        <p class="text-white ">
                                            Nilai Consistency Ratio terlalu besar, dan tidak konsisten karena lebih dari 10% silahkan input lagi matriks perbandingannya !
                                        </p>
                                        <i class="mdi mdi-close text-white " id="bannerClose" style="margin-left: 250px;cursor:pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    } ?>
                </div>



                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.php -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ?? 2022 . Made with <i class="mdi mdi-heart text-danger"></i>.
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
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->

</body>

</html>