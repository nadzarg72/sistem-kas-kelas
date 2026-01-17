<?php
include '../config/koneksi.php';
$nama = $_POST['nama']; $user = $_POST['username']; $pass = md5($_POST['password']);

$cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
if(mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Username sudah digunakan.'); window.location.href='../register.php';</script>";
} else {
    mysqli_query($conn, "INSERT INTO users VALUES(NULL, '$nama', '$user', '$pass', 'user')");
    echo "<script>alert('Registrasi berhasil. Silakan login.'); window.location.href='../login.php';</script>";
}
?>