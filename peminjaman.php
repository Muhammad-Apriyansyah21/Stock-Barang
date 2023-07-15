<?php
require 'function.php';
require 'cek.php';

//get data
//ambil data total
$get1 = mysqli_query($conn, "select * from peminjaman");
$count1 = mysqli_num_rows($get1); //menghitung seluruh kolom

//ambil data peminjaman yang statusnya dipinjam
$get2 = mysqli_query($conn, "select * from peminjaman where status='Dipinjam'");
$count2 = mysqli_num_rows($get2); // menghitung status kolom yang statusnya dipinjam

//ambil data peminjaman yang statusnya kembali
$get3 = mysqli_query($conn, "select * from peminjaman where status='Success'");
$count3 = mysqli_num_rows($get3);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock-Peminjaman</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .zoomable{
                width: 150px;
            }
            .zoomable:hover{
                transform: scale(2);
                transition: 0.3s ease;
            }

        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Inventory Team 10</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="peminjaman.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Peminjaman
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kelola Admin
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Peminjaman Barang</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                               <!-- Button to Open the Modal -->
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                  Tambahkan Barang
                             </button>
                            
                             <a href="exportpengerjaan.php" class="btn btn-info">Export Data Pengerjaan</a>
                             <br> 

                             <div class="row mt-4">
                                 <div class="col">
                                     <form method="post" class="form-inline">
                                         <input type="date" name="tgl_mulai" class="form-control">
                                         <input type="date" name="tgl_keluar" class="form-control ml-3">
                                         <button type="submit" name="filter_tgl" class="btn btn-info ml-3">Filter</button>
                                     </form>
                                 </div>
                             </div>
            
                             <div class="row mt-4 ">
                                 <div class="col">
                                     <div class="card bg-info text-black p-3"><h2>total Data: <?=$count1?></h2></div>
                                 </div>
                                 <div class="col">
                                     <div class="card bg-danger text-black p-3"><h2>total Dipinjam: <?=$count2?></h2></div>
                                 </div>
                                 <div class="col">
                                     <div class="card bg-success text-black p-3"><h2>total Success: <?=$count3?></h2></div>
                                 </div>
                             </div>

                             </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Gambar</th>
                                                <th>Part Number</th>
                                                <th>Nama Barang</th>
                                                <th>Spesifikasi</th>
                                                <th>Merk</th>
                                                <th>Satuan</th>
                                                <th>Jumlah</th>
                                                <th>Peminjam</th>
                                                <th>Catatan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        <?php
                                          if(isset($_POST['filter_tgl'])){
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai = $_POST['tgl_keluar'];

                                            if($mulai!=null || $selesai!=null){
                                                $ambilsemuadatastock = mysqli_query($conn,"select * from peminjaman p, stock s where s.idbarang = p.idbarang and tanggalpinjam
                                                BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY) order by idpeminjaman DESC");
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn,"select * from peminjaman p, stock s where s.idbarang = p.idbarang order by idpeminjaman DESC");
                                            }
                                    
                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn,"select * from peminjaman p, stock s where s.idbarang = p.idbarang order by idpeminjaman DESC");
                                        }

                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $idb = $data['idbarang'];
                                                $idk = $data['idpeminjaman'];
                                                $tanggalpinjam = $data['tanggalpinjam'];
                                                $namabarang = $data['namabarang'];
                                                $partnumber = $data['partnumber'];
                                                $satuan = $data['satuan'];
                                                $merk = $data['merk'];
                                                $qty = $data['qty'];
                                                $peminjam = $data['peminjam'];
                                                $catatan = $data['catatan'];
                                                $status = $data['status'];
                                                $spesifikasi = $data['spesifikasi'];

                                                //cek gambar
                                                $gambar = $data['image']; //ambil gambar
                                                if($gambar==null){
                                                    //jika tidak ada gambar
                                                    $img = 'No Image';
                                                } else {
                                                    // jika ada gambar
                                                    $img = '<img src="images/'.$gambar.'" class="zoomable">';
                                                }
                                            ?>
                                            <tr>
                                                <td><?=$tanggalpinjam;?></td>
                                                <td><?=$img;?></td>
                                                <td><?=$partnumber;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$spesifikasi;?></td>
                                                <td><?=$merk;?></td>
                                                <td><?=$satuan;?></td>
                                                <td><?=$qty;?></td>
                                                <td><?=$peminjam;?></td>
                                                <td><?=$catatan;?></td>
                                                <td><strong><?=$status; ?></strong></td>
                                                <td>
                                                <?php
                                                if($status=='Dipinjam'){
                                                    echo'
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit'.$idk.'">
                                                    Success
                                                    </button>';
                                                } else {
                                                }
                                                ?>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idk;?>">
                                            <div class="modal-dialog">
                                            <div class="modal-content">

                                             <!-- Modal Header -->
                                             <div class="modal-header">
                                             <h4 class="modal-title"> Selesaikan Pinjaman </h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             </div>

                                             <!-- Modal body -->
                                             <form method="post">
                                             <div class="modal-body">
                                                 Apakah barang ini telah selesai dipinjam ?
                                                 <br><br>
                                            <input type="hidden" name="idpinjam" value="<?=$idk;?>">
                                            <input type="hidden" name="idbarang" value="<?=$idb;?>">
                                             <button type="submit" class="btn btn-success" name="barangkembali">Yes</button>
                                             </div>
                                             </form>
                                                    </div>
                                                </div>
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>

      <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambahkan Data Pengerjaan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <form method="post">
      <div class="modal-body">
      <select name="barangnya" class="form-control" id="myInput" type="" >
      <?php
        $ambilsemuadata = mysqli_query($conn,"select * from stock");
        while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
            $namabarang = $fetcharray['namabarang'];
            $idbarang = $fetcharray['idbarang'];
            $partnumber = $fetcharray['partnumber'];
            $spesifikasi = $fetcharray['spesifikasi'];
            $qty = $fetcharray['qty'];
            $image = $fetcharray['image'];
            $merk = $fetcharray['merk'];
            $satuan = $fetcharray['satuan'];
            $posisi = $fetcharray['posisi'];
            $lokasi = $fetcharray['lokasi'];
        ?>

        <option value="<?=$idbarang;?>"><?=$namabarang;?></option>

        <?php
        }
      ?>
    </select>
      <br>
      <input type="number" name="qty"  class="form-control" placeholder="Jumlah" required>
      <br>
      <input type="text" name="peminjam"  class="form-control" placeholder="Peminjam" required>
      <br>
      <input type="text" name="catatan"  class="form-control" placeholder="Catatan" required>
      <br>
      <button type="submit" class="btn btn-primary" name="pinjam">Submit</button>
      </div>
      </form>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

</html>
