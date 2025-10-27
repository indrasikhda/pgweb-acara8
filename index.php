<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(to right, #f5f5f5, #ffffff);
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
        }
        .container {
            width: 90%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.3);
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.1 );
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba( 255, 255, 255, 0.18 );
        }
        .btn-input {
            display: inline-block;
            background-color: rgba(0, 0, 0, 0.1);
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
            align-self: flex-start;
            border: 1px solid rgba(0, 0, 0, 0.2);
        }
        .btn-input:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #333;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        th {
            background-color: rgba(0, 0, 0, 0.1);
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.02);
        }
        tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
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

        echo "<a href='input/index.html' class='btn-input'>Input Data</a>";

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kecamatan</th>
                        <th>Luas (km²)</th>
                        <th>Jumlah Penduduk</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
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

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var data = <?php echo json_encode($data); ?>;

        data.forEach(function(row) {
            if (row.latitude && row.longitude) {
                L.marker([row.latitude, row.longitude]).addTo(map)
                    .bindPopup('<b>' + row.kecamatan + '</b><br>Luas: ' + row.luas + ' km²<br>Jumlah Penduduk: ' + row.jumlah_penduduk);
            }
        });
    </script>
</body>
</html>