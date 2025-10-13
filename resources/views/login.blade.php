<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(120deg, #fff 60%, #0d606e 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            border-radius: 18px;
            box-shadow: 0 8px 32px #0d606e22;
            border: 1.5px solid #0d606e;
            background: #fff;
            width: 420px;
        }

        .card-body {
            padding: 32px 28px 24px 28px;
        }

        .card-title {
            color: #0d606e;
            font-weight: bold;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        form {
            width: 100%;
            padding: 0;
            background: none;
            border-radius: 0;
            box-shadow: none;
        }

        .form-label {
            color: #0d606e;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            border: 1.5px solid #0d606e;
            font-size: 15px;
            background: #fff;
        }

        .form-control:focus {
            border-color: #ffa800;
            box-shadow: 0 0 0 2px #ffa80033;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ffa800 60%, #0d606e 100%);
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
            color: #fff;
            box-shadow: 0 2px 8px #ffa80022;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0d606e 60%, #ffa800 100%);
            color: #fff;
        }

        .alert-danger {
            border-radius: 8px;
            background: #ffa80022;
            color: #0d606e;
            border: 1.5px solid #ffa800;
        }

        .login-logo {
            display: block;
            margin: 0 auto 18px auto;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffa800 60%, #0d606e 100%);
            box-shadow: 0 2px 12px #ffa80033;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-logo img {
            width: 48px;
            height: 48px;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="card-body">
            <div class="login-logo mb-2 pe-1 pb-1">
                <img src="{{ asset('images/logo-ggp.png') }}" alt="Logo">
            </div>
            @if (session('error'))
                <div class="alert alert-danger mb-3">
                    {{ session('error') }}
                </div>
            @endif
            <h2 class="card-title text-center mb-3 mt-1">Silahkan Login</h2>
            <form method="POST" action="/login">
                @csrf
                <div class="form-group mb-3">
                    <label for="exampleInputUser" class="form-label">Username</label>
                    <input type="text" class="form-control" id="exampleInputUser" name="username"
                        placeholder="Username">
                </div>
                <div class="form-group mb-2">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                        placeholder="Password">
                </div>
                <div class="d-grid gap-2 mb-2 mt-4">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        window.addEventListener('popstate', function() {
            if (!{{ session()->has('loginId') ? 'true' : 'false' }}) {
                window.location.href = '/login';
            }
        });
    </script>


</body>

</html>
