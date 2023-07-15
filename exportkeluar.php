<?php
require 'function.php';
require 'cek.php';
?>
<html>
<head>
  <title>Laporan Barang Keluar</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
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

<body>
<div class="container">
<br>
			<h2>Stock Barang Keluar</h2>
			<h4>(Inventory)</h4>
				<div class="data-tables datatable-dark">

                <div class="row mt-4">
                    <div class="col">
                        <form method="post" class="form-inline">
                            <input type="date" name="tgl_mulai" class="form-control">
                            <input type="date" name="tgl_keluar" class="form-control ml-10">
                            <button type="submit" name="filter_tgl" class="btn btn-info ml-10">Filter</button>
                        </form>
                    </div>
                </div>	
               
					
                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                <br>
            
                                        <thead>
                                            <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Spesifikasi</th>
                                            <th>Supplier</th>
                                            <th>Penerima Keluar</th>
                                            <th>No SK Baru</th>
                                            <th>Qty</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        <?php

                                        if(isset($_POST['filter_tgl'])){
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai = $_POST['tgl_keluar'];

                                            if($mulai!=null || $selesai!=null){
                                                $ambilsemuadatastock = mysqli_query($conn,"select * from keluar k, stock s where s.idbarang = k.idbarang and tanggal
                                                BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY) order by idkeluar DESC");
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn,"select * from keluar k, stock s where s.idbarang = k.idbarang order by idkeluar DESC");
                                            }

                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn,"select * from keluar k, stock s where s.idbarang = k.idbarang order by idkeluar DESC");
                                        }
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $idb = $data['idbarang'];
                                                $idk = $data['idkeluar'];
                                                $tanggal = $data['tanggal'];
                                                $penerimakeluar = $data['penerimakeluar'];
                                                $spesifikasi = $data['spesifikasi'];
                                                $qty = $data['qty'];
                                                $namasupplier = $data['namasupplier'];
                                                $suratkeluarbaru = $data['suratkeluarbaru'];
                                                $namabarang = $data['namabarang'];
                                            ?>
                                            <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$spesifikasi;?></td>
                                            <td><?=$namasupplier;?></td>
                                            <td><?=$penerimakeluar;?></td>
                                            <td><?=$suratkeluarbaru;?></td>
                                            <td><?=$qty;?></td>
                                            </tr>

                                            <?php
                                            };

                                            ?>

                                        </tbody>
                                    </table>
                                    <a href="keluar.php" class="btn btn-info">keluar</a>
					
				</div>
</div>
	
<script>
$(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy','csv','excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>