@extends('layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
        <hr>
    </div><!-- End Page Title -->
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            @if (is_null($user->img_profile))
                                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            @else
                                <img src="{{ asset('storage/' . $user->img_profile) }}" alt="Profile" class="rounded-circle">
                            @endif
                            <h2>{{ $user->name }}</h2>
                            <h3>{{ $user->role->role_name }}</h3>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Change Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                {{-- alert --}}
                                @if (Auth::user()->role_id == 4)
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Menunggu promote admin, silahkan lengkapi data terlebih dahulu
                                    </div>
                                @endif
                                {{-- alert --}}
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle me-1"></i>
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle me-1"></i>
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Company</div>
                                        <div class="col-lg-9 col-md-8">Radar Bogor, Bogor</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Position</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->role->role_name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->address }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->phone_number }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="/update-profile/{{ $user->user_code }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('put')
                                        @csrf
                                        <div class="row mb-3">
                                            <input type="hidden" name="oldImage" value="{{ $user->img_profile }}">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                                Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                @if (is_null($user->img_profile))
                                                    <img src="assets/img/profile-img.jpg" alt="Profile">
                                                @else
                                                    <img src="{{ asset('storage/' . $user->img_profile) }}" alt="Profile">
                                                @endif
                                                <div class="pt-2">
                                                    <input type="file"
                                                        class="form-control-file @error('img_profile') is-invalid @enderror"
                                                        id="img_profile" name="img_profile">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name', $user->name) }}" required
                                                    autofocus>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="position" class="col-md-4 col-lg-3 col-form-label">position</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="position" type="text" class="form-control"
                                                    id="position" value="{{ Auth::user()->role->role_name }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    id="address" name="address"
                                                    value="{{ old('address', $user->address) }}" required autofocus>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="phone_number" class="col-md-4 col-lg-3 col-form-label">Phone
                                                Number</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="number"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    id="phone_number" name="phone_number" placeholder="Phone Number"
                                                    value="{{ old('phone_number', $user->phone_number) }}" required>
                                                @error('phone_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email"
                                                    value="{{ old('email', Auth::user()->email) }}" readonly>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    {{ __('Please confirm your password before continuing.') }}

                                    <form action="{{ route('update-password') }}" method="POST">
                                        @csrf

                                        <div class="row mb-3">
                                            <label for="oldPasswordInput" class="col-md-4 col-lg-3 col-form-label">Old
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="old_password" type="password"
                                                    class="form-control @error('old_password') is-invalid @enderror"
                                                    id="oldPasswordInput">
                                                @error('old_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPasswordInput" class="col-md-4 col-lg-3 col-form-label">New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="new_password" type="password"
                                                    class="form-control @error('new_password') is-invalid @enderror"
                                                    id="newPasswordInput">
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="new_password_confirmation" type="password"
                                                    class="form-control" id="confirmNewPasswordInput">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
    </section>
@endsection
