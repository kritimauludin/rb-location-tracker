@extends('layouts.app')

@section('content')

    <div class="pagetitle">
        <h1>Newspapers</h1>
        <hr>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ubah Data Koran</h5>

                        <!-- General Form Elements -->
                        <form action="/newspaper/{{$newspaper->newspaper_code}}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <input type="text" id="newspaper_code" name="newspaper_code"
                                            placeholder="Kode koran (auto)" value="{{ old('newspaper_code', $newspaper->newspaper_code) }}"
                                            readonly class="form-control @error('newspaper_code') is-invalid @enderror text-center" required>
                                        @error('newspaper_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" id="edition" name="edition"
                                            placeholder="Judul edisi koran"
                                            value="{{ old('edition', $newspaper->edition) }}" class="form-control @error('edition') is-invalid @enderror text-center"
                                            required autofocus>
                                        @error('edition')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="form-group mb-3">
                                        <textarea name="description" id="description" cols="100%" rows="10" class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Deskripsi Edisi" required>{{ old('description', $newspaper->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center mt-5">
                                    <button class="btn btn-outline-primary" type="submit">Kirim</button>
                                    <a href="/newspaper" class="btn btn-outline-danger">Kembali</a>
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
