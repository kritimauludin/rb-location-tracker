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
                        <h5 class="card-title">Data Pelanggan</h5>
                        <div class="position-absolute end-0 top-0 m-4 mb-2">
                            <a href="/customer/create" class="text-right h3"> <i
                                    class="bi bi-person-plus m-1"></i></a>
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
                                        <th scope="col">Kode Pelanggan</th>
                                        <th scope="col">Nama Pelanggan</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tgl. Join</th>
                                        <th scope="col">Tgl. Expire</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $customer->customer_code }}</td>
                                            <td>{{ $customer->customer_name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->join_date }}</td>
                                            <td>{{ $customer->expire_date }}</td>
                                            <td>{{ $customer->amount }}</td>
                                            <td>
                                                @if (now()->lt($customer->expire_date))
                                                    <span class="badge badge-sm bg-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-sm bg-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/customer/{{$customer->customer_code}}" <i class="bi bi-eye m-1"></i></a>
                                                <a href="/customer/{{$customer->customer_code}}/edit"> <i class="bi bi-pen m-1"></i></a>
                                                <form action="/customer/{{ $customer->customer_code }}" method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="border-0 bg-transparant" style="background-color: transparent;"
                                                        onclick="return confirm(`Hapus pelanggan {{ $customer->customer_code }}?`);"><i class="bi bi-trash text-danger m-1"></i></button>
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
