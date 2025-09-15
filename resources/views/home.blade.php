<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        body {
            background-color: #ebefe6;
        }

        .card {
            background-color: rgb(101, 182, 57);
        }

        .card-body {
            padding: 5px;
            padding-top: 3px;
            padding-bottom: 0px;
        }

        /* Hamburger Icon Styles */
        .hamburger-icon {
            display: inline-block;
            cursor: pointer;
            margin: 0px;
            /* border-top-right-radius: 50px;
            border-bottom-right-radius: 50px; */
        }

        .hamburger-line {
            width: 25px;
            height: 3px;
            background-color: #ffffff;
            margin: 4px 0;
            transition: 0.4s;
        }

        .position-fixed {
            background-color: rgb(101, 182, 57);
        }

        .nav-item .nav-link {
            color: white;
        }

        h3 {
            color: white;
            margin-top: 7px;
        }
    </style>

</head>

<img src="{{ asset('images/header.png') }}" class="h-20 object-contain rounded-t-xl" alt="No image">


<body>
    <!-- Hamburger Button -->
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

    <!-- Sidebar Menu -->
    <div id="sidebarMenu" class="position-fixed top-0 start-0 shadow"
        style="width: 220px; height: 100vh; transform: translateX(-100%); transition: transform 0.3s; z-index: 1050;">

        <div class="row">
            <div class="col-3">
                {{-- <button id="closeSidebar" class="btn btn-close m-3" aria-label="Close"></button> --}}
                <button id="hamburgerBtnn" class="btn position-fixed top-0 start-0" type="button"
                    aria-label="Open menu">
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
            <div class="col-2 text-left">
                <h3>Home</h3>
            </div>
        </div>

        <ul class="nav flex-column p-3">
            <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Rekomendasi</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Department</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Signature</a></li>
        </ul>
    </div>

    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebarMenu = document.getElementById('sidebarMenu');
        const closeSidebar = document.getElementById('hamburgerBtnn');

        hamburgerBtn.addEventListener('click', () => {
            sidebarMenu.style.transform = 'translateX(0)';
        });

        closeSidebar.addEventListener('click', () => {
            sidebarMenu.style.transform = 'translateX(-100%)';
        });

        // Optional: Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (!sidebarMenu.contains(event.target) && !hamburgerBtn.contains(event.target)) {
                sidebarMenu.style.transform = 'translateX(-100%)';
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
