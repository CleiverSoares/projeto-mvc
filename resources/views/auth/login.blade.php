<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Projeto Doar</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        
        .login-left {
            background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }
        
        .login-left .logo {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .login-left h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .login-left p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .login-right {
            padding: 60px 40px;
        }
        
        .login-right h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .form-check input {
            margin-right: 8px;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }
            
            .login-left {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo">
                <i class="fas fa-heart"></i>
            </div>
            <h1>Projeto Doar</h1>
            <p>Sistema de Gestão Social</p>
            <p style="margin-top: 20px; font-size: 14px;">
                Faça login para acessar o sistema
            </p>
        </div>
        
        <div class="login-right">
            <h2>Bem-vindo!</h2>
            
            @if($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope me-1"></i>Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock me-1"></i>Senha
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Lembrar-me</label>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-1"></i>Entrar
                </button>
            </form>
        </div>
    </div>
</body>
</html>
