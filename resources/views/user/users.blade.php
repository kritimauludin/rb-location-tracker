@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Users</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Pengguna</h5>
                        {{-- <a href="/customer/create" class="text-right position-absolute end-0 top-0 m-4 h3"> <i
                                class="bi bi-person-plus m-1"></i></a> --}}

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
                                        <th scope="col">Kode Pengguna</th>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tgl. Terdaftar</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $user->user_code }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                {{ $user->role->role_name }}
                                            </td>
                                            <td>
                                                <a href="/user/{{$user->id}}"> <i class="bi bi-eye m-1"></i></a>
                                                <a href="/user/{{$user->id}}/edit"> <i class="bi bi-pen m-1"></i></a>
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