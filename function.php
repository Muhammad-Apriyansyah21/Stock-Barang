<?php
session_start();

//Koneksi Ke Data Base
$conn = mysqli_connect("localhost","root","","stockbarang");

//Add Barang Stock
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $nosuratmasuk = $_POST['nosuratmasuk'];
    $spesifikasi = $_POST['spesifikasi'];
    $stock = $_POST['stock'];
    $supplier = $_POST['supplier'];

    //input gambar
    $allowed_extension = array('png','jpg','jpeg',);
    $nama = $_FILES['file']['name']; //memanggil nama gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //memanggil ekstensi
    $ukuran = $_FILES['file']['size']; //memanggil size file
    $file_tmp = $_FILES['file']['tmp_name']; //mengambil lokasi file

    //penamaan file yang dienkripsi
    $image = md5(uniqid($nama, true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensi

    //validasi sudah ada atau belum
    $cek = mysqli_query($conn,"select * from stock where namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if($hitung<1){
        //jika belum ada

        //proses upload gambar
        if(in_array($ekstensi, $allowed_extension) === true){
            //validasi ukuran file
            if($ukuran < 15000000){
                move_uploaded_file($file_tmp, 'images/'.$image);

                $addtotable = mysqli_query($conn,"insert into stock (namabarang, nosuratmasuk, spesifikasi, supplier, stock, image) values
                ('$namabarang', '$nosuratmasuk', '$spesifikasi', '$supplier', '$stock', '$image')");
                if($addtotable){
                    header('location:index.php');
                } else {
                    echo 'Gagal Input';
                    header('location:index.php');
                 }
            } else {
                //jika file lebih dari 15 mb
                echo '
                <script> 
                    alert("Ukuran yang anda masukan terlalu besar");
                    window.location.href="index.php";
                </script>';
            }
        } else {
            //jika gambar bukan png, jpg, jpeg
            echo '
            <script>  
                alert("File harus png, jpg & jpeg");
                window.location.href="index.php";
            </script>';
        }

    } else {
        //jika sudah ada
        echo '
        <script> 
            alert("Nama barang sudah terdaftar");
            window.location.href="index.php";
        </script>';
    }
};

//menambahkan barang masuk 
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $tanggal = $_POST['tanggal'];
    $spesifikasi = $_POST['spesifikasi'];
    $suratmasukbaru = $_POST['suratmasukbaru'];
    $suppliermasuk = $_POST['suppliermasuk'];
    $qty = $_POST['qty'];
    $penerimamasuk = $_POST['penerimamasuk'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $cekstocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangqty = $cekstocksekarang+$qty;


    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, suratmasukbaru, qty, penerimamasuk, spesifikasi, suppliermasuk)
    values('$barangnya', '$suratmasukbaru','$qty','$penerimamasuk','$spesifikasi','$suppliermasuk')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangqty' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal Input';
        header('location:masuk.php');
    }
}

