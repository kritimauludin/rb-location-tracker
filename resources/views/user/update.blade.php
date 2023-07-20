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
                        <h5 class="card-title">Ubah Data Pengguna</h5>

                        <!-- General Form Elements -->
                        <form action="/user/{{$user->id}}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" id="user_code" name="user_code"
                                            @error('user_code') is-invalid @enderror placeholder="Kode Pengguna (auto)"
                                            value="{{ old('user_code', $user->user_code) }}" readonly
                                            class="form-control" required>
                                        @error('user_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" id="name" name="name"
                                            @error('name') is-invalid @enderror placeholder="Nama Pengguna"
                                            value="{{ old('name', $user->name) }}" autofocus
                                            class="form-control" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" id="email" name="email"
                                            @error('email') is-invalid @enderror placeholder="Email Pengguna"
                                            value="{{ old('email', $user->email) }}" class="form-control" readonly required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group mb-3">
                                        <input type="number" id="phone_number" name="phone_number"
                                            @error('phone_number') is-invalid @enderror
                                            placeholder="Nomor telepon Pengguna"
                                            value="{{ old('phone_number', $user->phone_number) }}" class="form-control"
                                            required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <textarea name="address" id="address" cols="100%" class="form-control" rows="4" placeholder="Alamat">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if ($user->role_id == 4)
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <input type="number" name="postal_code" id="postal_code" class="form-control mb-3" min="5" placeholder="area kerja ex:16112">
                                        </div>
                                        <div class="col-lg-7">
                                            <select name="role_id" id="role_id" class="form-control" required>
                                                <option value="">Klik untuk memilih</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-outline-primary" type="submit">Kirim</button>
                                    <a href="/user" class="btn btn-outline-danger">Kembali</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>


        @include('layouts.credits')
    </section>

    <script>
        $("#role_id").on("change", function() {
            var postal_code = $("#postal_code").val()
            if(postal_code.length != 5){
                alert('Kode pos harus 5 digit');
                $(this).prop('selectedIndex',0);
            }else{
                if ($(this).find(":selected").val() == "2") {
                    $.ajax({
                        type: "GET",
                        url: "/getnewcode?postal_code=" + postal_code + "&type=admin",
                        success: function(response) {
                            var response = JSON.parse(response);
                            $("#user_code").val(response);
                        }
                    });
                } else if ($(this).find(":selected").val() == "3") {
                    $.ajax({
                        type: "GET",
                        url: "/getnewcode?postal_code=" + postal_code + "&type=courier",
                        success: function(response) {
                            var response = JSON.parse(response);
                            $("#user_code").val(response);
                        }
                    });
                }
            }
        })
    </script>
@endsection
