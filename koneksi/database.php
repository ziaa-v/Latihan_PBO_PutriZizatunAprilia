<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_latihan_pbo_trpl1b_putrizizatunaprilia";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>