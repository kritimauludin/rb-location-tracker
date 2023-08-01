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
                                        <th scope="col">Alamat</th>
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
                                                <td>{{ $distribution->customer->address }}</td>
                                                <td>{{ $distribution->total}}</td>
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
                                                        <a href="#" class="btn btn-outline-info" onclick="return confirm(`Proses distribusi {{ $distribution->distribution_code }}?`);">Proses</a>
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

    <script>
        function initAutocomplete() {
            const successCallback = (position) => {
                console.log(position);
            };

            const errorCallback = (error) => {
                console.log(error);
            };

            const currentPosition = navigator.geolocation.watchPosition(successCallback, errorCallback);

            console.log(currentPosition);
            // navigator.geolocation.clearWatch(currentPosition);
        }
    </script>
    @include('library.maps-api')
@endsection