//barang keluar
if(isset($_POST['barangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $tanggal = $_POST['tanggal'];
    $spesifikasi = $_POST['spesifikasi'];
    $suratkeluarbaru = $_POST['suratkeluarbaru'];
    $namasupplier = $_POST['namasupplier'];
    $qty = $_POST['qty'];
    $penerimakeluar = $_POST['penerimakeluar'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $cekstocksekarang = $ambildatanya['stock'];

    if($cekstocksekarang >= $qty){
        //Kalau barangnya cukup
        $tambahkanstocksekarangqty = $cekstocksekarang-$qty;

        $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang,  spesifikasi, qty, penerimakeluar, suratkeluarbaru, namasupplier)
        values('$barangnya', '$spesifikasi','$qty','$penerimakeluar','$suratkeluarbaru','$namasupplier')");
        $updatestockkeluar = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangqty' where idbarang='$barangnya'");
        if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
        } else {
        echo 'Gagal Input';
        header('location:keluar.php');
        }
    } else {
        //Kalau Barangnya Gak Cukup
        echo '<script>
            alert("Stock Saat Ini Tidak Mencukupi, Silahkan Cek Stock Anda");
            window.location.href="keluar.php";
        </script>';
    }
}

//Update Info Barang Stock
if(isset($_POST['updatebarang'])){
    //$idb = $_POST['idb'];
    //$namabarang = $_POST['namabarang'];
    //$lokasipart = $_POST['lokasipart'];
    //$serialnumber = $_POST['serialnumber'];
    //$serialnumber1 = $_POST['serialnumberbaru'];
    //$deskripsi = $_POST['deskripsi'];
    //$stock = $_POST['stock'];0

    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $spesifikasi = $_POST['spesifikasi'];
    $stock = $_POST['stock'];
    $nosuratmasuk = $_POST['nosuratmasuk'];
    
    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['file']['name']; //memanggil nama gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //memanggil ekstensi
    $ukuran = $_FILES['file']['size']; //memanggil size file
    $file_tmp = $_FILES['file']['tmp_name']; //mengambil lokasi file

    //penamaan file yang dienkripsi
    $image = md5(uniqid($nama, true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensi

    if($ukuran==0){
        // jika tidak ingin upload
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', nosuratmasuk='$nosuratmasuk',
        spesifikasi='$spesifikasi', stock='$stock' where idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal Input';
            header('location:index.php');
        } 
    } else {
        // jika ingin
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', nosuratmasuk='$nosuratmasuk',  
        spesifikasi='$spesifikasi', image='$image', stock='$stock' where idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal Input';
            header('location:index.php');
        } 
    }
}

//Hapus Barang Stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb']; //idbarang

    $gambar = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['image'];
    unlink($img);

    $hapus = mysqli_query($conn,"delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal Input';
        header('location:index.php');
    }  
}

//Mengubah Data Barang Masuk Edit
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qty = $_POST['qty'];
    $penerimamasuk = $_POST['penerimamasuk'];
    $suppliermasuk = $_POST['suppliermasuk'];
    $suratmasukbaru = $_POST['suratmasukbaru'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $ktyskrg = $qtynya['qty'];

    if($qty>$ktyskrg){
        $selisih = $qty-$ktyskrg;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', penerimamasuk='$penerimamasuk',
        suratmasukbaru='$suratmasukbaru', suppliermasuk='$suppliermasuk'  where idmasuk='$idm'");
            if($kuranginstocknya&&$updatenya){
                header('location:masuk.php');
                 } else {
                 echo 'Gagal Input';
                 header('location:masuk.php');
                 }   
    } else { 
        $selisih = $ktyskrg-$qty;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', penerimamasuk='$penerimamasuk'
        suratmasukbaru='$suratmasukbaru', suppliermasuk='$suppliermasuk' where idmasuk='$idm'");
            if($kuranginstocknya&&$updatenya){
                header('location:masuk.php');
                 } else {
                 echo 'Gagal Input';
                 header('location:masuk.php');
                 }
    }
}

//Menghapus Barang Masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
         } else {
         header('location:masuk.php');
         }
}

//Mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerimakeluar'];
    $qty = $_POST['qty'];
    $namasupplier = $_POST['namasupplier'];
    $suratkeluarbaru = $_POST['suratkeluarbaru'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $ktyskrg = $qtynya['qty'];

    if($qty>$ktyskrg){
        $selisih = $qty-$ktyskrg;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update keluar set qty='$qty', penerimakeluar='$penerima', 
        suratkeluarbaru='$suratkeluarbaru', namasupplier='$namasupplier' where idkeluar='$idk'");
            if($kuranginstocknya&&$updatenya){
                header('location:keluar.php');
                 } else {
                 echo 'Gagal Input';
                 header('location:keluar.php');
                 }   
    } else { 
        $selisih = $ktyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update keluar set qty='$qty', penerimakeluar='$penerima',
        suratkeluarbaru='$suratkeluarbaru', namasupplier='$namasupplier'  where idkeluar='$idk'");
            if($kuranginstocknya&&$updatenya){
                header('location:keluar.php');
                 } else {
                 echo 'Gagal Input';
                 header('location:keluar.php');
                 }
    }
}

//Menghapus Barang Keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
         } else {
         header('location:keluar.php');
         }
}


