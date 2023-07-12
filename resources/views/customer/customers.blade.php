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
                        <a href="/customer/create" class="text-right position-absolute end-0 top-0 m-4 h3"> <i
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
                                        <th scope="col">Kode Pelanggan</th>
                                        <th scope="col">Nama Pelanggan</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tgl. Join</th>
                                        <th scope="col">Tgl. Expire</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <th scope="row">{{ $customer->iteration + 1 }}</th>
                                            <td>{{ $customer->customer_code }}</td>
                                            <td>{{ $customer->customer_name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->join_date }}</td>
                                            <td>{{ $customer->expire_date }}</td>
                                            <td>
                                                @if (now()->lt($customer->expire_date))
                                                    <span class="badge badge-sm bg-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-sm bg-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href=""> <i class="bi bi-eye m-1"></i></a>
                                                <a href=""> <i class="bi bi-pen m-1"></i></a>
                                                <a href=""> <i class="bi bi-trash text-danger m-1"></i></a>
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
