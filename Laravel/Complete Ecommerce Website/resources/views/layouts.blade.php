<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ecommerce on Laravel</title>

    <link rel="icon" href="{{ asset('images/online-shopping.gif') }}" type="image/gif">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <!-- Header Start -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/Arsenal_FC.svg.png') }}" alt="Logo" class="d-inline-block align-top" style="width: 80px;">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#shop">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="{{ route('cart') }}" title="cart">
                                <i class="bi bi-cart me-2"></i>
                                <span class="badge bg-primary" id="cart-count">{{ $cartCount }}</span>
                            </a>
                        </li>



                        @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                        </li> -->
                        @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Header End -->

    <div class="container-fluid">
        @yield('content')
    </div>

    <!-- Footer Start -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <!-- Logo Section -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <a href="#" class="d-block mb-3">
                        <img src="{{ asset('images/Arsenal_FC.svg.png') }}" alt="Logo" class="img-fluid" style="width: 120px;">
                    </a>
                    <p>Leading sportswear brand offering top-quality products for athletes.</p>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-uppercase">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#shop" class="text-white">Shop</a></li>
                        <li><a href="#about" class="text-white">About Us</a></li>
                        <li><a href="#contact" class="text-white">Contact Us</a></li>
                        <li><a href="#faq" class="text-white">FAQ</a></li>
                    </ul>
                </div>

                <!-- Social Media Links -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-uppercase">Follow Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white"><i class="bi bi-facebook"></i> Facebook</a></li>
                        <li><a href="#" class="text-white"><i class="bi bi-twitter"></i> Twitter</a></li>
                        <li><a href="#" class="text-white"><i class="bi bi-instagram"></i> Instagram</a></li>
                        <li><a href="#" class="text-white"><i class="bi bi-youtube"></i> YouTube</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2024 MTM_AFC. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>


</html>
