@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Distributions</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Distribusi Hari Ini</h5>

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
                                        <th scope="col">Edisi</th>
                                        <th scope="col">Nama Pelanggan</th>
                                        <th scope="col">Waktu Kelokasi</th>
                                        <th scope="col">Jarak Anda</th>
                                        <th scope="col">Total Koran</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @for ($i = 0; $i < count($todayDistribution); $i++)
                                        @foreach ($todayDistribution[$i]->user_distribution as $distribution)
                                            <tr>
                                                <th scope="row">{{ $index }}</th>
                                                <td>{{ date_format($todayDistribution[$i]->created_at, 'd-m-Y') }}</td>
                                                <td>{{ $distribution->customer->customer_name }}</td>
                                                <td><div class="d-inline" id="duration[{{$loop->iteration-1}}]"></div></td>
                                                <td><div class="d-inline" id="distance[{{$loop->iteration-1}}]"></div></td>
                                                <td>{{ $distribution->total }}</td>
                                                <td>
                                                    @if ($distribution->status == 200)
                                                        <span class="badge bg-success">sampai</span>
                                                    @elseif($distribution->status == 201)
                                                        <span class="badge bg-primary">menunggu</span>
                                                    @else
                                                        <span class="badge bg-warning">diperjalanan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($distribution->status == 200)
                                                        <span class="badge bg-success">sampai</span>
                                                    @elseif($distribution->status == 201)
                                                        <a href="#" class="btn btn-outline-info"
                                                            onclick="return confirm(`Proses distribusi {{ $distribution->distribution_code }}?`);">Proses</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php $index++; @endphp
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
    </section>

    {{-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script> --}}
    @if (count($todayDistribution) != 0)
    <script>
        var todayDistribution = <?php echo $todayDistribution[0]->user_distribution; ?>;
        function initAutocomplete() {
            const successCallback = (position) => {
                // initialize services
                const geocoder = new google.maps.Geocoder();
                const service = new google.maps.DistanceMatrixService();
                // build request
                const courierLocation = {
                    lat: parseFloat(position.coords.latitude),
                    lng: parseFloat(position.coords.longitude)
                };

                for(const index in todayDistribution){
                    const customerLocation = {
                        lat: parseFloat(todayDistribution[index].customer.latitude),
                        lng: parseFloat(todayDistribution[index].customer.longitude)
                    };

                    const request = {
                        origins: [courierLocation],
                        destinations: [customerLocation],
                        travelMode: google.maps.TravelMode.DRIVING,
                        unitSystem: google.maps.UnitSystem.METRIC,
                        avoidHighways: false,
                        avoidTolls: false,
                    };

                    // get distance matrix response
                    service.getDistanceMatrix(request).then((response) => {
                        // put response
                        console.log(response);
                        document.getElementById("distance["+index+"]").innerText = response.rows[0].elements[0].distance.text;
                        document.getElementById("duration["+index+"]").innerText = response.rows[0].elements[0].duration.text;
                    });


                }
            };

            const errorCallback = (error) => {
                // console.log(error);
            };

            const currentPosition = navigator.geolocation.watchPosition(successCallback, errorCallback);

            // console.log(currentPosition.latitude);
            // navigator.geolocation.clearWatch(currentPosition);


        }
    </script>
    @endif
    @include('library.maps-api')
@endsection
