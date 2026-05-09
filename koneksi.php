<?php
$conn = new mysqli("localhost", "root", "", "kuispemweb");
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
?>