<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Conference Management')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand" href="#">Conference System</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" >Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ">Register</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main class="container my-4">
    @yield('content')
</main>

<footer class="text-center mt-4">
    <p>&copy; {{ date('Y') }} Conference System. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>