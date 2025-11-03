<?php
// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk mengambil data
$sql = "SELECT * FROM data_kecamatan WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Kecamatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 500px;
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-submit:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Kecamatan</h2>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="kecamatan">Nama Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" value="<?php echo $row['kecamatan']; ?>" required>
            </div>
            <div class="form-group">
                <label for="luas">Luas (km²)</label>
                <input type="text" id="luas" name="luas" value="<?php echo $row['luas']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah_penduduk">Jumlah Penduduk</label>
                <input type="text" id="jumlah_penduduk" name="jumlah_penduduk" value="<?php echo $row['jumlah_penduduk']; ?>" required>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" id="longitude" name="longitude" value="<?php echo $row['longitude']; ?>" required>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" id="latitude" name="latitude" value="<?php echo $row['latitude']; ?>" required>
            </div>
            <button type="submit" class="btn-submit">Update Data</button>
        </form>
    </div>
</body>
</html>