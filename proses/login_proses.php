<?php
session_start(); include '../config/koneksi.php';
$user = $_POST['username'];
$pass = md5($_POST['password']);

$cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
if(mysqli_num_rows($cek) > 0){
    $data = mysqli_fetch_assoc($cek);
    $_SESSION['login'] = true;
    $_SESSION['nama'] = $data['nama_lengkap'];
    $_SESSION['role'] = $data['role'];
    header("Location: ../dashboard.php");
} else {
    echo "<script>alert('Username atau password salah.'); window.location.href='../login.php';</script>";
}
?>