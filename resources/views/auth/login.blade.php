<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Reservasi Maiway</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body, html { width: 100%; min-height: 100%; font-family: 'Inter', sans-serif; background-color: #F5F5F5; display: flex; align-items: center; justify-content: center; }
        .login-wrapper { width: 100%; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .login-card { background: #ffffff; width: 100%; max-width: 586px; border-radius: 20px; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1); padding: 50px 60px; display: flex; flex-direction: column; }
        .login-header { text-align: center; margin-bottom: 40px; }
        .login-title { font-size: 36px; font-weight: 600; color: #000; margin-bottom: 8px; }
        .login-subtitle { font-size: 16px; color: #AEACAC; font-weight: 500; }
        .form-group { margin-bottom: 24px; position: relative; }
        .form-group label { display: block; font-size: 16px; font-weight: 500; color: #000; margin-bottom: 10px; }
        .form-control { width: 100%; height: 55px; background: #F9F9F9; border: 1px solid #EAEAEA; border-radius: 10px; padding: 0 50px 0 16px; font-size: 15px; outline: none; transition: all 0.3s ease; }
        .form-control:focus { border-color: #B5C37C; background: #fff; }
        .password-toggle { position: absolute; right: 15px; top: 43px; cursor: pointer; color: #AEACAC; }
        .btn-signin { width: 100%; height: 60px; background-color: #B5C37C; color: #fff; border: none; border-radius: 10px; font-size: 18px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-signin:hover { background-color: #a4b26a; }
        .divider { width: 100%; display: flex; align-items: center; text-align: center; margin: 35px 0; color: #AEACAC; font-size: 14px; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid #EAEAEA; }
        .divider:not(:empty)::before { margin-right: 1.5em; }
        .divider:not(:empty)::after { margin-left: 1.5em; }
        .social-container { display: flex; gap: 20px; justify-content: center; margin-bottom: 35px; }
        .social-icon { width: 50px; height: 50px; border: 1px solid #EAEAEA; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s; }
        .social-icon:hover { border-color: #B5C37C; transform: translateY(-3px); }
        .signup-text { font-size: 15px; color: #AEACAC; text-align: center; }
        .signup-text a { color: #B5C37C; text-decoration: none; font-weight: 600; }
        @media (max-width: 600px) { body, html { background-color: #fff; } .login-card { box-shadow: none; padding: 40px 25px; border-radius: 0; } }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Sign In</h1>
                <p class="login-subtitle">Hi Welcome! Continue to login</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span class="password-toggle" onclick="togglePass('password')">
                        <svg id="eye-icon-password" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </span>
                </div>
                <div style="text-align: right; margin-bottom: 30px;">
                    <a href="{{ route('password.request') }}" style="color: #B5C37C; text-decoration: none; font-size: 14px;">Forgot Password</a>
                </div>
                <button type="submit" class="btn-signin">Sign in</button>
            </form>
            <div class="divider">Or Sign in with</div>
            <div class="social-container">
                <a href="{{ url('auth/google') }}" class="social-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-1 .67-2.28 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                </a>
                <a href="{{ url('auth/facebook') }}" class="social-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" fill="#1877F2"/></svg>
                </a>
                <a href="{{ url('auth/apple') }}" class="social-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M17.05 20.28c-.98.95-2.05 1.78-3.19 1.76-1.14-.02-1.55-.72-2.87-.72-1.33 0-1.78.71-2.85.73-1.08.02-2.01-.73-3.14-1.81-2.31-2.2-4.04-6.23-4.04-9.04 0-4.58 2.97-7 5.86-7.04 1.45-.02 2.82.98 3.71.98.88 0 2.59-1.2 4.31-1.03 1.73.17 3.03.8 3.86 2-.15.1-.31.22-.47.34-1.4 1.05-2.09 2.5-2.09 4.35 0 2.25 1.06 3.96 2.6 5.12-.42.84-.96 1.63-1.6 2.36zm-2.84-14.73c-.8-.97-1.33-2.31-1.19-3.65 1.15.05 2.53.77 3.36 1.74.83.97 1.34 2.37 1.14 3.65-1.28.1-2.51-.77-3.31-1.74z" fill="black"/></svg>
                </a>
            </div>
            <p class="signup-text">Don’t have an account? <a href="{{ route('register') }}">Sign up</a></p>
        </div>
    </div>
    <script>
        function togglePass(id) {
            const input = document.getElementById(id); const icon = document.getElementById('eye-icon-' + id);
            if (input.type === "password") { input.type = "text"; icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>'; } 
            else { input.type = "password"; icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>'; }
        }
    </script>
</body>
</html>