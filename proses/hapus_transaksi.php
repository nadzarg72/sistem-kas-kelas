<?php
session_start(); include '../config/koneksi.php';

if($_SESSION['role'] == 'admin'){
    mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi='$_GET[id]'");
}
header("Location: ../dashboard.php");
?>