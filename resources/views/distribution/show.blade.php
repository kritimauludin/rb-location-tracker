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
                        <h5 class="card-title">Alokasi Distribusi - {{ $distribution->distribution_code }} </h5>

                        <h6>Data distribusi</h6>
                        <hr>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="distribution_code" name="distribution_code"
                                        placeholder="Kode distribusi"
                                        class="form-control text-center" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="created_at" name="created_at"
                                       placeholder="Tgl distribusi" class="form-control  text-center" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="total_newspaper" name="total_newspaper"
                                        placeholder="Total koran dibawa"
                                        class="form-control text-center" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="distribution_code" name="distribution_code"
                                        placeholder="Kode distribusi (auto)" value="{{ $distribution->distribution_code }}"
                                        class="form-control text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="created_at" name="created_at"
                                        value="{{ $distribution->created_at }}" class="form-control  text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="total_newspaper" name="total_newspaper"
                                        placeholder="Total Koran (auto)" value="{{ $distribution->total_newspaper }}"
                                        class="form-control text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <h6>Data pengirim / kurir</h6>
                        <hr>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier->user_code" name="courier->user_code"
                                        placeholder="Kode kurir" class="form-control text-center" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier_name" name="courier_name" placeholder="Nama Kurir"
                                        class="form-control text-center" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier->user_code" name="courier->user_code"
                                        placeholder="No hp kurir " class="form-control text-center" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier->user_code" name="courier->user_code"
                                        placeholder="Email kurir " class="form-control text-center" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier->user_code" name="courier->user_code"
                                        placeholder="Kode kurir (auto)" value="{{ $distribution->courier->user_code }}"
                                        class="form-control text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier_name" name="courier_name"
                                        placeholder="Nama Kurir (auto)" value="{{ $distribution->courier->name }}"
                                        class="form-control @error('courier_name') is-invalid @enderror text-center"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier->user_code" name="courier->user_code"
                                        placeholder="no hp kurir (auto)" value="{{ $distribution->courier->phone_number }}"
                                        class="form-control text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <input type="text" id="courier->user_code" name="courier->user_code"
                                        placeholder="email kurir (auto)" value="{{ $distribution->courier->email }}"
                                        class="form-control text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h6>Data Pelanggan</h6>
                            <hr>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group mb-3">
                                        <input type="text" id="customer_code" name="customer_code"
                                            placeholder="Kode pelanggan" class="form-control text-center" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" id="courier_name" name="courier_name"
                                            placeholder="Nama pelanggan" class="form-control text-center" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-3">
                                        <input type="text" id="customer->user_code" name="customer->user_code"
                                            placeholder="No hp pelanggan" class="form-control text-center" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <input type="text" id="customer->email" name="customer->email"
                                            placeholder="Email pelanggan" class="form-control text-center" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="form-group mb-3">
                                        <input type="text" id="total" name="total" placeholder="Total"
                                            class="form-control text-center text-success" disabled>
                                    </div>
                                </div>
                            </div>
                            @foreach ($distribution->user_distribution as $distribution)
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group mb-3">
                                            <input type="text" id="customer_code" name="customer_code"
                                                placeholder="Kode customer (auto)"
                                                value="{{ $distribution->customer_code }}"
                                                class="form-control text-center" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <input type="text" id="courier_name" name="courier_name"
                                                placeholder="Nama pelanggan (auto)"
                                                value="{{ $distribution->customer->customer_name }}"
                                                class="form-control text-center" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group mb-3">
                                            <input type="text" id="customer->user_code" name="customer->user_code"
                                                placeholder="no hp kurir (auto)"
                                                value="{{ $distribution->customer->phone_number }}"
                                                class="form-control text-center" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group mb-3">
                                            <input type="text" id="customer->email" name="customer->email"
                                                placeholder="no hp kurir (auto)"
                                                value="{{ $distribution->customer->email }}"
                                                class="form-control text-center" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group mb-3">
                                            <input type="text" id="total" name="total"
                                                placeholder="email kurir (auto)" value="{{ $distribution->total }}"
                                                class="form-control text-center" readonly>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-12 text-center">
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
@endsection
