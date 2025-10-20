<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | MyApp</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <a href="{{ route('staff.dashboard') }}" class="brand">Education
        </a>
        <nav class="nav flex-column mt-3">
            <a href="{{ route('staff.dashboard') }}" class="nav-link"><i class="bi bi-house-door"></i><span class="nav-text">Dashboard</span></a>
            <a href="{{ route('staff.profile') }}" class="nav-link"><i class="bi bi-people"></i><span class="nav-text">Profile</span></a>
            <a href="#" class="nav-link"><i class="bi bi-gear"></i><span class="nav-text">Settings</span></a>
            <form action="{{ route('logout') }}" method="POST" class="mt-auto p-3">
                @csrf
                <button type="submit" class="btn btn-link nav-link text-danger p-0">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Navbar -->
    <nav id="topNavbar" class="navbar navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <span id="toggleSidebar" class="toggle-btn">
                <i class="bi bi-list fs-3"></i>
            </span>
            <div class="ms-auto">
                <button class="btn btn-outline-primary">
                    <i class="bi bi-bell"></i> Notifications
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="content">
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const navbar = document.getElementById('topNavbar');
        const toggleBtn = document.getElementById('toggleSidebar');

        // Load previous state
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
            navbar.classList.add('expanded');
        }

        // Toggle sidebar
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            navbar.classList.toggle('expanded');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        });
    </script>
</body>
</html>
