<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="stylesheet" href="https://cargo.shweyokelayexpress.com/public/build/assets/app.css" />
    <link rel="stylesheet" href="https://cargo.shweyokelayexpress.com/public/build/assets/app2.css" />
    {{-- Do not load app2.js here: login has no Livewire, and app2.js expects Livewire → would throw "Livewire is not defined" --}}
</head>

<body>
    <div class="container-fluid login-container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                    <div class="card w-75 shadow-lg">
                        <div class="card-header d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ public_asset('uploads/images/logo.png') }}" alt="Logo" class="img-fluid">
                            <!-- <h3>Admin Login</h3> -->
                        </div>
                        <div class="card-body">
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                    <a href="{{ route('forgot-password') }}" class="btn btn-link w-100">Forgot Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
