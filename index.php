<?php

require 'function.php';
require 'cek.php';

 ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/inventory.png">

    <title>Stock Barang</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-fw fa-box-open"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Toko Lestari <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="barang.php">
                    <i class="fa fa-fw fa-box"></i>
                    <span>Data Barang</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fa fa-fw fa-archive"></i>
                    <span>Stock Barang</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="masuk.php">
                    <i class="fa fa-fw fa-arrow-circle-right"></i>
                    <span>Barang Masuk</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="keluar.php">
                    <i class="fa fa-fw fa-arrow-circle-left"></i>
                    <span>Barang Keluar</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="admin.php">
                    <i class="fa fa-fw fa-user-circle"></i>
                    <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fa fa-fw fa-door-open"></i>
                    <span>Logout</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Stok Barang</h1>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                              <a href ="export index.php" class="btn btn-info">Export</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Stok</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          $ambilsemuadatastok = mysqli_query($conn,"select * from stok inner join databarang on databarang.kodebarang=stok.kodebarang");
                                            $i = 1;
                                          while($data= mysqli_fetch_array($ambilsemuadatastok)){

                                            $namabarang = $data ['namabarang'];
                                            $deskripsi = $data ['deskripsi'];
                                            $stok = $data ['stok'];
                                            $kodeb = $data ['kodebarang'];
                                           ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stok;?></td>
                                                <td>  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$kodeb;?>">
                                                    Edit
                                                  </button>
                                                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$kodeb;?>">
                                                     Delete
                                                   </button>
                                                  </td>
                                            </tr>
                                              <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$kodeb;?>">
                                              <div class="modal-dialog">
                                                <div class="modal-content">

                                                  <!-- Modal Header -->
                                                  <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  </div>

                                                  <form method="post">
                                                  <div class="modal-body">
                                                  <input type="text" name="namabarang" value = "<?=$namabarang;?>" class="form-control" required>
                                                  <br>
                                                    <input type="text" name="deskripsi" value = "<?=$deskripsi;?>" class="form-control" required>
                                                    <br>
                                                    <input type="number" name="stok" value = "<?=$stok;?>" class="form-control" required>
                                                    <br>
                                                    <input type= "hidden" name = "kodebarang" value=<?=$kodeb;?>>
                                                    <button type="submit" class="btn btn-primary" name="updatebarangstok">Edit</button>
                                                  </div>
                                                </form>
                                                </div>
                                              </div>
                                            </div>
                                            <!-- delete Modal -->
                                          <div class="modal fade" id="delete<?=$kodeb;?>">
                                            <div class="modal-dialog">
                                              <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Hapus Barang</h4>
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post">
                                                <div class="modal-body">
                                              Apakah Anda Yakin ingin Menghapus <?=$namabarang;?>
                                              <input type= "hidden" name = "kodebarang" value=<?=$kodeb;?>>
                                                  <br>
                                                  <br>
                                                  <button type="submit" class="btn btn-danger" name="hapusbarangstok">Hapus</button>
                                                </div>
                                            <?php
                                          };
                                             ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
