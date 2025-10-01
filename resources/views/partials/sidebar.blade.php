<style>
    .card-burger {
        background-color: #0d606e;
    }

    .card-body-burger {
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
        background-color: #0d606e;
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
        background-color: #0d606e;
        color: white;
        transform: scale(1.02);
    }

    h3 {
        color: white;
        margin-top: 7px;
        margin-left: 70px;
        font-size: 18px;
        font-weight: bold;
    }

    #mainContent {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-left: 0;
    }

    #mainContent.shifted {
        transform: translateX(220px);
    }

    #sidebarMenu {
        left: 0;
    }

    body.sidebar-open {
        overflow-x: hidden;
    }
</style>

<button id="hamburgerBtn" class="btn position-fixed top-0 start-0" type="button" aria-label="Open menu">
    <div class="card-burger">
        <div class="card-body-burger">
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
                <div class="card-burger">
                    <div class="card-body-burger">
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

        {{-- Semua role punya Home --}}
        <div class="y-sidebarItem r-hide-accordion">
            <a class="nav-link d-flex align-items-center" href="{{ url('home') }}">
                <img class="me-2" src="{{ asset('images/home.png') }}" alt="Logo" width="20" height="20">
                <span class="text-sidebar">Home</span>
            </a>
        </div>

        @if (session('loginRole') !== 'IT')
            <div class="y-sidebarItem r-hide-accordion">
                <a class="nav-link d-flex align-items-center" href="{{ url('daftar_rekomendasi') }}">
                    <img class="me-2" src="{{ asset('images/rekomendasi.png') }}" alt="Logo" width="20"
                        height="20">
                    <span class="text-sidebar">Daftar Rekomendasi</span>
                </a>
            </div>
        @endif



        {{-- Menu khusus IT --}}
        @if (session('loginRole') === 'IT')
            <div class="y-sidebarItem r-hide-accordion">
                <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" id="rekomMenuToggle">
                    <img class="me-2" src="{{ asset('images/rekomendasi.png') }}" alt="Logo" width="20"
                        height="20">
                    <span class="text-sidebar">Rekomendasi</span>
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
                            <a class="nav-link p-2" href="{{ url('deleted_rekomendasi') }}">Deleted Rekomendasi</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="y-sidebarItem r-hide-accordion">
                <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" id="masterDataMenuToggle">
                    <img class="me-2" src="{{ asset('images/department.png') }}" alt="Logo" width="20"
                        height="20">
                    <span>Master Data</span>
                </a>
                <div class="submenu ps-4" id="masterDataMenu" style="display: none;">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 d-flex align-items-center">
                            <span style="color: orange; font-size: 1.2em; margin-right: 3px;">●</span>
                            <a class="nav-link p-2" href="{{ url('department') }}">Daftar Department</a>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <span style="color: orange; font-size: 1.2em; margin-right: 3px;">●</span>
                            <a class="nav-link p-2" href="{{ url('signature') }}">Daftar Signature</a>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <span style="color: orange; font-size: 1.2em; margin-right: 3px;">●</span>
                            <a class="nav-link p-2" href="{{ url('jabatan') }}">Daftar Jabatan</a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
        {{-- Semua role punya Report --}}
        <div class="y-sidebarItem r-hide-accordion">
            <a class="nav-link d-flex align-items-center" href="{{ url('report') }}">
                <img class="me-2" src="{{ asset('images/report.png') }}" alt="Logo" width="20"
                    height="20">
                <span class="text-sidebar">Report</span>
            </a>
        </div>

        {{-- Logout semua role --}}
        <div class="y-sidebarItem r-hide-accordion" style="position: absolute; bottom: 20px; width: 215px;">
            <a class="nav-link d-flex align-items-center" href="#" id="logoutBtn" data-bs-toggle="modal"
                data-bs-target="#logoutModal">
                <img class="me-2" src="{{ asset('images/logout.png') }}" alt="Logo" width="20"
                    height="20">
                <span class="text-sidebar">Logout</span>
            </a>
        </div>
    </div>

</div>

<div id="mainContent">

</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel" style="color: #333;">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="color: #333;">
                Apakah Anda yakin ingin keluar dari sistem?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmLogout">Keluar</button>
            </div>
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
        const masterDataMenuToggle = document.getElementById('masterDataMenuToggle');
        const masterDataMenu = document.getElementById('masterDataMenu');
        const mainContent = document.getElementById('mainContent');
        const containerHeader = document.getElementsByClassName('container-header');
        const homeScreen = document.getElementById('home-screen');

        if (rekomMenuToggle && rekomMenu) {
            rekomMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                if (rekomMenu.style.display === 'none') {
                    rekomMenu.style.display = 'block';
                } else {
                    rekomMenu.style.display = 'none';
                }
            });
        }

        // Tambahkan event listener untuk Master Data dropdown
        if (masterDataMenuToggle && masterDataMenu) {
            masterDataMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                if (masterDataMenu.style.display === 'none') {
                    masterDataMenu.style.display = 'block';
                } else {
                    masterDataMenu.style.display = 'none';
                }
            });
        }

        if (hamburgerBtn && sidebarMenu) {
            hamburgerBtn.addEventListener('click', () => {
                sidebarMenu.style.transform = 'translateX(0)';
                if (mainContent) mainContent.classList.add('shifted');
                document.body.classList.add('sidebar-open');
                let container = containerHeader?.item(0);
                if (container) {
                    container.style.marginLeft = '220px';
                    container.style.transition = 'margin-left 0.3s';
                }
                if (homeScreen) {
                    homeScreen.style.marginLeft = '220px';
                    homeScreen.style.transition = 'margin-left 0.3s';
                }
            });
        }

        if (closeSidebar && sidebarMenu) {
            closeSidebar.addEventListener('click', () => {
                sidebarMenu.style.transform = 'translateX(-100%)';
                if (mainContent) mainContent.classList.remove('shifted');
                document.body.classList.remove('sidebar-open');
                let container = containerHeader?.item(0);
                if (container) {
                    container.style.marginLeft = '0';
                    container.style.transition = 'margin-left 0.3s';
                }
                if (homeScreen) {
                    homeScreen.style.marginLeft = '0';
                    homeScreen.style.transition = 'margin-left 0.3s';
                }
            });
        }

        document.addEventListener('click', function(event) {
            if (sidebarMenu && hamburgerBtn &&
                !sidebarMenu.contains(event.target) &&
                !hamburgerBtn.contains(event.target)) {
                sidebarMenu.style.transform = 'translateX(-100%)';
                if (mainContent) mainContent.classList.remove('shifted');
                document.body.classList.remove('sidebar-open');
                let container = containerHeader?.item(0);
                if (container) {
                    container.style.marginLeft = '0';
                    container.style.transition = 'margin-left 0.3s';
                }
                if (homeScreen) {
                    homeScreen.style.marginLeft = '0';
                    homeScreen.style.transition = 'margin-left 0.3s';
                }
            }
        });

        // Logout confirmation
        const confirmLogout = document.getElementById('confirmLogout');
        confirmLogout.addEventListener('click', function() {
            // Create a form to submit logout request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('logout') }}";

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = "{{ csrf_token() }}";
            form.appendChild(csrfToken);

            // Add to body and submit
            document.body.appendChild(form);
            form.submit();
        });
    });
</script>
