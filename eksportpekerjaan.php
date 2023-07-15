<?php
require 'function.php';
require 'cek.php';
?>
<html>
<head>
  <title>Laporan Data Pengerjaan</title>
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
			<h2>Data Pengerjaan</h2>
			<h4>Pengerjaan</h4>

				<div class="data-tables datatable-dark">
					
                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                <div class="data-tables datatable-dark">
                    <br><hr>
                
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th>Nama Pekerja</th>
                                                <th>Nama Barang</th>
                                                <th>Posisi</th>
                                                <th>S/N Before OH</th>
                                                <th>S/N After OH</th>
                                                <th>Deskripsi</th>
                                                <th>Jumlah</th>
                                                <th>Status Pekerjaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $ambilsemuadatastock = mysqli_query($conn,"select * from pengerjaan");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $namabarang = $data['namabarang'];
                                                $lokasipart = $data['lokasipart'];
                                                $serialnumber = $data['serialnumber'];
                                                $serialnumber1 = $data['serialnumberbaru'];
                                                $deskripsi = $data['deskripsi'];
                                                $stock = $data['stock'];
                                                $idb = $data['idbarang'];
                                                $namapekerja = $data['namapekerja'];
                                                $status = $data['status'];

                                                      //cek gambar
                                                      $gambar = $data['image']; //ambil gambar
                                                      if($gambar==null){
                                                          //jika tidak ada gambar
                                                          $image = 'No Image';
                                                      } else {
                                                          // jika ada gambar
                                                          $image = '<image src="picture/'.$gambar.'" class="zoomable">';
                                                      }
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?php echo $image;?></td>
                                                <td><?=$namapekerja;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$lokasipart;?></td>
                                                <td><?=$serialnumber;?></td>
                                                <td><?=$serialnumber1;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stock;?></td>
                                                <td><?=$status;?></td>
                                            </tr>

                                            <?php
                                            };

                                            ?>

                                        </tbody>
                                    </table>
                                    <div class="row mt-4">
                                    <a href="pekerjaan.php" class="btn btn-info">keluar</a>
					
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