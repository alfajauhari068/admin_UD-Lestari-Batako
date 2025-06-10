<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>UD Lestari Batako</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  
  <link href="{{ asset('assets/Logo-LB.jpg') }}" rel="icon" />

  
  <link href="{{ asset('assets/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') }}" rel="stylesheet" />

  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@700;800&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
  
  <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa; /* Light background for modern look */
    }

    .navbar {
        background-color: #007bff; /* Primary color */
        border-radius: 0 0 15px 15px; /* Rounded bottom corners */
    }

    .navbar-brand {
        color: #fff !important; /* White brand color */
    }

    .navbar-nav .nav-link {
        color: #fff; /* White text color for links */
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #ffd700; /* Gold color on hover */
    }

    .btn-primary {
        border-radius: 20px; /* Rounded button */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    .contact-info {
        font-size: 0.9rem; /* Adjust font size for contact info */
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow">
  <a href="javascript:void(0);" class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center ms-2" onclick="history.back();" aria-label="Back" title="Go Back">
    <i class="bi bi-arrow-left" style="font-size: 20px;"></i>
  </a>
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
      <i class="bi bi-building"></i> UD Lestari Batako
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center contact-info">
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-geo-alt-fill me-2"></i> Jl. Raya Batako No. 123, Surabaya</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-telephone-fill me-2"></i> +62 815-5367-5279</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-envelope-fill me-2"></i> info@lestari-batako.com</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://facebook.com" target="_blank"><i class="bi bi-facebook me-2"></i> Facebook</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://instagram.com" target="_blank"><i class="bi bi-instagram me-2"></i> Instagram</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Your page content goes here -->
@yield('content')

<!-- Bootstrap JS and dependencies -->
<script src="{{ asset('/assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>