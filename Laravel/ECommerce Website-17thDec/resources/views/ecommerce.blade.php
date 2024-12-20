@extends('layouts')
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            background-color: #f0f8ff;
            /* Alice Blue */
            color: #333;
        }

        h2 {
            margin-bottom: 30px;
            color: #007bff;
        }

        .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .carousel-inner {
            display: flex;
            align-items: center;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }

        .carousel-control-prev {
            margin-left: 10px;
        }

        .carousel-control-next {
            margin-right: 10px;
        }

        .carousel {
            margin-bottom: 40px;
        }

        .carousel-container {
            display: flex;
            flex-direction: column;
            /* Stack carousels vertically */
            gap: 20px;
            /* Space between carousels */
            margin-top: 30px;
            /* Adjust top margin */
        }

        .carousel-item-small {
            width: 100%;
            /* Ensure each small carousel takes full width */
        }

        .carousel-name {
            /* text-align: center; */
            font-size: 1.6rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .carousel-small {
            width: 100%;
            /* Ensure the carousel takes full width */
        }

        .carousel-small img {
            height: 150px;
            /* Set a fixed height for images */
            object-fit: cover;
            /* Keep aspect ratio */
        }

        .carousel-item-small .d-flex {
            display: flex;
            /* Use flexbox for horizontal layout */
            justify-content: space-between;
            /* Space out images evenly */
        }

        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: fill;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .btn-show-details {
            margin-top: 10px;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Optional: For better styling of anchor links */
        a {
            text-decoration: none;
        }

        /* Styling for category buttons */
        .btn-category {
            font-size: 1rem;
            font-weight: bold;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            border: 2px solid #007bff;
            transition: background-color 0.3s, transform 0.3s ease;
            text-decoration: none;
        }

        .btn-category:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .btn-category:focus {
            outline: none;
        }

        .btn-category:active {
            transform: translateY(2px);
        }

        .carousel-item img {
            width: 100%;
            height: 500px;
            /* Increased height for better visibility */
            transition: transform 0.5s ease-in-out;
            /* Smooth transition for zoom effect */
        }


        /* Fade-in effect for captions */
        .carousel-item.active .carousel-caption {
            opacity: 1;
        }



        /* Additional padding for carousel */
        .carousel-inner {
            padding: 10px 0;
        }

        /* Ensure category buttons look like navbar links */
        .navbar-btn {
            font-size: 1rem;
            font-weight: bold;
            background-color: transparent;
            color: white;
            border: none;
            padding: 8px 20px;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.3s ease;
            border-radius: 25px;
            text-decoration: none;
        }

        .navbar-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            /* Light hover effect */
            transform: translateY(-3px);
        }

        .navbar-btn:focus {
            outline: none;
        }

        .navbar-btn:active {
            transform: translateY(2px);
            /* Slight button press effect */
        }

        /* Make the main carousel full width */
        .carousel {
            width: 100%;
            max-width: 100%;
            margin-bottom: 40px;
        }

        /* Carousel Control buttons (Prev/Next) */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #333;
            /* Dark color for the icons */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            transition: background-color 0.3s ease;
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: #555;

        }

        /* Pagination Dots */
        .carousel-indicators button {
            background-color: #333;
            /* Dark color for the pagination dots */
            border-radius: 50%;
            width: 20px;
            height: 2px;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .carousel-indicators .active {
            background-color: #555;
            /* Lighter shade when the dot is active */
        }

        .carousel-indicators button:hover {
            background-color: #555;
            /* Hover effect for pagination dots */
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            height: 100%;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
        }

        .card-price {
            font-size: 1.1rem;
            font-weight: bold;
            color: green;
            margin-left: 10px;
        }

        .card-text {
            font-size: 0.9rem;
            color: #555;
            margin-top: 10px;
        }

        .btn-show-details {
            margin-top: auto;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @include('components/mcarousel')
    @include('components/hotcarousel')
    @include('components/othercarousel')
</body>

</html>
@endsection