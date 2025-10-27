<?php

$kecamatan = $_POST['kecamatan'];
$luas = $_POST['luas'];
$jumlah_penduduk = $_POST['jumlah_penduduk'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];


//konfigurasi  koneksi ke database MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";

//membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

//cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO data_kecamatan (kecamatan, luas, jumlah_penduduk, longitude, latitude) 
VALUES ('$kecamatan', '$luas', '$jumlah_penduduk', '$longitude', '$latitude')";

//menyimpan data dan memeriksa apakah berhasil
if ($conn->query($sql) === TRUE) {
    $message ="Rekord berhasil ditambahkan";
} else {
    $message = "Error: ". $sql. "<br>". $conn->error;
}

//tutup koneksi
$conn->close();     

header ("Location: ../index.php")
?>