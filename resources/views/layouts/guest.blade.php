<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .auth-body {
            padding: 40px;
            background-color: white;
        }

        .btn-auth {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            border: none;
            color: white;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.3s;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            color: white;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e0e0e0;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .auth-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-link:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        .logo {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="logo">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h2>Todo Application</h2>
                    </div>

                    <div class="auth-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
