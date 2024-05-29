<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - {{ config("app.name", "Laravel") }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
          rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    @vite("resources/lib/owlcarousel/assets/owl.carousel.min.css")
    @vite("resources/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css")

    <!-- Customized Bootstrap Stylesheet -->
    @vite("resources/css/bootstrap.min.css")
    @vite("resources/css/style.css")
    @vite("resources/js/app.ts")

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
</head>

<body>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
         class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    @yield("content")
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
@vite("resources/lib/chart/chart.min.js")
@vite("resources/lib/easing/easing.min.js")
@vite("resources/lib/waypoints/waypoints.min.js")
@vite("resources/lib/owlcarousel/owl.carousel.min.js")
@vite("resources/lib/tempusdominus/js/moment.min.js")
@vite("resources/lib/tempusdominus/js/moment-timezone.min.js")
@vite("resources/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js")

<!-- Template Javascript -->
@vite("resources/js/main.js")
</body>
