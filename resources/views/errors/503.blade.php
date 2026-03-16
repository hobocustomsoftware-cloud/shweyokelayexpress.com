<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>503 | {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/images/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('storage/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('storage/images/apple-touch-icon.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@200;600;700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap"
        rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="http://monabeautyproducts.com/public/build/assets/app.css" />
    <link rel="stylesheet" href="http://monabeautyproducts.com/public/build/assets/app2.css" />
    <script type="module" src="http://monabeautyproducts.com/public/build/assets/app2.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .maintenance-img {
            max-width: 30%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container-fluid my-5">
        <div class="container mx-auto">
            <div class="card shadow p-4">
                <img src="{{ public_asset('uploads/images/maintenance.svg') }}" alt="Maintenance Illustration"
                    class="maintenance-img mb-4">
                <div class="card-body">
                    <h1 class="card-title mb-3">We'll Be Back Soon</h1>
                    <p class="card-text text-muted">
                        Sorry for the inconvenience. We're performing scheduled maintenance.<br>
                        We’ll be back shortly. Thank you for your patience.
                    </p>
                    <hr>
                    <p class="small text-muted mb-0">— {{ config('app.name') }} Team</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
