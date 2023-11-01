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
                            <a href="/courier/print-performence?courier_code={{$courierData->user_code}}@if (isset($_GET['date_start']))&date_start={{$_GET['date_start'] . '&date_end='. $_GET['date_end']}}@endif"
                                target="_blank" class=" text-right btn btn-outline-primary d-inline">Export Now</a>
                        </div>

                        @if (isset($_GET['date_start']))
                            <h3 class="card-title">Filter kinerja kurir & Report Pengiriman <strong>{{$_GET['date_start'] . ' sampai '. $_GET['date_end']}} </strong></h3>
                        @else
                            <form action="/user/{{$courierData->user_code}}">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="date_start" class="text-xs">Tanggal Mulai</label>
                                        <input type="date" name="date_start" id="date_start" required class="form-control" value="{{old('date_start')}}">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="date_start" class="text-xs">Tanggal Akhir</label>
                                        <input type="date" name="date_end" id="date_end" required class="form-control" value="{{old('date_end')}}">
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
                        <h5 class="card-title">{{ $courierData->user_code. ' - '. $courierData->name}}</h5>

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
                                    @php
                                        $noUrut = 1;
                                        $nowDate = \Carbon\Carbon::now();
                                    @endphp
                                    @for ($i = 0; $i < count($distributions); $i++)
                                        @foreach ($distributions[$i]->user_distribution as $distribution)
                                            @php
                                                if (is_null($distribution->process_at) || is_null($distribution->received_at) && $nowDate->gt($distribution->created_at)){
                                                    $startTime = 'Gagal Kirim';
                                                    $finishTime = 'Gagal Kirim';
                                                    $totalDuration = 'Gagal Kirim';
                                                }else if(is_null($distribution->process_at) || is_null($distribution->received_at)) {
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
                                                <th scope="row">{{ $noUrut++; }}</th>
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
