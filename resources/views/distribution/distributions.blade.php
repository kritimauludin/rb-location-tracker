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
                        <h5 class="card-title">Data Distribusi</h5>
                        <a href="/distribution/create" class="text-right position-absolute end-0 top-0 m-4 h3"> <i
                                class="bi bi-person-plus m-1"></i></a>

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
                                        <th scope="col">Kode Distribusi</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Nama Kurir</th>
                                        <th scope="col">Total Koran</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distributions as $distribution)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $distribution->distribution_code }}</td>
                                            <td>{{ $distribution->created_at }}</td>
                                            <td>{{ $distribution->courier->name }}</td>
                                            <td>
                                                {{ $distribution->total_newspaper}}
                                            </td>
                                            <td>
                                                <a href="/distribution/{{$distribution->distribution_code}}"> <i class="bi bi-eye m-1"></i></a>
                                                <a href="/distribution/{{$distribution->distribution_code}}/edit"> <i class="bi bi-pen m-1"></i></a>
                                                <form action="/distribution/{{ $distribution->distribution_code }}" method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="border-0 bg-transparant" style="background-color: transparent;"
                                                        onclick="return confirm(`Hapus distribusi {{ $distribution->distribution_code }}?`);"><i class="bi bi-trash text-danger m-1"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
