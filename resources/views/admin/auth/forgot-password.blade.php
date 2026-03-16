<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cargo.shweyokelayexpress.com/public/build/assets/app.css" />
    <link rel="stylesheet" href="https://cargo.shweyokelayexpress.com/public/build/assets/app2.css" />
    {{-- No app2.js: auth pages have no Livewire, app2.js would throw "Livewire is not defined" --}}
</head>

<body>
    <div class="container-fluid login-container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                    <div class="card w-75 shadow-lg">
                        <div class="card-header d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ public_asset('uploads/images/logo.png') }}" alt="Logo" class="img-fluid">
                            <h4 class="mt-2 text-center">Forgot Password</h4>
                            <p class="text-muted text-center mb-0">Enter your username to reset your password</p>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('send-reset-link') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label" for="name">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required autofocus 
                                           placeholder="Enter your username">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">We'll help you reset your password using your username.</small>
                                </div>

                                <div class="mb-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="btn btn-link">Back to Login</a>
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
