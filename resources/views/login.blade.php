<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background-color: #ebefe6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            width: 400px;
            height: 260px;
            padding: 20px;
            margin-bottom: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(to right, #77ca11, #28ad28);
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center mb-3 mt-3">Silahkan Login</h2>
            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" placeholder="Enter Username">
                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                        else.</small> --}}
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-primary mt-3"
                        onclick="window.location='{{ url('home') }}'">Sign In</button>
                </div>

                {{-- <button type="button" class="btn btn-sm btn-outline-primary px-5 py-2.5 rounded-lg text-base shadow-md"
                    onclick="window.location='{{ route('history') }}'">
                    <i class="fas fa-history mr-2"></i> Review
                </button> --}}

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
