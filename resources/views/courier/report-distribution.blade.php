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
                        <h5 class="card-title">Klik salah satu pilihan dibawah ini</h5>

                        <div class="m-5">
                            <a href="/distribution/report?type=daily" class="btn btn-outline-primary m-2" target="_blank">Rekap Hari Ini</a>
                            <a href="/distribution/report?type=weekly" class="btn btn-outline-primary m-2" target="_blank">Rekap Minggu Ini</a>
                            <a href="/distribution/report?type=monthly" class="btn btn-outline-primary m-2" target="_blank">Rekap Bulan Ini</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('layouts.credits')
    </section>
@endsection
