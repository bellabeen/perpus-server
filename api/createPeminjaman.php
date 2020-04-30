<?php
include_once(__DIR__."/../lib/buku.php");
include_once(__DIR__."/../lib/DataFormat.php");
header("Access-Control-Allow-Methods: POST");
$buku = new Buku();

$id_buku = isset($_GET['id_buku']) ? $_GET['id_buku']: null;
$id_peminjam = isset($_GET['id_peminjam']) ? $_GET['id_peminjam']: null;
$tanggal_pesan = isset($_GET['tanggal_pesan']) ? $_GET['tanggal_pesan']: null;
$jam_pesan = isset($_GET['jam_pesan']) ? $_GET['jam_pesan']: null;
$expired_date = isset($_GET['expired_date']) ? $_GET['expired_date']: null;
$tanggal_pinjam = isset($_GET['tanggal_pinjam']) ? $_GET['tanggal_pinjam']: null;
$batas_kembali = isset($_GET['batas_kembali']) ? $_GET['batas_kembali']: null;
$tanggal_pengembalian = isset($_GET['tanggal_pengembalian']) ? $_GET['tanggal_pengembalian']: null;
$status = isset($_GET['status']) ? $_GET['status']: null;
$pp = isset($_GET['pp']) ? $_GET['pp']: null;


$buku->setValue($id_buku, $id_peminjam, $tanggal_pesan, $jam_pesan, $expired_date, $tanggal_pinjam, 
$batas_kembali, $tanggal_pengembalian, $status, $pp);
$result = $buku->createPeminjaman();
$format= new DataFormat();
echo $format->asJSON($result);
?>