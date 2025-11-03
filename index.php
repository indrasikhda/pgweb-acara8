<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan - Futuristic</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
        }
        .btn-input {
            display: inline-block;
            color: #333;
            padding: 10px 0;
            text-decoration: underline;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .btn-input:hover {
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #333;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f9f9f9;
            font-weight: 600;
        }
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
            border-radius: 8px;
        }
        .btn-edit, .btn-hapus {
            display: inline-block;
            padding: 5px 10px;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 5px;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-hapus {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Data Kecamatan</h2>
        <?php
        //koneksi ke database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pgweb_acara8";

        // Create connection 
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT*FROM data_kecamatan";
        $result = $conn->query($sql);
        $data = array();

        echo "<a href='input/index.html' class='btn-input'><i class=\"fas fa-plus-circle\"></i> Input Data</a>";

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th><i class=\"fas fa-id-card\"></i> ID</th>
                        <th><i class=\"fas fa-map-marker-alt\"></i> Nama Kecamatan</th>
                        <th><i class=\"fas fa-ruler-combined\"></i> Luas (km²)</th>
                        <th><i class=\"fas fa-users\"></i> Jumlah Penduduk</th>
                        <th><i class=\"fas fa-longitude\"></i> Longitude</th>
                        <th><i class=\"fas fa-latitude\"></i> Latitude</th>
                        <th><i class=\"fas fa-cogs\"></i> Aksi</th>
                    </tr>";

            // Output data per baris
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["kecamatan"] . "</td>
                        <td>" . $row["luas"] . "</td>
                        <td>" . $row["jumlah_penduduk"] . "</td>
                        <td>" . $row["longitude"] . "</td>
                        <td>" . $row["latitude"] . "</td>
                        <td>
                            <a href='edit.php?id=" . $row["id"] . "' class='btn-edit'><i class='fas fa-edit'></i> Edit</a>
                            <a href='hapus.php?id=" . $row["id"] . "' class='btn-hapus'><i class='fas fa-trash'></i> Hapus</a>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Belum ada data yang dimasukkan.</p>";
        }
        $conn->close();

        ?>
        <div id="map"></div>
    </div>

    <script>
        var map = L.map('map').setView([-7.7956, 110.3695], 10);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        var data = <?php echo json_encode($data); ?>;

        var customIcon = L.divIcon({
            className: 'map-marker-icon',
            html: '<i class="fas fa-map-pin"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30]
        });

        data.forEach(function(row) {
            if (row.latitude && row.longitude) {
                L.marker([row.latitude, row.longitude], {icon: customIcon}).addTo(map)
                    .bindPopup('<b>' + row.kecamatan + '</b><br>Luas: ' + row.luas + ' km²<br>Jumlah Penduduk: ' + row.jumlah_penduduk);
            }
        });
    </script>
    <style>
        .map-marker-icon {
            color: #333;
            font-size: 24px;
        }
    </style>
</body>
</html>