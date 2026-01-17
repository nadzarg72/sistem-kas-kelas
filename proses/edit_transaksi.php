<?php
include '../config/koneksi.php';
$id = $_POST['id'];
$tgl = $_POST['tanggal'];
$pihak = $_POST['pihak_terkait'];
$jns = $_POST['jenis'];
$nom = $_POST['nominal'];
$ket = $_POST['keterangan'];
$kat = ($jns=='Masuk')?'Kas':'Belanja';

mysqli_query($conn, "UPDATE transaksi SET tanggal='$tgl', pihak_terkait='$pihak', jenis='$jns', kategori='$kat', nominal='$nom', keterangan='$ket' WHERE id_transaksi='$id'");
header("Location: ../dashboard.php");
?>