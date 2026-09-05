<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PharmaCare MS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">

    <style>
        body {
            background-color: var(--slate-900);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid var(--slate-700);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-logo {
            width: 72px;
            height: 72px;
            object-fit: contain;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        .login-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--slate-900);
            margin: 0;
        }

        .login-subtitle {
            font-size: 0.85rem;
            color: var(--slate-500);
            margin-top: 4px;
        }

        .remember-forgot-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            margin: 18px 0 24px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--slate-600);
            cursor: pointer;
            font-size: 0.85rem;
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            justify-content: center;
            padding: 12px;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .demo-credentials-box {
            margin-top: 24px;
            padding: 12px 14px;
            background-color: var(--slate-50);
            border: 1px dashed var(--slate-200);
            border-radius: 8px;
            font-size: 0.75rem;
            color: var(--slate-600);
        }
    </style>
</head>
<body>

    <div class="login-card">

        <!-- Logo & Header -->
        <div class="login-header">
            <img src="{{ asset('assets/images/PharmacyLogo.png') }}" alt="PharmaCare Logo" class="login-logo">
            <h1 class="login-title">PharmaCare MS</h1>
            <p class="login-subtitle">Pharmacy & Retail Management System</p>
        </div>

        <!-- Session Status Alert -->
        @if (session('status'))
            <div class="alert alert-success" style="margin-bottom: 16px; font-size: 0.85rem;">
                <i class="bi bi-info-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="email">Email Address <span style="color: var(--danger);">*</span></label>
                <div style="position: relative; display: flex; align-items: center;">
                    <i class="bi bi-envelope" style="position: absolute; left: 12px; color: var(--slate-400);"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" style="padding-left: 36px; width: 100%;" placeholder="name@pharmacy.com" required autofocus autocomplete="username">
                </div>
                @if ($errors->has('email'))
                    <span class="form-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="password">Password <span style="color: var(--danger);">*</span></label>
                <div style="position: relative; display: flex; align-items: center;">
                    <i class="bi bi-lock" style="position: absolute; left: 12px; color: var(--slate-400);"></i>
                    <input type="password" id="password" name="password" class="form-input" style="padding-left: 36px; width: 100%;" placeholder="••••••••" required autocomplete="current-password">
                </div>
                @if ($errors->has('password'))
                    <span class="form-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="remember-forgot-row">
                <label for="remember_me" class="remember-label">
                    <input id="remember_me" type="checkbox" name="remember" style="accent-color: var(--slate-900);">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Sign In to Dashboard
            </button>
        </form>
    </div>

</body>
</html>