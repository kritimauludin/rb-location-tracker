@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Performance Review</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $courierData->user_code. ' - '. $courierData->name}}</h5>
                        <div class="position-absolute end-0 top-0 p-3">
                            <a href="/customer/generate-report" target="_blank" class="text-right btn btn-outline-primary mb-2 h3">Generate Report</a>
                        </div>

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
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($distributions); $i++)
                                        @foreach ($distributions[$i]->user_distribution as $distribution)
                                            @php
                                                if (is_null($distribution->process_at) || is_null($distribution->received_at)) {
                                                    $startTime = 'Waiting Data';
                                                    $finishTime = 'Waiting Data';
                                                    $totalDuration = 'Waiting Data';
                                                } else{
                                                    $startTime = \Carbon\Carbon::parse($distribution->process_at);
                                                    $finishTime = \Carbon\Carbon::parse($distribution->received_at);
                                                    $totalDuration = $finishTime->diffInSeconds($startTime);
                                                }
                                            @endphp

                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
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
                                                    @elseif($distribution->status == 201)
                                                        <span class="badge bg-primary">dibawa kurir</span>
                                                    @else
                                                        <span class="badge bg-warning">menuju lokasi</span>
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
    </section>
@endsection
