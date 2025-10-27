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
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            color: #fff;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
        }
        h2 {
            color: #fff;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-input {
            display: inline-block;
            background-color: rgba(0, 255, 255, 0.2);
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            align-self: flex-start;
            border: 1px solid rgba(0, 255, 255, 0.3);
            font-weight: 400;
        }
        .btn-input:hover {
            background-color: rgba(0, 255, 255, 0.4);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        th {
            background-color: rgba(0, 255, 255, 0.1);
            font-weight: 600;
        }
        tr {
            transition: background-color 0.3s ease;
        }
        tr:hover {
            background-color: rgba(0, 255, 255, 0.05);
        }
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-satellite-dish"></i> Data Kecamatan</h2>
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
                        <th><i class=\"fas fa-ruler-combined\"></i> Luas (km²)<\/th>
                        <th><i class=\"fas fa-users\"></i> Jumlah Penduduk</th>
                        <th><i class=\"fas fa-longitude\"></i> Longitude</th>
                        <th><i class=\"fas fa-latitude\"></i> Latitude</th>
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

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        var data = <?php echo json_encode($data); ?>;

        var futuristicIcon = L.divIcon({
            className: 'futuristic-icon',
            html: '<i class="fas fa-map-pin"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30]
        });

        data.forEach(function(row) {
            if (row.latitude && row.longitude) {
                L.marker([row.latitude, row.longitude], {icon: futuristicIcon}).addTo(map)
                    .bindPopup('<b>' + row.kecamatan + '</b><br>Luas: ' + row.luas + ' km²<br>Jumlah Penduduk: ' + row.jumlah_penduduk);
            }
        });
    </script>
    <style>
        .futuristic-icon {
            color: #00ffff;
            font-size: 24px;
            text-shadow: 0 0 10px #00ffff;
        }
    </style>
</body>
</html>