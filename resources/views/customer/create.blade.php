@extends('layouts.app')

@section('content')
    <script type="module" src="{{ asset('assets/js/search-map.js') }}"></script>

    <div class="pagetitle">
        <h1>Customers</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Pelanggan</h5>

                        <!-- General Form Elements -->
                        <form>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" id="customer_code" name="customer_code"
                                            @error('customer_code') is-invalid @enderror placeholder="Kode pelanggan (auto)"
                                            value="{{ old('customer_code') }}" readonly class="form-control">
                                        @error('customer_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" id="customer_name" name="customer_name"
                                            @error('customer_name') is-invalid @enderror placeholder="Nama pelanggan"
                                            value="{{ old('customer_name') }}" autofocus class="form-control">
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" id="email" name="email"
                                            @error('email') is-invalid @enderror placeholder="Email pelanggan"
                                            value="{{ old('email') }}" class="form-control">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="row mb-3">
                                            <label for="inputDate" class="col-sm-3 col-form-label">Tgl. Join</label>
                                            <div class="col-sm-9">
                                                <input type="date" id="join_date" name="join_date"
                                                    @error('join_date') is-invalid @enderror placeholder="Tgl Join"
                                                    value="{{ old('join_date') }}" class="form-control">
                                                @error('join_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="row mb-3">
                                            <label for="inputDate" class="col-sm-3 col-form-label">Tgl.
                                                Expire</label>
                                            <div class="col-sm-9">
                                                <input type="date" id="tgl_expire" name="tgl_expire"
                                                    @error('tgl_expire') is-invalid @enderror placeholder="Tgl Join"
                                                    value="{{ old('tgl_expire') }}" class="form-control">
                                                @error('tgl_expire')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <input id="search-address" style="width: 50%; margin-top: 10px;" class="form-control"
                                        type="text" placeholder="Tulis nama jalan / gedung / perumahan" required>
                                    <div id="map" style="height: 500px; border-radius: 25px;"></div>
                                    <script>

                                        //maps
                                        function initAutocomplete() {
                                            var map = new google.maps.Map(document.getElementById('map'), {
                                                center: {
                                                    lat: -6.595038,
                                                    lng: 106.816635
                                                },
                                                zoom: 13,
                                                mapTypeId: 'roadmap',
                                            });

                                            // Membuat Kotak pencarian terhubung dengan tampilan map
                                            var input = document.getElementById('search-address');
                                            var searchBox = new google.maps.places.SearchBox(input);
                                            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                                            map.addListener('bounds_changed', function() {
                                                searchBox.setBounds(map.getBounds());
                                            });

                                            var markers = [];
                                            // Mengaktifkan detail pada suatu tempat ketika pengguna
                                            // memilih salah satu dari daftar prediksi tempat
                                            searchBox.addListener('places_changed', function() {
                                                var places = searchBox.getPlaces();

                                                if (places.length == 0) {
                                                    return;
                                                }

                                                // menghilangkan marker tempat sebelumnya
                                                markers.forEach(function(marker) {
                                                    marker.setMap(null);
                                                });
                                                markers = [];

                                                // Untuk setiap tempat, dapatkan icon, nama dan tempat.
                                                var bounds = new google.maps.LatLngBounds();
                                                places.forEach(function(place) {
                                                    if (!place.geometry) {
                                                        console.log("Returned place contains no geometry");
                                                        return;
                                                    }
                                                    var icon = {
                                                        url: place.icon,
                                                        path: "M-1.547 12l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM0 0q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                                                        fillColor: "#000000",
                                                        fillOpacity: 0.6,
                                                        strokeWeight: 0,
                                                        rotation: 0,
                                                        scale: 2,
                                                        anchor: new google.maps.Point(0, 20),
                                                    };

                                                    // Membuat Marker untuk setiap tempat
                                                    markers.push(new google.maps.Marker({
                                                        map: map,
                                                        icon: icon,
                                                        title: place.name,
                                                        position: place.geometry.location
                                                    }));

                                                    if (place.geometry.viewport) {
                                                        bounds.union(place.geometry.viewport);
                                                    } else {
                                                        bounds.extend(place.geometry.location);
                                                    }

                                                    // console.log(place);
                                                    for (var i = 0; i < place.address_components.length; i++) {
                                                        for (var j = 0; j < place.address_components[i].types.length; j++) {
                                                            // set postal code
                                                            if (place.address_components[i].types[j] == "postal_code") {
                                                                let postal_code = place.address_components[i].long_name
                                                                $.ajax({
                                                                    type: 'GET',
                                                                    url: '/getnewcode?postal_code=' + postal_code,
                                                                    success: function(response) {
                                                                        var response = JSON.parse(response);
                                                                        $('#customer_code').val(response);
                                                                    }
                                                                });
                                                            }
                                                        }
                                                    }
                                                });
                                                map.fitBounds(bounds);
                                            });
                                        }
                                    </script>
                                    <script
                                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWz3moTrN7wAejsYRVJQVgZrRdlZU2WBU&libraries=places&callback=initAutocomplete"
                                        async defer></script>

                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-outline-primary" type="submit">Kirim</button>
                                    <a href="#" class="btn btn-outline-danger">Kembali</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>


        @include('layouts.credits')
    </section>
@endsection
