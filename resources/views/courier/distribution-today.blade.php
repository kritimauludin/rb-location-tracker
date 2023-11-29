@extends('layouts.app')

@section('content')
    <style>
        .card {
            flex-direction: row;
            background-color: #696969;
            border: 0;
            box-shadow: 0 7px 7px rgba(0, 0, 0, 0.18);
            margin: 1em auto;
        }

        .card.dark {
            color: #fff;
        }

        .card.card.bg-light-subtle .card-title {
            color: dimgrey;
        }

        .card img {
            max-width: 25%;
            margin: auto;
            padding: 0.5em;
            border-radius: 0.7em;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
        }

        .text-section {
            max-width: 60%;
        }

        .cta-section {
            max-width: 40%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        .cta-section .btn {
            padding: 0.3em 0.5em;
            /* color: #696969; */
        }

        .card.bg-light-subtle .cta-section .btn {
            background-color: #898989;
            border-color: #898989;
        }

        @media screen and (max-width: 475px) {
            .card {
                font-size: 0.9em;
            }
        }
    </style>
    <div class="pagetitle">
        <h1>Data Distribusi Hari Ini</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="container">
            <div class="row">
                @php
                    $index = 1;
                @endphp
                @for ($i = 0; $i < count($todayDistribution); $i++)
                    @foreach ($todayDistribution[$i]->user_distribution as $distribution)
                        <div class="col-lg-4">
                            <div class="card bg-primary-subtle mt-4">
                                <div class="card-body">
                                    <div class="text-section">
                                        <h5 class="card-title fw-bold">{{ $distribution->customer->customer_name }}</h5>
                                        <div class="d-inline" id="duration[{{ $loop->iteration - 1 }}]"></div>
                                        <div class="d-inline" id="distance[{{ $loop->iteration - 1 }}]"></div> |
                                            @if ($distribution->status == 200)
                                                <span class="badge bg-success">sampai</span>
                                            @elseif($distribution->status == 201)
                                                <span class="badge bg-warning">menuju lokasi</span>
                                            @else
                                                <span class="badge bg-primary">dibawa kurir</span>
                                            @endif
                                        <hr>
                                        <a target="blank" id="direction[{{ $loop->iteration - 1 }}]" class="mr-3"
                                            href="#"
                                            onclick="return confirm(`Alihkan ke maps untuk petunjuk kelokasi tersebut?`);">
                                            <i class="bi bi-compass h3 m-1"></i>
                                        </a>
                                    </div>
                                    <div class="cta-section">
                                        <div class="mt-3 fw-bold">{{ $distribution->total }} Koran</div>

                                        @if ($distribution->status == 201)
                                            <a id="finish[{{ $loop->iteration - 1 }}]"
                                                href="#"
                                                onclick="return confirm(`Distribusi ke {{ $distribution->customer->customer_name }} telah selesai?`);"
                                                class="btn btn-dark btn-sm">Finish</a>
                                        @elseif($distribution->status == 202)
                                            <a href="/distribution/update-status?id={{ $distribution->id }}&status=process"
                                                onclick="return confirm(`Proses distribusi ke {{ $distribution->customer->customer_name }}?`);"
                                                class="btn btn-dark btn-sm">Process</a>
                                        @else
                                            <a href="javascript:void(0)" class="btn btn-outline-dark btn-sm">Thank You</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endfor

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

                    for (const index in todayDistribution) {
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
                        if (todayDistribution[index].status != 200) {

                            // get distance matrix response
                            service.getDistanceMatrix(request).then((response) => {
                                // put response
                                document.getElementById("direction[" + index + "]").href =
                                    "https://www.google.com/maps/dir/?api=1&origin=" + courierLocation.lat + "," +
                                    courierLocation.lng + "&destination=" + customerLocation.lat + "," +
                                    customerLocation.lng + "&travelmode=driving&dir_action=navigate";

                                document.getElementById("finish[" + index + "]").href="/distribution/update-status?id="+todayDistribution[index].id+"&status=finish&locationStamp="+courierLocation.lat + ","+
                                    courierLocation.lng;
                                document.getElementById("distance[" + index + "]").innerText = response.rows[0]
                                    .elements[0].distance.text;
                                document.getElementById("duration[" + index + "]").innerText = response.rows[0]
                                    .elements[0].duration.text;
                            });
                        } else {
                            document.getElementById("direction[" + index + "]").href =
                                "https://www.google.com/maps/dir/?api=1&origin=" + courierLocation.lat + "," +
                                courierLocation.lng + "&destination=" + customerLocation.lat + "," + customerLocation.lng +
                                "&travelmode=driving&dir_action=navigate";
                            document.getElementById("distance[" + index + "]").innerText = 'Selesai';
                            document.getElementById("duration[" + index + "]").innerText = '';
                        }

                    }
                };

                const errorCallback = (error) => {
                    // console.log(error);
                };

                const currentPosition = navigator.geolocation.watchPosition(successCallback, errorCallback);

                // navigator.geolocation.clearWatch(currentPosition);


            }
        </script>
    @endif
    @include('library.maps-api')
@endsection
