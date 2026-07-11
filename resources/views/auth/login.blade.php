<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Akademik SMK</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #6B21A8 0%, #7C3AED 30%, #A78BFA 70%, #C4B5FD 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px 35px 35px;
            text-align: center;
        }

        .login-logo {
            width: 180px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
            object-fit: contain;
            mix-blend-mode: multiply;
        }

        .login-title {
            font-size: 26px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-input {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            color: #374151;
            background: #e8e8e8;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            background: #e0e0e0;
            box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.2);
        }

        .form-input::placeholder {
            color: #888888;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #9b7fd4;
            border: none;
            border-radius: 50px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: #8b6fc4;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-link {
            display: block;
            font-size: 14px;
            color: #7C3AED;
            text-decoration: none;
            font-weight: 500;
            margin-top: 18px;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #6B21A8;
            text-decoration: underline;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 22px 0 18px;
        }

        .register-text {
            font-size: 13px;
            color: #6b7280;
        }

        .register-text a {
            color: #7C3AED;
            text-decoration: none;
            font-weight: 600;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            padding-left: 5px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px 25px;
            }

            .login-title {
                font-size: 24px;
            }

            .login-logo {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <img src="{{ asset('images/logo-login.png') }}" alt="Logo SMK" class="login-logo">

            <h1 class="login-title">Login</h1>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input type="email"
                           name="email"
                           class="form-input @error('email') is-invalid @enderror"
                           placeholder="Email ID"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password"
                           name="password"
                           class="form-input @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Log In</button>
            </form>

            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>

            <div class="divider"></div>

            <p class="register-text">
                Belum punya akun? <a href="javascript:void(0)" onclick="showAdminInfo()">Hubungi Admin</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAdminInfo() {
            Swal.fire({
                title: 'Daftar Akun Baru',
                html: '<p style="font-size: 14px; color: #6b7280;">Untuk mendaftar akun baru, silakan hubungi administrator sekolah.</p>',
                icon: 'info',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#7C3AED'
            });
        }
    </script>
</body>
</html>
