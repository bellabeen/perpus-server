<?php
include_once(__DIR__."/../lib/buku.php");
include_once(__DIR__."/../lib/DataFormat.php");
header('Access-Control-Allow-Origin:*');
$buku = new Buku();
if(isset($_GET['id_peminjaman'])){
    $data=$buku->getPeminjamanPilihan($_GET['id_peminjaman']);
} else {
    $data=$buku->getPeminjaman();
}
$format=new DataFormat();
$format->asJSON($data);
echo $format->asJSON($data);