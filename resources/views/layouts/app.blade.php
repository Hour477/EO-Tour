<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EO Tour - Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
        }
        body {
            background: #f5f7fa;
            min-height: 100vh;
        }
        .navbar-tour {
            background: linear-gradient(90deg, #0d6efd, #0b5ed7) !important;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #dee2e6;
            position: fixed;
            top: 56px;
            bottom: 0;
            overflow-y: auto;
            transition: transform 0.3s;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: calc(100vh - 56px);
            transition: margin-left 0.3s;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
        
        .nav-link {
            color: #495057;
            padding: 0.75rem 1.25rem;
        }
        .nav-link.active, .nav-link:hover {
            background: #e7f1ff;
            color: #0d6efd;
        }
        @media (min-width: 992px) {
        #sidebarOffcanvas {
            transform: none !important;
            visibility: visible !important;
            position: fixed !important;
            z-index: 1000;
        }
        .main-content {
            margin-left: var(--sidebar-width) !important;
        }
    }
    </style>

    @yield('head')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand navbar-tour navbar-dark sticky-top shadow">
    <div class="container-fluid px-3">
        <button class="btn btn-link text-white me-3 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list fs-3"></i>
        </button>

        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-globe-asia-australia me-2"></i> EO Tour
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white small d-none d-md-block">{{ now()->format('d/m/Y') }}</span>

            <div class="dropdown">
                <a class="text-white text-decoration-none dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span>Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="GET" action="{{ route('logout') }}">
                            @method('GET')
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar (offcanvas on mobile, fixed on desktop) -->

    @include('layouts.sidebar')


<!-- Main content area -->
<main class="main-content p-4 p-lg-5">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>