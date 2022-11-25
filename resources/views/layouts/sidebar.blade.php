<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start " id="sidenav-main">
    <div class="sidenav-header">
        <div class="p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none" aria-hidden="true"
            id="iconSidenav">x</div>
        <a class="navbar-brand d-flex align-items-center m-0"
            href=" https://demos.creative-tim.com/corporate-ui-dashboard/pages/dashboard.html " target="_blank">
            <span class="font-weight-bold text-lg">IAN Platform</span>
        </a>
    </div>
    <div class="collapse navbar-collapse px-4  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <div
                        class="{{ Request::is('/') ? 'text-primary' : '' }} icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="nav-link-text ms-1">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ Request::is('sites') ? 'active' : '' }}" href="/sites">
                    <div
                        class="{{ Request::is('sites') ? 'text-primary' : '' }} icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sites</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ Request::is('devices*') ? 'active' : '' }}" href="/devices">
                    <div
                        class="{{ Request::is('devices*') ? 'text-primary' : '' }} icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-hard-drive"></i>
                    </div>
                    <span class="nav-link-text ms-1">Devices</span>
                </a>
            </li>
            {{-- <li class="nav-item dropdown">
                <div class="d-flex align-items-center nav-link">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="nav-link-text ms-1">Devices</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 " href="/pages/profile.html">
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 " href="/pages/sign-in.html">
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 " href="/pages/sign-up.html">
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> --}}
        </ul>
    </div>
    {{-- <div class="sidenav-footer mx-4 ">
        <div class="card bg-gray-500 border-radius-md" id="sidenavCard">
            <img class="w-50 mx-auto" src="/assets/img/iot/mascotPNG2.png" alt="sidebar_illustration">
            <div class="card-body text-center p-3 w-100 pt-0">
                <div class="docs-info">
                    <h6 class="mb-0 text-secondary">Need help?</h6>
                    <p class="text-xs font-weight-bold mb-0">Contact marketing@iotech.co.id</p>
                </div>
                <div class="docs-info ">
                    <h6 class="mb-0 text-secondary" id="clock"></h6>
                </div>
            </div>
        </div>
    </div> --}}
</aside>
