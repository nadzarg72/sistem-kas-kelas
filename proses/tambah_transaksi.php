<?php
include '../config/koneksi.php';
$tgl = $_POST['tanggal'];
$pihak = $_POST['pihak_terkait'];
$jns = $_POST['jenis'];
$nom = $_POST['nominal'];
$ket = $_POST['keterangan'];
$kat = ($jns=='Masuk')?'Kas':'Belanja';

mysqli_query($conn, "INSERT INTO transaksi VALUES(NULL, '$tgl', '$pihak', '$jns', '$kat', '$nom', '$ket', NULL)");
header("Location: ../dashboard.php");
?>