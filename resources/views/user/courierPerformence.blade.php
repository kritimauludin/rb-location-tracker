@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Performance Review</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                {{-- card filter --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pilih Range Tanggal</h5>
                        <div class="position-absolute end-0 top-0 p-3">
                            <a href="/courier/print-performence?courier_code={{ $courierData->user_code }}@if (isset($_GET['date_start'])) &date_start={{ $_GET['date_start'] . '&date_end=' . $_GET['date_end'] }} @endif"
                                target="_blank" class=" text-right btn btn-outline-primary d-inline">Export Now</a>
                        </div>

                        @if (isset($_GET['date_start']))
                            <h3 class="card-title">Filter kinerja kurir & Report Pengiriman
                                <strong>{{ $_GET['date_start'] . ' sampai ' . $_GET['date_end'] }} </strong></h3>
                        @else
                            <form action="/user/{{ $courierData->user_code }}">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="date_start" class="text-xs">Tanggal Mulai</label>
                                        <input type="date" name="date_start" id="date_start" required
                                            class="form-control" value="{{ old('date_start') }}">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="date_start" class="text-xs">Tanggal Akhir</label>
                                        <input type="date" name="date_end" id="date_end" required class="form-control"
                                            value="{{ old('date_end') }}">
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <button type="submit" class="btn btn-outline-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $courierData->user_code . ' - ' . $courierData->name }}</h5>

                        {{-- alert --}}
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Nama Pelanggan</th>
                                        <th scope="col">Jam Antar</th>
                                        <th scope="col">Jam Sampai</th>
                                        <th scope="col">Durasi Pengiriman</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Bukti Pengiriman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $noUrut = 1;
                                        $nowDate = \Carbon\Carbon::now();
                                    @endphp
                                    @for ($i = 0; $i < count($distributions); $i++)
                                        @foreach ($distributions[$i]->user_distribution as $distribution)
                                            @php
                                                if (is_null($distribution->process_at) || (is_null($distribution->received_at) && $nowDate->gt($distribution->created_at))) {
                                                    $startTime = 'Gagal Kirim';
                                                    $finishTime = 'Gagal Kirim';
                                                    $totalDuration = 'Gagal Kirim';
                                                } elseif (is_null($distribution->process_at) || is_null($distribution->received_at)) {
                                                    $startTime = 'Waiting Data';
                                                    $finishTime = 'Waiting Data';
                                                    $totalDuration = 'Waiting Data';
                                                } else {
                                                    $startTime = \Carbon\Carbon::parse($distribution->process_at);
                                                    $finishTime = \Carbon\Carbon::parse($distribution->received_at);
                                                    $totalDuration = $finishTime->diffInSeconds($startTime);
                                                }
                                            @endphp

                                            <tr>
                                                <th scope="row">{{ $noUrut++ }}</th>
                                                <td>{{ date('d-m-Y', strtotime($distribution->created_at)) }}</td>
                                                <td>{{ $distribution->customer->customer_name }}</td>
                                                @if (is_null($distribution->process_at) || is_null($distribution->received_at))
                                                    <td>{{ $startTime }}</td>
                                                    <td>{{ $finishTime }}</td>
                                                    <td>{{ $totalDuration }}</td>
                                                @else
                                                    <td>{{ date('H:i:s', strtotime($startTime)) }}</td>
                                                    <td>{{ date('H:i:s', strtotime($finishTime)) }}</td>
                                                    <td>{{ gmdate('H:i:s', $totalDuration) }}</td>
                                                @endif
                                                <td>
                                                    @if ($distribution->status == 200)
                                                        <span class="badge bg-success">selesai</span>
                                                    @elseif($distribution->status == 202 && $nowDate->gt($distribution->created_at))
                                                        <span class="badge bg-danger">gagal kirim</span>
                                                    @elseif($distribution->status == 202)
                                                        <span class="badge bg-primary">dibawa kurir</span>
                                                    @else
                                                        <span class="badge bg-warning">menuju lokasi</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (is_null($distribution->process_at) || (is_null($distribution->received_at) && $nowDate->gt($distribution->created_at)))
                                                        <a href="jaavascript:void(0)">-</a>
                                                    @else
                                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#bukti-kirim-modal"
                                                            onclick="stampPloating({{ '`' . $courierData->name . '`,' . $distribution->courier_last_stamp . ',`' . $distribution->customer->customer_name . '`,' . $distribution->customer->latitude . ',' . $distribution->customer->longitude }})">
                                                            Klik disini</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
        @include('layouts.credits')

        {{-- modal customer --}}
        <div class="modal fade" id="bukti-kirim-modal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Jarak stamp kurir ke pelanggan</h5> <br>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="reloadPage()"></button>
                    </div>
                    <div class="modal-body">
                        <!-- id for set map customer area -->
                        <div id="map" style="height: 400px; "></div>
                        @include('library.courier-stamp-ploating')
                    </div>
                </div>
            </div>
        </div><!-- End customer centered Modal-->
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script type="text/javascript">
        // create map
        const map = L.map("map", {
            center: this.center,
            zoom: 14,
            zoomAnimation: false,
            fadeAnimation: false,
            markerZoomAnimation: false,
            zoomAnimationThreshold: false,
            animate: false,
        }).setView([-6.6061381, 106.801851], 12);

        // create basemap
        const basemap = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            }
        );

        basemap.addTo(map);

        // add marker from realtime iot devices
        function addToMap(data) {
            L.marker([data.latitude ?? 0, data.longitude ?? 0])
                .addTo(map)
                .bindPopup(
                    `<b>${data.name}</b>` +
                    `<br>Jarak stamp kurir ke lokasi : ${data.distance} m`

                );
        }

        function stampPloating(courierName, courierStampLat, courierStampLng, customerName, customerLat, customerLng) {
            const data = [{
                    'name': 'Kurir ' + courierName,
                    'latitude': courierStampLat,
                    'longitude': courierStampLng,
                    'distance' : getDistanceBetween(courierStampLat, courierStampLng, customerLat, customerLng)
                },
                {
                    'name': customerName,
                    'latitude': customerLat,
                    'longitude': customerLng,
                    'distance' : getDistanceBetween(courierStampLat, courierStampLng, customerLat, customerLng)
                }
            ]

            for (var i = 0; i < data.length; i++) {
                addToMap(data[i]);
            }
        }

        function getDistanceBetween(lat1, lon1, lat2, lon2) {
            var R = 6371; // Radius of the earth in km
            var dLat = deg2rad(lat2-lat1);  // deg2rad below
            var dLon = deg2rad(lon2-lon1);
            var a =
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon/2) * Math.sin(dLon/2)
                ;
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var d = R * c;
            d = d * 1000 // Distance in m
            return Math.round(d, 2);
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180)
        }

        function reloadPage(){
            location.reload();
        }

    </script>
@endsection
