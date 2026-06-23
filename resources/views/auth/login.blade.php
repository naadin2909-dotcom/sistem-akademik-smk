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
            max-width: 420px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px 35px;
            text-align: center;
        }

        .login-logo {
            width: 200px;
            height: auto;
            margin: -20px auto 10px;
            display: block;
            object-fit: contain;
            mix-blend-mode: multiply;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 30px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }

        .form-input {
            width: 100%;
            padding: 14px 22px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 0 5px;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #7C3AED;
            cursor: pointer;
        }

        .remember-check label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 14px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #e0d4ff;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #7C3AED 0%, #6B21A8 100%);
            border: none;
            border-radius: 50px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
            margin: 25px 0;
        }

        .register-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
        }

        .register-text a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.9);
            color: #ffffff;
            border: 1px solid rgba(239, 68, 68, 0.5);
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.9);
            color: #ffffff;
            border: 1px solid rgba(34, 197, 94, 0.5);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
            }

            .login-title {
                font-size: 24px;
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
                        <span style="color: #fca5a5; font-size: 12px; margin-top: 5px; display: block; padding-left: 20px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password"
                           name="password"
                           class="form-input @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required>
                    @error('password')
                        <span style="color: #fca5a5; font-size: 12px; margin-top: 5px; display: block; padding-left: 20px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-row">
                    <div class="remember-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">Log In</button>
            </form>

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
