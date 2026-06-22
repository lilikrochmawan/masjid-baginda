<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Baginda</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            background: white;
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
        }
        
        .login-header h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: #666;
            font-size: 13px;
        }
        
        .form-group {
            margin-bottom: 18px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 500;
            font-size: 13px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 18px;
            border: 1px solid #f5c6cb;
            font-size: 13px;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .login-container {
                padding: 25px 18px;
                max-width: 100%;
            }
            .login-header h1 {
                font-size: 22px;
            }
            .login-logo {
                width: 70px;
                height: 70px;
            }
        }
        
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('images/image.png') }}" alt="Logo Masjid Baginda" class="login-logo">
            <h1>Masjid Baginda</h1>
            <p>Sistem Informasi Manajemen</p>
        </div>
        
        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first('email') }}
            </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="submit-btn">Login</button>
        </form>
    </div>
</body>
</html>
