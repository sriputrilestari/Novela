<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Novela</title>
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 50%, #06b6d4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 8s ease-in-out infinite;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 10s ease-in-out infinite reverse;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }
        .login-container {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            position: relative;
            z-index: 1;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: flex;
            min-height: 650px;
        }
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 100%);
            padding: 70px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        .login-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }
        .login-left-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .brand-logo {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #ffffff 0%, #f0fdfa 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            position: relative;
        }
        .brand-logo::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent 0%, rgba(14, 165, 233, 0.1) 100%);
        }
        .brand-logo i {
            font-size: 50px;
            background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            z-index: 1;
        }
        .login-left h2 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            letter-spacing: -0.5px;
        }
        .login-left p {
            font-size: 1.15rem;
            opacity: 0.95;
            line-height: 1.7;
            margin-bottom: 40px;
        }
        .feature-list {
            text-align: left;
            margin-top: 40px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            opacity: 0.9;
        }
        .feature-item i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        .login-right {
            flex: 1;
            padding: 70px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-header {
            text-align: center;
            margin-bottom: 45px;
        }
        .login-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        .login-header p {
            color: #64748b;
            font-size: 1rem;
        }
        .form-group {
            margin-bottom: 28px;
        }
        .form-group label {
            display: block;
            color: #334155;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.92rem;
        }
        .form-control {
            width: 100%;
            padding: 16px 20px;
            padding-right: 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.98rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        .form-control:focus {
            outline: none;
            border-color: #0ea5e9;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.08);
        }
        .input-group {
            position: relative;
        }
        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .input-icon:hover {
            color: #0ea5e9;
        }
        .form-control:focus ~ .input-icon {
            color: #0ea5e9;
        }
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .custom-checkbox input {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #0ea5e9;
        }
        .custom-checkbox label {
            margin: 0;
            color: #475569;
            cursor: pointer;
            font-weight: 500;
        }
        .forgot-link {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .forgot-link:hover {
            color: #14b8a6;
        }
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.4);
        }
        .register-link {
            text-align: center;
            margin-top: 30px;
            color: #64748b;
        }
        .register-link a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }
        .register-link a:hover {
            color: #14b8a6;
        }
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 2px solid #fecaca;
        }
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-right { padding: 50px 35px; }
            body::before, body::after { display: none; }
        }
        .btn-login.loading {
            pointer-events: none;
            color: transparent;
        }
        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            top: 50%;
            left: 50%;
            margin: -11px 0 0 -11px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-left">
                <div class="login-left-content">
                    <div class="brand-logo">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h2>Novela</h2>
                    <p>Your gateway to endless stories and adventures</p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Thousands of novels to explore</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Track your reading progress</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Join the community</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="login-right">
                <div class="login-header">
                    <h1>Welcome Back</h1>
                    <p>Sign in to continue your reading journey</p>
                </div>
                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   required 
                                   autofocus>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password"
                                   required>
                            <i class="fas fa-eye-slash input-icon" id="togglePassword"></i>
                        </div>
                    </div>
                    <div class="remember-forgot">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn-login" id="loginBtn">Sign In</button>
                </form>
                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Create Account</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('loginBtn').classList.add('loading');
        });
    </script>
</body>
</html>