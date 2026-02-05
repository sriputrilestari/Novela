<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Novela</title>
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
        .register-container {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            position: relative;
            z-index: 1;
        }
        .register-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: flex;
            max-height: 90vh;
        }
        .register-left {
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
        .register-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        .register-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }
        .register-left-content {
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
        .register-left h2 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            letter-spacing: -0.5px;
        }
        .register-left p {
            font-size: 1.15rem;
            opacity: 0.95;
            line-height: 1.7;
        }
        .register-right {
            flex: 1;
            padding: 50px 60px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            max-height: 90vh;
        }
        /* Custom scrollbar */
        .register-right::-webkit-scrollbar {
            width: 8px;
        }
        .register-right::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .register-right::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 100%);
            border-radius: 10px;
        }
        .register-right::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0284c7 0%, #0d9488 100%);
        }
        .register-header {
            text-align: center;
            margin-bottom: 35px;
        }
        .register-header h1 {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .register-header p {
            color: #64748b;
            font-size: 0.95rem;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #334155;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .form-control, .form-select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        .form-control {
            padding-right: 50px;
        }
        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #0ea5e9;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.08);
        }
        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
            padding-right: 45px;
        }
        .form-select:focus {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%230ea5e9' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
        }
        .input-group {
            position: relative;
        }
        .input-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 10;
        }
        .input-icon:hover {
            color: #0ea5e9;
        }
        .form-control:focus ~ .input-icon {
            color: #0ea5e9;
        }
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
            margin-top: 15px;
            position: relative;
        }
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.4);
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            color: #64748b;
            font-size: 0.92rem;
        }
        .login-link a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }
        .login-link a:hover {
            color: #14b8a6;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 2px solid #fecaca;
        }
        @media (max-width: 768px) {
            .register-left { display: none; }
            .register-right { 
                padding: 40px 30px;
                max-height: 100vh;
            }
            .register-header h1 {
                font-size: 1.7rem;
            }
            body::before, body::after { display: none; }
        }
        .btn-register.loading {
            pointer-events: none;
            color: transparent;
        }
        .btn-register.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin: -10px 0 0 -10px;
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
    <div class="register-container">
        <div class="register-card">
            <div class="register-left">
                <div class="register-left-content">
                    <div class="brand-logo">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h2>Join Novela</h2>
                    <p>Start your reading adventure today and discover thousands of amazing stories</p>
                </div>
            </div>
            <div class="register-right">
                <div class="register-header">
                    <h1>Create Account</h1>
                    <p>Fill in the details below to get started</p>
                </div>
                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="John Doe"
                                   required 
                                   autofocus>
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   required>
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
                                   placeholder="Create a strong password"
                                   required>
                            <i class="fas fa-eye-slash input-icon" id="togglePassword"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Re-enter your password"
                                   required>
                            <i class="fas fa-eye-slash input-icon" id="togglePasswordConfirm"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn-register" id="registerBtn">Create Account</button>
                </form>
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Toggle confirm password visibility
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Loading state
        document.getElementById('registerForm').addEventListener('submit', function() {
            document.getElementById('registerBtn').classList.add('loading');
        });
    </script>
</body>
</html>