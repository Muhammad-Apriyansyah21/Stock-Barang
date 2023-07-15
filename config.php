<?php
$db_host   = "localhost";
$db_user   = "stockbarang1";
$db_pass   = "6I>>hgFbGJV{J6)K";
$db_name     = "";

$db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

if(!$db){
    die("Gagal terhubung dengan database:" . mysqli_connect_error());
}

?>