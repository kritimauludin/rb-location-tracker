<!--Script for get realtime data in firebase connection -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.2.0/firebase-app.js";
  import {
    getDatabase,
    ref,
    set,
    onValue,
  } from "https://www.gstatic.com/firebasejs/9.2.0/firebase-database.js";

  // Your web app's Firebase configuration

  //new
  const firebaseConfig = {
    apiKey: "AIzaSyCsWbHlfkJ6EuB4jk6EPqaLsAAMlFDPVlc",
    authDomain: "prak-sig-lts.firebaseapp.com",
    databaseURL: "https://prak-sig-lts-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "prak-sig-lts",
    storageBucket: "prak-sig-lts.appspot.com",
    messagingSenderId: "959446042736",
    appId: "1:959446042736:web:c0302dbf5c9a00c4898cb5"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);

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
