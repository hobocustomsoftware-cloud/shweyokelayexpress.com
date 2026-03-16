<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password</title>
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
                            <h4 class="mt-2 text-center">Reset Password</h4>
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

                            <form action="{{ route('reset-password') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="password">New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password_confirmation">Confirm New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
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

    <script>
        // Password confirmation validation
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.querySelector('input[name="password"]');
            const passwordConfirmation = document.querySelector('input[name="password_confirmation"]');
            const form = document.querySelector('form');

            function validatePasswordMatch() {
                if (password.value !== passwordConfirmation.value) {
                    passwordConfirmation.setCustomValidity('Passwords do not match');
                    passwordConfirmation.classList.add('is-invalid');
                } else {
                    passwordConfirmation.setCustomValidity('');
                    passwordConfirmation.classList.remove('is-invalid');
                }
            }

            password.addEventListener('input', validatePasswordMatch);
            passwordConfirmation.addEventListener('input', validatePasswordMatch);

            form.addEventListener('submit', function(e) {
                validatePasswordMatch();
                if (!passwordConfirmation.checkValidity()) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>