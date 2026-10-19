<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="" viewport content="width-device-width, intial-scale=1.0">
    <title> @yield('title', 'Student Management')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
    @include('partials.header')
    <div class="page-wrapper">
        @include('partials.sidebar')
        <main class="main-content">
            @yield('content')
        </main>
        
    </div>
    @include('partials.footer')
</body>
</html>