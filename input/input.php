<?php
// Ambil data dari form (jika ada)
$kecamatan = $_POST['kecamatan'] ?? '';
$luas = $_POST['luas'] ?? '';
$jumlah_penduduk = $_POST['jumlah_penduduk'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$latitude = $_POST['latitude'] ?? '';

// konfigurasi koneksi ke database MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses hanya jika form disubmit (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "INSERT INTO data_kecamatan (kecamatan, luas, jumlah_penduduk, longitude, latitude) 
            VALUES ('$kecamatan', '$luas', '$jumlah_penduduk', '$longitude', '$latitude')";

    // Menyimpan data dan memeriksa apakah berhasil
    if ($conn->query($sql) === TRUE) {
        $message = "✅ Rekord berhasil ditambahkan";
    } else {
        $message = "❌ Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $message = "Silakan kirim data melalui form input terlebih dahulu.";
}

// Tutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hasil Input Data Kecamatan</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .message-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px 30px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        a {
            color: #00ffff;
            text-decoration: none;
            margin-top: 15px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h2>Hasil Penyimpanan Data</h2>
        <p><?php echo $message; ?></p>
        <a href="../index.php">Kembali ke Daftar Data</a>
    </div>
</body>
</html>
