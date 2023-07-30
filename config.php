<?php
// Konfigurasi koneksi ke database
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "mini_atm"; 

// Buat koneksi
$connection = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}
?>