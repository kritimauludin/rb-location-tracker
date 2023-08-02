@extends('layouts.app')

@section('content')

    <div class="pagetitle">
        <h1>Customers</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ubah Data Pelanggan</h5>

                        <!-- General Form Elements -->
                        <form action="/customer/{{$customer->customer_code}}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group mb-3">
                                        <input type="text" id="customer_code" name="customer_code"
                                            @error('customer_code') is-invalid @enderror placeholder="Kode pelanggan (auto)"
                                            value="{{ old('customer_code', $customer->customer_code) }}" readonly
                                            class="form-control" required>
                                        @error('customer_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <input type="hidden" id="newspaper_code" name="newspaper_code" value="{{$customer->newspaper_code}}">
                                                <input type="text" id="edition" name="edition"
                                                     placeholder="Jenis koran (auto)"
                                                    value="{{ old('edition', ) }}" class="form-control @error('edition') is-invalid @enderror" readonly required>
                                                @error('edition')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mb-3">
                                                <input type="number" id="amount" name="amount"
                                                     placeholder="Jumlah"
                                                    value="{{ old('amount', $customer->amount) }}" class="form-control @error('amount') is-invalid @enderror" required>
                                                @error('amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#newspapermodal">Cari Koran</button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" id="customer_name" name="customer_name"
                                            @error('customer_name') is-invalid @enderror placeholder="Nama pelanggan"
                                            value="{{ old('customer_name', $customer->customer_name) }}" autofocus
                                            class="form-control" required>
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" id="email" name="email"
                                            @error('email') is-invalid @enderror placeholder="Email pelanggan"
                                            value="{{ old('email', $customer->email) }}" class="form-control" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="number" id="phone_number" name="phone_number"
                                            @error('phone_number') is-invalid @enderror
                                            placeholder="Nomor telepon pelanggan"
                                            value="{{ old('phone_number', $customer->phone_number) }}" class="form-control"
                                            required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="row mb-3">
                                            <label for="inputDate" class="col-sm-3 col-form-label">Tgl. Join</label>
                                            <div class="col-sm-9">
                                                <input type="date" id="join_date" name="join_date"
                                                    @error('join_date') is-invalid @enderror placeholder="Tgl Join"
                                                    value="{{ old('join_date', $customer->join_date) }}"
                                                    class="form-control" required>
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
                                                <input type="date" id="expire_date" name="expire_date"
                                                    @error('expire_date') is-invalid @enderror placeholder="Tgl Join"
                                                    value="{{ old('expire_date', $customer->expire_date) }}"
                                                    class="form-control" required>
                                                @error('expire_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" id="latitude" name="latitude"
                                            @error('latitude') is-invalid @enderror placeholder="Titik latitude (auto)"
                                            value="{{ old('latitude', $customer->latitude) }}" readonly
                                            class="form-control" required>
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" id="longitude" name="longitude"
                                            @error('longitude') is-invalid @enderror placeholder="Titik longitude (auto)"
                                            value="{{ old('longitude', $customer->longitude) }}" readonly
                                            class="form-control" required>
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input id="address" name="address" style="width: 50%; margin-top: 10px;"
                                        class="form-control" type="text"
                                        placeholder="Tulis nama jalan / gedung / perumahan"
                                        value="{{ old('address', $customer->address) }}" required>
                                    <div id="map" style="height: 500px; border-radius: 25px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-outline-primary" type="submit">Kirim</button>
                                    <a href="/customer" class="btn btn-outline-danger">Kembali</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>


        @include('layouts.credits')
    </section>
    <script>

        //maps binder function
        function initAutocomplete() {
            var markers = [];
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 18,
                mapTypeId: 'roadmap',

            });

            const iconCurrentPosition = {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                scaledSize: new google.maps.Size(80, 80),
            }
            //set current location
            var marker = new google.maps.Marker({
                icon: iconCurrentPosition,
                position: new google.maps.LatLng(<?= $customer->latitude . ',' . $customer->longitude ?>),
                map: map
            });
            markers.push(marker);
            map.setCenter(new google.maps.LatLng(<?= $customer->latitude . ',' . $customer->longitude ?>));

            // Membuat Kotak pencarian terhubung dengan tampilan map
            var input = document.getElementById('address');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

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
                    $('#latitude').val(place.geometry.location.lat());
                    $('#longitude').val(place.geometry.location.lng());
                });
                map.fitBounds(bounds);
            });
        }
    </script>
    @include('library.maps-api')
@endsection
