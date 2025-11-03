<div id="map"></div>
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