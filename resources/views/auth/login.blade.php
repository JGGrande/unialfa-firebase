<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://www.gstatic.com/firebasejs/10.5.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.5.0/firebase-auth-compat.js"></script>
    <style>
        .auth-container {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 51, 102, 0.9), rgba(0, 51, 102, 0.9)), 
                        url('https://www.alfaumuarama.edu.br/fau/site/templates/assets/images/slides/slide-2.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            background: white;
            padding: 3rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-header .logo img {
            height: 60px;
            margin-bottom: 1.5rem;
        }

        .auth-header h1 {
            color: #003366;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: #666;
            font-size: 0.95rem;
        }

        .auth-form .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .auth-form .form-group label {
            display: block;
            color: #003366;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .auth-form .form-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .auth-form .form-group input:focus {
            outline: none;
            border-color: #fdb913;
            box-shadow: 0 0 0 3px rgba(253, 185, 19, 0.1);
        }

        .auth-form .form-group i {
            position: absolute;
            left: 15px;
            top: 38px;
            color: #999;
            font-size: 1.1rem;
        }

        .auth-form .form-group input:focus + i {
            color: #fdb913;
        }

        .auth-form .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .auth-form .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-form .remember-me input[type="checkbox"] {
            width: auto;
        }

        .auth-form .forgot-password {
            color: #003366;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .auth-form .forgot-password:hover {
            color: #fdb913;
        }

        .auth-form .btn-auth {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #fdb913, #f5a623);
            color: #003366;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .auth-form .btn-auth:hover {
            background: linear-gradient(135deg, #f5a623, #e89611);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(253, 185, 19, 0.3);
        }

        .auth-divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
        }

        .auth-divider span {
            background: white;
            padding: 0 1rem;
            color: #666;
            font-size: 0.9rem;
        }

        .btn-google {
            width: 100%;
            padding: 14px;
            background: white;
            color: #333;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .btn-google:hover {
            background: #f8f9fa;
            border-color: #ccc;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-google .google-icon {
            width: 20px;
            height: 20px;
        }

        .btn-google.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .btn-google.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #ccc;
            border-top: 2px solid #333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .auth-footer {
            text-align: center;
        }

        .auth-footer p {
            color: #666;
            font-size: 0.9rem;
        }

        .auth-footer a {
            color: #003366;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: #fdb913;
        }

        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #c33;
            font-size: 0.9rem;
        }

        .back-to-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }

        .back-to-home:hover {
            color: #fdb913;
        }

        @media (max-width: 768px) {
            .auth-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .back-to-home {
                top: 1rem;
                left: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="/" class="back-to-home">
            <i class="fas fa-arrow-left"></i>
            Voltar ao site
        </a>

        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">
                    <img src="https://www.alfaumuarama.edu.br/fau/images/logo_novo.png" alt="Logo UniAlfa">
                </div>
                <h1>Fazer Login</h1>
                <p>Acesse sua conta da UniAlfa</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    <ul style="margin: 0; list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="auth-form" method="POST" action="/auth/login">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="Digite seu e-mail" 
                        required
                    >
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input 
                        type="password" 
                        id="senha" 
                        name="senha" 
                        placeholder="Digite sua senha" 
                        required
                    >
                    <i class="fas fa-lock"></i>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Lembrar de mim
                    </label>
                    <a href="#" class="forgot-password">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="btn-auth">
                    Entrar
                </button>
            </form>

            <div class="auth-divider">
                <span>ou</span>
            </div>

            <button type="button" id="googleSignIn" class="btn-google">
                <svg class="google-icon" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Continuar com Google
            </button>

            <div class="auth-footer">
                <p>Não tem uma conta? <a href="/auth/register">Cadastre-se aqui</a></p>
            </div>
        </div>
    </div>

    <script>
        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}",
            measurementId: "{{ config('services.firebase.measurement_id') }}",
        };

        firebase.initializeApp(firebaseConfig);

        async function signInWithGoogle() {
            console.log("Logando com o google")
        }

        async function sendUserToBackend(userData) {
            try {
                const response = await fetch('/auth/google-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(userData)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    window.location.href = result.redirect || '/painel';
                } else {
                    throw new Error(result.message || 'Erro ao processar login');
                }

            } catch (error) {
                console.error('Error sending user data to backend:', error);
                showError('Erro ao processar login. Tente novamente.');

                auth.signOut();
            }
        }

        function showError(message) {
            let errorDiv = document.querySelector('.error-message');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                document.querySelector('.auth-form').insertAdjacentElement('beforebegin', errorDiv);
            }
            
            errorDiv.innerHTML = `<ul style="margin: 0; list-style: none;"><li>${message}</li></ul>`;
            
            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('googleSignIn').addEventListener('click', signInWithGoogle);
            
            document.querySelectorAll('.auth-form input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.nextElementSibling.style.color = '#fdb913';
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.nextElementSibling.style.color = '#999';
                    }
                });
            });
        });
    </script>
</body>
</html>