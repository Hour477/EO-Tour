<!-- Sidebar – always visible on desktop, offcanvas on mobile -->
<aside class="offcanvas offcanvas-start offcanvas-lg border-end bg-white shadow-sm" 
       tabindex="-1" 
       id="sidebarOffcanvas" 
       aria-labelledby="sidebarLabel"
       style="width: var(--sidebar-width); top: 56px; height: calc(100vh - 56px);">

    <div class="offcanvas-header d-lg-none border-bottom px-4 py-3">
        <h5 class="offcanvas-title fw-bold" id="sidebarLabel">
            <i class="bi bi-globe-asia-australia me-2"></i> EO Tour
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>

    <div class="offcanvas-body p-0 d-flex flex-column">
        <div class="flex-grow-1 py-3">
            <ul class="nav flex-column gap-1 px-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-house-door-fill me-2"></i> 
                        Dashboard
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->routeIs('admin.bookings.index') ? 'active' : '' }} "
                         href="{{route('admin.bookings.index')}} ">
                        <i class="bi bi-calendar-check-fill me-2"></i> 
                        Bookings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ request()->routeIs('admin.tours.index') ? 'active' : '' }} "
                    href="{{route('admin.tours.index')}}">
                        <i class="bi bi-geo-alt-fill me-2"></i> 
                        Tours
                    </a>
                </li>
                
            </ul>
        </div>

        <div class="p-3 border-top mt-auto">
            <form method="GET" action="{{ route('logout')}}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-arrow-right me-2"></i> 
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
