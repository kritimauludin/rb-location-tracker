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

                        <!-- General Form data -->
                        <form action="/user/{{ $user->user_code }}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" id="user_code" name="user_code"
                                            placeholder="Kode Pengguna (auto)"
                                            value="{{ old('user_code', $user->user_code) }}" readonly
                                            class="form-control  @error('user_code') is-invalid @enderror" required>
                                        @error('user_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" id="name" name="name" placeholder="Nama Pengguna"
                                            value="{{ old('name', $user->name) }}" autofocus
                                            class="form-control  @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" id="email" name="email" placeholder="Email Pengguna"
                                            value="{{ old('email', $user->email) }}"
                                            class="form-control @error('email') is-invalid @enderror" readonly required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group mb-3">
                                        <input type="number" id="phone_number" name="phone_number"
                                            placeholder="Nomor telepon Pengguna"
                                            value="{{ old('phone_number', $user->phone_number) }}"
                                            class="form-control @error('phone_number') is-invalid @enderror" required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <textarea name="address" id="address" cols="100%" class="form-control @error('address') is-invalid @enderror"
                                            rows="4" placeholder="Alamat">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if ($user->role_id == 4)
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="number" name="postal_code" id="postal_code"
                                                    class="form-control @error('postal_code') is-invalid @enderror mb-3"
                                                    min="5" {{ old('postal_code', $user->postal_code) }}
                                                    placeholder="area kerja ex:16112">
                                            </div>
                                            <div class="col-lg-7">
                                                <select name="role_id" id="role_id" class="form-control" required>
                                                    <option value="">Klik untuk memilih</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- jika status kurir --}}
                            @if ($user->role_id == 3)
                                <h5 class="card-title">Cakupan Pengiriman</h5>
                                <hr>
                                @foreach ($customerHandle as $customer)
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-2 text-center">
                                            <a class="btn btn-outline-danger" href="/unhandle-courier?customerCode={{$customer->customer_code }}" onclick="return confirm('Lepas cakupan {{$customer->customer_code }} ?')">Lepas Cakupan</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <input type="hidden" id="id[{{ $customer->id }}]"
                                                    name="id[{{ $customer->id }}]" value="{{ $customer->id }}">
                                                <input type="hidden" id="customer_code[{{ $customer->id }}]"
                                                    name="customer_code[{{ $customer->id }}]"
                                                    value="{{ $customer->customer_code }}">
                                                <input type="text" id="customer_name[{{ $customer->id }}]"
                                                    name="customer_name[{{ $customer->id }}]"
                                                    placeholder="Nama Pelanggan (auto)"
                                                    value="{{ old('customer_name[' . $customer->id . ']', $customer->customer_name) }}"
                                                    readonly
                                                    class="form-control  @error('customer_name[{{ $customer->id }}]') is-invalid @enderror text-center"
                                                    required>
                                                @error('customer_name[' . $customer->id . ']')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group mb-3">
                                                <input type="number" id="total[{{ $customer->id }}]"
                                                    name="total[{{ $customer->id }}]" placeholder="Total"
                                                    value="{{ old('total[' . $customer->id . ']', $customer->amount) }}"
                                                    class="form-control @error('total[{{ $customer->id }}]') is-invalid @enderror text-center total"
                                                    readonly required>
                                                @error('total[' . $customer->id . ']')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="button" class="btn btn-outline-primary"
                                            id="search-customer-button" data-bs-toggle="modal"
                                            data-bs-target="#customersmodal">Tambah Cakupan</button>
                                    </div>
                                </div>
                            @endif
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

        {{-- modal customer --}}

        @if ($user->role_id == 3)
            <div class="modal fade" id="customersmodal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Data Pelanggan</h5> <br>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>klik dibaris data untuk memilih pelanggan</p>
                            <div class="table-responsive">
                                <table class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode Pelanggan</th>
                                            <th scope="col">Nama Pelanggan</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr class="CustomerData" data-customer-code="{{ $customer->customer_code }}"
                                                class="CustomerData" data-customer-name="{{ $customer->customer_name }}"
                                                class="CustomerData" data-customer-amount="{{ $customer->amount }}">
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $customer->customer_code }}</td>
                                                <td>{{ $customer->customer_name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone_number }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End customer centered Modal-->
        @endif

        @include('layouts.credits')
    </section>

    <script>
        var courierCode = '<?= $user->user_code ?>';
        var searchCustomerButton = $('#search-customer-button');

        $("#role_id").on("change", function() {
            var postal_code = $("#postal_code").val()
            if (postal_code.length != 5) {
                alert('Kode pos harus 5 digit');
                $(this).prop('selectedIndex', 0);
            } else {
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

        // Modal customer
        $(document).on('click', '.CustomerData', function(e) {
            const customerCode = $(this).attr('data-customer-code');
            $.ajax({
                type: "GET",
                url: "/add-courier-handle?customerCode="+customerCode+"&courierCode="+courierCode,
                success: function(response) {
                    location.reload();
                }
            });
        });
    </script>
@endsection
