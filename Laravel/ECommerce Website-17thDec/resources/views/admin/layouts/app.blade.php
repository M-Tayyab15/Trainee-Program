<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.header')
</head>

<body class="w3-light-grey">
    <div id="app">
        <div class="w3-container" style="display: flex;">
        @include('admin.layouts.sidebar')
            <div class="w3-container w3-margin-left" style="flex-grow: 1;">
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.footer')
</body>

</html>