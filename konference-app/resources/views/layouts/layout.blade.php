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
    <nav class="navbar navbar-expand-lg navbar-light container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Conference System</a>
        
        <!-- Show "My Reservations" and "Timetable" buttons for authenticated users -->
        @auth
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary ml-2">My Reservations</a>
            <a href="{{ route('presentations.timetable') }}" class="btn btn-secondary ml-2">My Presentations Schedule</a>
            <a href="{{ route('presentations.attendeeSchedule') }}" class="btn btn-secondary ml-2">Attendee Schedule</a>
            <a href="{{ route('presentations.personalSchedule') }}" class="btn btn-secondary ml-2">My Personal Schedule</a>
        @endauth
        
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
            
                @auth
                    <li class="nav-item">
                        <span class="nav-link">Logged in: {{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth
            </ul>
        </div>
    </nav>
</header>

<main class="container-fluid my-4">
    <!-- Flash messages for success or error -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display all validation errors at the top -->
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <!-- Content of the page -->
    @yield('content')
</main>

<footer class="text-center mt-4">
    <p>&copy; {{ date('Y') }} Conference System. All rights reserved.</p>
</footer>

</body>
</html>