//Menambahkan Akses Admin Baru
if(isset($_POST['addadmin'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn,"insert into login (email, password) values ('$email','$password')");

    if($queryinsert){
        // seandainya berhasil
        header('location:admin.php');
    } else {
        // jika gagal masukan data
        header('location:admin.php');
    }
}


//Update akses admin
if(isset($_POST['updateadmin'])){
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya = $_POST['id'];

    $queryupdate = mysqli_query($conn,"update login set email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if($queryupdate){
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

//Menghapus akses admin
if(isset($_POST['hapusadmin'])){
    $idhapus = $_POST['id'];

    $querydelete =mysqli_query($conn,"delete from login where iduser='$idhapus'");
    if($queryupdate){
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

//meminjam barang
if(isset($_POST['pinjam'])){
    $idbarang = $_POST['barangnya'];
    $qty = $_POST['qty'];
    $peminjam = $_POST['peminjam'];
    $catatan = $_POST['catatan'];
  

    //ambil stock sekarang
    $stok_saat_ini = mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
    $stok_nya = mysqli_fetch_array($stok_saat_ini);
    $stok = $stok_nya['stock']; // valuenya dari  stok

    //kurangi stok
    $new_stock = $stok-$qty;

    //mulai query menkoneksikan ke database pada insert
    $insertpinjam = mysqli_query($conn,"INSERT INTO peminjaman (idbarang,qty,peminjam,catatan) values
    ('$idbarang','$qty','$peminjam','$catatan')");

    //mengurangi stock ditable stock
    $kurangistok = mysqli_query($conn,"update stock set stock='$new_stock' where idbarang='$idbarang'");

    if($insertpinjam&&$kurangistok){
        //jika berhasil
        echo '
        <script>
            alert("Anda berhasil menambahkan data Peminjaman");
            window.location.href="peminjaman.php";
        </script>';
    } else {
        //jika gagal
        echo '
        <script>
            alert("Anda gagal menambahkan data Peminjaman!!");
            window.location.href="peminjaman.php";
        </script>';
    }
}

//meneyelesaikan pinjaman
if(isset($_POST['barangkembali'])){
    $idpinjam = $_POST['idpinjam'];
    $idbarang = $_POST['idbarang'];

    //eksekusi
    $update_status = mysqli_query($conn,"update peminjaman set status='Success' where idpeminjaman='$idpinjam'");

     //ambil stock sekarang
     $stok_saat_ini = mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
     $stok_nya = mysqli_fetch_array($stok_saat_ini);
     $stok = $stok_nya['stock']; // valuenya dari  stok

      //ambil qty dari idpinjam sekarang
      $stok_saat_ini1 = mysqli_query($conn,"select * from peminjaman where idpeminjaman='$idpinjam'");
      $stok_nya1 = mysqli_fetch_array($stok_saat_ini1);
      $stok1 = $stok_nya1['qty']; // valuenya dari  stok
 
     //kurangi stok
     $new_stock = $stok1+$stok;

    //kembalikan stock
    $kembalikan_stock = mysqli_query($conn,"update stock set stock='$new_stock' where idbarang='$idbarang'");

    if($update_status&&$kembalikan_stock){
        //jika berhasil
        echo '
        <script>
            alert("Anda telah menyelesaikan pengerjaan");
            window.location.href="peminjaman.php";
        </script>';
    } else {
        //jika gagal
        echo '
        <script>
            alert("Anda gagal menyelesaikan pengerjaan");
            window.location.href="peminjaman.php";
        </script>';
    }
}

//Tambah Data Pengerjaan
if(isset($_POST['addnewkerja'])){
    $namabarang = $_POST['namabarang'];
    $image = $_POST ['image'];
    $lokasipart = $_POST['lokasipart'];
    $serialnumber = $_POST['serialnumber'];
    $serialnumber1 = $_POST['serialnumberbaru'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $namapekerja = $_POST['namapekerja'];
    $status = $_POST['status'];

    //input gambar
    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['file']['name']; //memanggil nama gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //memanggil ekstensi
    $ukuran = $_FILES['file']['size']; //memanggil size file
    $file_tmp = $_FILES['file']['tmp_name']; //mengambil lokasi file

    //penamaan file yang dienkripsi
    $image = md5(uniqid($nama, true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensi

    //validasi sudah ada atau belum
    $cek = mysqli_query($conn,"select * from pengerjaan where namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if($hitung<1){
        //jika belum ada

        //proses upload gambar
        if(in_array($ekstensi, $allowed_extension) === true){
            //validasi ukuran file
            if($ukuran < 15000000){
                move_uploaded_file($file_tmp, 'picture/'.$image);

                $addtotable = mysqli_query($conn,"insert into pengerjaan (namabarang, deskripsi, stock, image, serialnumber, serialnumberbaru, lokasipart,namapekerja,status) values
                ('$namabarang', '$deskripsi', '$stock', '$image', '$serialnumber', '$serialnumber1', '$lokasipart', '$namapekerja', '$status')");
                if($addtotable){
                    header('location:pekerjaan.php');
                } else {
                    echo 'Gagal Input';
                    header('location:pekerjaan.php');
                 }
            } else {
                //jika file lebih dari 15 mb
                echo '
                <script> 
                    alert("Ukuran yang anda masukan terlalu besar");
                    window.location.href="pekerjaan.php";
                </script>';
            }
        } else {
            //jika gambar bukan png, jpg, jpeg
            echo '
            <script>  
                alert("File harus png, jpg & jpeg");
                window.location.href="pekerjaan.php";
            </script>';
        }

    } else {
        //jika sudah ada
        echo '
        <script> 
            alert("Nama barang sudah terdaftar");
            window.location.href="pekerjaan.php";
        </script>';
    }
};
    
//Edit Data Pengerjaan
if(isset($_POST['editpekerjaan'])){
    $idb = $_POST['idbarang'];
    $namabarang = $_POST['namabarang'];
    $lokasipart = $_POST['lokasipart'];
    $serialnumber = $_POST['serialnumber'];
    $serialnumber1 = $_POST['serialnumberbaru'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $namapekerja = $_POST['namapekerja'];
    $status = $_POST['status'];
    
    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['file']['name']; //memanggil nama gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //memanggil ekstensi
    $ukuran = $_FILES['file']['size']; //memanggil size file
    $file_tmp = $_FILES['file']['tmp_name']; //mengambil lokasi file

    //penamaan file yang dienkripsi
    $image = md5(uniqid($nama, true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensi

    if($ukuran==0){
        // jika tidak ingin upload
        $update = mysqli_query($conn,"update pengerjaan set namabarang='$namabarang', deskripsi='$deskripsi', stock='$stock', status='$status',
        lokasipart='$lokasipart', serialnumber='$serialnumber', serialnumberbaru='$serialnumber1', namapekerja='$namapekerja' where idbarang='$idb'");
        if($update){
            header('location:pekerjaan.php');
        } else {
            echo 'Gagal Input';
            header('location:pekerjaan.php');
        } 
    } else {
        // jika ingin
        move_uploaded_file($file_tmp, 'picture/'.$image);
        $update = mysqli_query($conn,"update pengerjaan set namabarang='$namabarang', deskripsi='$deskripsi', image='$image', namapekerja='$namapekerja' 
        stock='$stock', lokasipart='$lokasipart', serialnumber='$serialnumber', serialnumberbaru='$serialnumber1' where idbarang='$idb'");
        if($update){
            header('location:pekerjaan.php');
        } else {
            echo 'Gagal Input';
            header('location:pekerjaan.php');
        } 
    }
}

//Hapus Barang Pekerjaan
if(isset($_POST['hapuskerja'])){
    $idb = $_POST['idb']; //idbarang

    $gambar = mysqli_query($conn,"select * from pengerjaan where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'picture/'.$get['image'];
    unlink($img);

    $hapus = mysqli_query($conn,"delete from pengerjaan where idbarang='$idb'");
    if($hapus){
        header('location:pekerjaan.php');
    } else {
        echo 'Gagal Input';
        header('location:pekerjaan.php');
    }  
}

?>