<?php
require 'function.php';
require 'cek.php';
?>
<html>
<head>
  <title>Laporan Stock Barang</title>
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
			<h2>STOCK STORAGE</h2>
			<h4>WAREHOUSE</h4>

				<div class="data-tables datatable-dark">
					
                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                <div class="data-tables datatable-dark">
                    <br><hr>
                
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No SM</th>
                                                <th>Nama Barang</th>
                                                <th>Spesifikasi</th>
                                                <th>Supplier</th>
                                                <th>Stock</th>
                      
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $ambilsemuadatastock = mysqli_query($conn,"select * from stock");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $namabarang = $data['namabarang'];
                                                $nosuratmasuk = $data['nosuratmasuk'];
                                                $spesifikasi = $data['spesifikasi'];
                                                $stock = $data['stock'];
                                                $supplier = $data['supplier'];
                                                $idb = $data['idbarang'];
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
                                            <td><?=$i++;?></td>
                                                <td><?=$nosuratmasuk;?></td>
                                                <td><strong><a href="detail.php?id=<?=$idb;?>"><?=$namabarang;?></a></strong></td>
                                                <td><?=$spesifikasi;?></td>
                                                <td><?=$supplier;?></td>
                                                <td><?=$stock;?></td>
                                            </tr>

                                            <?php
                                            };

                                            ?>

                                        </tbody>
                                    </table>
                                    <div class="row mt-4">
                                    <a href="index.php" class="btn btn-info">keluar</a>
					
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