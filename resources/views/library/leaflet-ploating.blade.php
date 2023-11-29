<!--Script for get realtime data in firebase connection -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
<script type="module">
  // create map
  const map = L.map("map").setView([-6.6061381, 106.801851], 12);

  // create basemap
  const basemap = L.tileLayer(
    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }
  );

  basemap.addTo(map);

  // add bogor polygon
  const bogorGeojson = await fetch(
    "https://raw.githubusercontent.com/ocumpsdotcom/geojson/main/bogor.geojson"
  );
  const geojsonBody = await bogorGeojson.json();
  L.geoJson(geojsonBody).addTo(map);

  // Get a reference to the database service
//   const db = getDatabase(app);
//   const sensorRef = ref(db, "WEBGIS");
  const data = <?= json_encode($customers); ?>;
  // add marker from realtime iot devices
  function addToMap(data) {
    L.marker([data.latitude ?? 0, data.longitude ?? 0])
      .addTo(map)
      .bindPopup(
        `<b>${data.customer_name}</b>`
        + <?php if(Auth::check()) : ?>
            `<br>Tgl. Join: ${data.join_date}<br>Tgl. Expire: ${data.expire_date}<br>Terakhir Diperbaharui:<br>${data.updated_at}`
            <?php else :?>
            ``
          <?php endif;?>

      );
  }

    for (var i = 0; i < data.length; i++) {
      addToMap(data[i]);
    }
</script>
