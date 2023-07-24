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
                        <h5 class="card-title">Alokasi Distribusi Kurir</h5>

                        <!-- General Form Elements -->
                        <form action="/distribution" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group mb-3">
                                        <input type="hidden" name="admin_code" id="admin_code" value="{{Auth::user()->user_code}}">
                                        <input type="text" id="distribution_code" name="distribution_code"
                                            placeholder="Kode distribusi (auto)" value="{{ old('distribution_code') }}"
                                            readonly class="form-control @error('distribution_code') is-invalid @enderror text-center" required>
                                        @error('distribution_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-3">
                                        <input type="text" id="created_at" name="created_at"
                                            value="{{ old('created_at', date('d-m-Y')) }}" class="form-control  @error('created_at') is-invalid @enderror text-center"
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
                                            value="{{ old('total_newspaper') }}" readonly class="form-control @error('total_newspaper') is-invalid @enderror text-center"
                                            required>
                                        @error('total_newspaper')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="hidden" id="courier_code" name="courier_code">
                                        <input type="text" id="courier_name" name="courier_name"
                                             placeholder="Nama Kurir (auto)"
                                            value="{{ old('courier_name') }}" readonly class="form-control @error('courier_name') is-invalid @enderror text-center"
                                            required>
                                        @error('courier_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#couriermodal">Cari Kurir</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-2 text-center">
                                    <button type="button" class="btn btn-outline-primary" id="search-customer-button" data-bs-toggle="modal"
                                        data-bs-target="#customersmodal" style="display: block;">Cari Pelanggan</button>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group mb-3">
                                                <input type="hidden" id="customer_code[0]" name="customer_code[0]">
                                                <input type="text" id="customer_name[0]" name="customer_name[0]"
                                                    placeholder="Nama Pelanggan (auto)"
                                                    value="{{ old('customer_name[0]') }}" readonly
                                                    class="form-control  @error('customer_name[0]') is-invalid @enderror text-center" required>
                                                @error('customer_name[0]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <input type="number" id="total[0]" name="total[0]" placeholder="Total"
                                                    value="{{ old('total[0]') }}" class="form-control @error('total[0]') is-invalid @enderror text-center total" required>
                                                @error('total[0]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-customer"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <a href="javascript:void(0);" id="add-field-customer" class="h3" style="display: none;"><i
                                            class="bi bi-clipboard-plus"></i></a>
                                </div>
                            </div>
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
        var addButton = $('#add-field-customer');
        var searchCustomerButton = $('#search-customer-button');
        var field = $('.field-customer');
        var customerIndex = 0;
        var fieldHtml = '';

        $.ajax({
            type: 'GET',
            url: '/getnewcode?type=distribution',
            success: function(response) {
                var response = JSON.parse(response);
                $('#distribution_code').val(response);
            }
        });
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

        // Modal customer
        $(document).on('click', '.CustomerData', function(e) {
                document.getElementById("customer_code[" + customerIndex + "]").value = $(this).attr('data-customer-code');
                document.getElementById("customer_name[" + customerIndex + "]").value = $(this).attr('data-customer-name');
                customerIndex += 1;
                fieldHtml =
                `<div class="row">
                    <div class="col-lg-8">
                        <div class="form-group mb-3">
                            <input type="hidden" id="customer_code[` + customerIndex + `]" name="customer_code[` +
                    customerIndex + `]">
                            <input type="text" id="customer_name[` + customerIndex + `]" name="customer_name[` +
                    customerIndex + `]"
                                @error('customer_name[`+customerIndex+`]') is-invalid @enderror placeholder="Nama Pelanggan (auto)"
                                    value="{{ old('customer_name[`+customerIndex+`]') }}" readonly class="form-control text-center" required>
                                @error('customer_name[`+customerIndex+`]')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <input type="number" id="total[` + customerIndex + `]" name="total[` + customerIndex + `]"
                                @error('total[`+customerIndex+`]') is-invalid @enderror placeholder="Total"
                                value="{{ old('total[`+customerIndex+`]') }}" class="form-control text-center total" required>
                            @error('total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>`;
            searchCustomerButton.removeAttr('style').hide();
            addButton.show();
            $('#customersmodal').modal('hide');
        });

        $(addButton).click(function() {
                searchCustomerButton.show();
                addButton.removeAttr("style").hide();
                $(field).append(fieldHtml);
        });
    </script>
@endsection
