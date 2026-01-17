<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "db_keuangan_kelas";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>