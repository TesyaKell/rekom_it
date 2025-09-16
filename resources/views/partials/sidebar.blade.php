<style>
    .card {
        background-color: rgb(70, 140, 9);
    }

    .card-body {
        padding: 5px;
        padding-top: 3px;
        padding-bottom: 0px;
    }

    .hamburger-icon {
        display: inline-block;
        cursor: pointer;
        margin: 0px;
    }

    .hamburger-line {
        width: 25px;
        height: 3px;
        background-color: #ffffff;
        margin: 4px 0;
        transition: 0.4s;
    }

    .position-fixed {
        /* background-color: rgb(253, 253, 253); */
        background-color: rgb(70, 140, 9);
    }

    .nav {
        width: 100%;
        padding: 0;
    }

    .y-sidebarItem {
        width: 115%;
        margin-left: -15px;
    }

    .nav-link {
        display: block;
        width: 100%;
        color: white;
        padding: 10px 15px;
        margin: 0;
        text-align: left;
    }

    .nav-link:hover {
        background-color: rgb(54, 109, 6);
        color: white;
        transform: scale(1.02);
    }

    h3 {
        color: white;
        margin-top: -12px;
        margin-left: 70px;
        font-size: 18px;
        font-weight: bold;
    }
</style>

<button id="hamburgerBtn" class="btn position-fixed top-0 start-0" type="button" aria-label="Open menu">
    <div class="card">
        <div class="card-body">
            <div class="hamburger-icon">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </div>
        </div>
    </div>
</button>

<div id="sidebarMenu" class="position-fixed top-0 start-0 shadow"
    style="width: 220px; height: 100vh; transform: translateX(-100%); transition: transform 0.3s; z-index: 1050;">

    <div class="row">
        <div class="col-3">
            <button id="hamburgerBtnn" class="btn position-fixed top-0 start-0" type="button" aria-label="Open menu">
                <div class="card">
                    <div class="card-body">
                        <div class="hamburger-icon">
                            <div class="hamburger-line"></div>
                            <div class="hamburger-line"></div>
                            <div class="hamburger-line"></div>
                        </div>
                    </div>
                </div>
            </button>
        </div>
        <div class="col-11 text-left">
            <h3>{{ $pageTitle ?? 'Dashboard' }}</h3>
        </div>
    </div>

    <div class="nav flex-column p-3">

        <div class="y-sidebarItem r-hide-accordion">
            <a class="nav-link d-flex align-items-center" href="{{ url('home') }}">
                <img class="me-2" src="{{ asset('images/home.png') }}" alt="Logo" width="20" height="20">
                <span>Home</span>
            </a>
        </div>

        {{-- pertama --}}
        <div class="y-sidebarItem r-hide-accordion">
            <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" id="rekomMenuToggle">
                <img class="me-2" src="{{ asset('images/rekomendasi.png') }}" alt="Logo" width="20"
                    height="20">
                <span>Rekomendasi</span>
                <span class="ms-auto">
                    <path fill-rule="evenodd"
                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                </span>
            </a>
            <div class="submenu ps-4" id="rekomMenu" style="display: none;">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 d-flex align-items-center">
                        <span style="color: orange; font-size: 1.2em; margin-right: 3px;">●</span>
                        <a class="nav-link p-2" href="{{ url('daftar_rekomendasi') }}">Daftar Rekomendasi</a>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <span style="color: orange; font-size: 1.2em; margin-right: 3px;">●</span>
                        <a class="nav-link p-2" href="{{ url('add_rekomendasi') }}">Add Rekomendasi</a>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <span style="color: orange; font-size: 1.2em; margin-right: 3px;">●</span>
                        <a class="nav-link p-2" href="#">Deleted Rekomendasi</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- kedua --}}
        <div class="y-sidebarItem r-hide-accordion">
            <a class="nav-link d-flex align-items-center" href="{{ url('department') }}">
                <img class="me-2" src="{{ asset('images/department.png') }}" alt="Logo" width="20"
                    height="20">
                <span>Department</span>
            </a>
        </div>
        <div class="y-sidebarItem r-hide-accordion">
            <a class="nav-link d-flex align-items-center" href="{{ url('signature') }}">
                <img class="me-2" src="{{ asset('images/signature.png') }}" alt="Logo" width="20"
                    height="20">
                <span>Signature</span>
            </a>
        </div>
        <div class="y-sidebarItem r-hide-accordion">
            <a class="nav-link d-flex align-items-center" href="#">
                <img class="me-2" src="{{ asset('images/report.png') }}" alt="Logo" width="20"
                    height="20">
                <span>Report</span>
            </a>
        </div>

        <div class="y-sidebarItem r-hide-accordion" style="position: absolute; bottom: 20px; width: 215px;">
            <a class="nav-link d-flex align-items-center" href="{{ url('/login') }}">
                <img class="me-2" src="{{ asset('images/logout.png') }}" alt="Logo" width="20"
                    height="20">
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebarMenu = document.getElementById('sidebarMenu');
        const closeSidebar = document.getElementById('hamburgerBtnn');
        const rekomMenuToggle = document.getElementById('rekomMenuToggle');
        const rekomMenu = document.getElementById('rekomMenu');

        rekomMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (rekomMenu.style.display === 'none') {
                rekomMenu.style.display = 'block';
            } else {
                rekomMenu.style.display = 'none';
            }
        });

        hamburgerBtn.addEventListener('click', () => {
            sidebarMenu.style.transform = 'translateX(0)';
        });

        closeSidebar.addEventListener('click', () => {
            sidebarMenu.style.transform = 'translateX(-100%)';
        });

        document.addEventListener('click', function(event) {
            if (!sidebarMenu.contains(event.target) && !hamburgerBtn.contains(event.target)) {
                sidebarMenu.style.transform = 'translateX(-100%)';
            }
        });
    });
</script>
