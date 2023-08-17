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
                        <h5 class="card-title">Ubah Alokasi Distribusi Kurir</h5>

                        <!-- General Form Elements -->
                        <form action="/distribution/{{$distribution->distribution_code}}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group mb-3">
                                        <input type="hidden" name="admin_code" id="admin_code" value="{{$distribution->admin_code}}">
                                        <input type="text" id="distribution_code" name="distribution_code"
                                            placeholder="Kode distribusi (auto)" value="{{ old('distribution_code', $distribution->distribution_code) }}"
                                            readonly class="form-control @error('distribution_code') is-invalid @enderror text-center" required>
                                        @error('distribution_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-3">
                                        <input type="text" id="created_at" name="created_at"
                                            value="{{ old('created_at', $distribution->created_at ) }}" class="form-control  @error('created_at') is-invalid @enderror text-center"
                                            required>
                                        @error('created_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-3">
                                        <input type="text" id="total_newspaper" name="total_newspaper"
                                            placeholder="Total Koran (auto)"
                                            value="{{ old('total_newspaper', $distribution->total_newspaper ) }}" readonly class="form-control @error('total_newspaper') is-invalid @enderror text-center"
                                            required>
                                        @error('total_newspaper')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="hidden" id="courier_code" name="courier_code" value="{{ old('courier_code', $distribution->courier->code ) }}">
                                        <input type="text" id="courier_name" name="courier_name"
                                             placeholder="Nama Kurir (auto)"
                                            value="{{ old('courier_name', $distribution->courier->name ) }}" readonly class="form-control @error('courier_name') is-invalid @enderror text-center"
                                            required>
                                        @error('courier_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#couriermodal">Ganti Kurir</button>
                                </div>
                            </div>
                            @foreach ($distribution->user_distribution as $distribution)
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-2 text-center">
                                        <button type="button" class="btn btn-outline-primary" onclick="changeCustomer({{$loop->iteration}})" style="display: block;">Ganti Pelanggan</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <input type="hidden" id="customer_code[{{$loop->iteration}}]" name="customer_code[{{$loop->iteration}}]"  value="{{$distribution->customer_code}}">
                                            <input type="text" id="customer_name[{{$loop->iteration}}]" name="customer_name[{{$loop->iteration}}]"
                                                placeholder="Nama Pelanggan (auto)"
                                                value="{{ old('customer_name['.$loop->iteration.']', $distribution->customer->customer_name) }}" readonly
                                                class="form-control  @error('customer_name[{{$loop->iteration}}]') is-invalid @enderror text-center" required>
                                            @error('customer_name['.$loop->iteration.']')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group mb-3">
                                            <input type="number" id="total['{{$loop->iteration}}']" name="total['{{$loop->iteration}}']" placeholder="Total"
                                                value="{{ old('total['.$loop->iteration.']', $distribution->total) }}" class="form-control @error('total[{{$loop->iteration}}]') is-invalid @enderror text-center total" readonly required>
                                            @error('total['.$loop->iteration.']')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-outline-primary" type="submit">Kirim</button>
                                    <a href="/distribution" class="btn btn-outline-danger">Kembali</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>


        @include('layouts.credits')
    </section>
    {{-- modal area --}}

    {{-- modal courier --}}
    <div class="modal fade" id="couriermodal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Kurir</h5> <br>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>klik dibaris data untuk memilih kurir</p>
                    <div class="table-responsive">
                        <table class="table table-hover datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Kurir</th>
                                    <th scope="col">Nama Kurir</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($couriers as $courier)
                                    <tr class="CourierData" data-courier-code="{{ $courier->user_code }}"
                                        class="CourierData" data-courier-name="{{ $courier->name }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $courier->user_code }}</td>
                                        <td>{{ $courier->name }}</td>
                                        <td>{{ $courier->email }}</td>
                                        <td>{{ $courier->phone_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div><!-- End courier centered Modal-->

    {{-- modal customer --}}
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
                        <table class="table table-hover">
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
                                        class="CustomerData" data-customer-name="{{ $customer->customer_name }}">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div><!-- End customer centered Modal-->

    {{-- js function --}}
    <script type="text/javascript">
        var searchCustomerButton = $('#search-customer-button');
        var customerIndex = 0;
        const searchParams = new URLSeacrhParams(window.location.search);


        $(document).on('keyup', ".total",function () {
            var totalNewspaper = 0;

            $('.total').each(function(){
                totalNewspaper += parseFloat($(this).val());
            })

            $("#total_newspaper").val(totalNewspaper);
        })

        // Modal courir
        $(document).on('click', '.CourierData', function(e) {
            document.getElementById("courier_code").value = $(this).attr('data-courier-code');
            document.getElementById("courier_name").value = $(this).attr('data-courier-name');
            $('#couriermodal').modal('hide');
        });


        function changeCustomer(index) {
			$('#customersmodal').modal('show');
			$(".CustomerData").attr('data-customer-id', index);

			$(document).on('click', '.CustomerData', function(e) {
				document.getElementById("customer_code[" + $(this).attr('data-customer-id') + "]").value = $(this).attr('data-customer-code');
                document.getElementById("customer_name[" + $(this).attr('data-customer-id') + "]").value = $(this).attr('data-customer-name');
				$('#customersmodal').modal('hide');
			});
		};
    </script>
@endsection
