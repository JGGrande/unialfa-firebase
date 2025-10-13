<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .auth-form .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .auth-form .terms-checkbox input[type="checkbox"] {
            width: auto;
            margin-top: 0.2rem;
        }

        .auth-form .terms-checkbox a {
            color: #003366;
            text-decoration: none;
        }

        .auth-form .terms-checkbox a:hover {
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

        .success-message {
            background-color: #efe;
            color: #363;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #363;
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

        .password-strength {
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .password-weak { color: #dc3545; }
        .password-medium { color: #ffc107; }
        .password-strong { color: #28a745; }

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
                <h1>Criar Conta</h1>
                <p>Junte-se à comunidade UniAlfa</p>
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

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form class="auth-form" method="POST" action="/auth/register">
                @csrf
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome" 
                        value="{{ old('nome') }}"
                        placeholder="Digite seu nome completo" 
                        required
                    >
                    <i class="fas fa-user"></i>
                </div>

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
                        placeholder="Digite sua senha (mínimo 6 caracteres)" 
                        required
                        minlength="6"
                        onkeyup="checkPasswordStrength(this.value)"
                    >
                    <i class="fas fa-lock"></i>
                    <div id="password-strength" class="password-strength"></div>
                </div>

                <div class="form-group">
                    <label for="senha_confirmation">Confirmar Senha</label>
                    <input 
                        type="password" 
                        id="senha_confirmation" 
                        name="senha_confirmation" 
                        placeholder="Confirme sua senha" 
                        required
                        minlength="6"
                    >
                    <i class="fas fa-lock"></i>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Eu concordo com os <a href="#" target="_blank">Termos de Uso</a> 
                        e <a href="#" target="_blank">Política de Privacidade</a> da UniAlfa
                    </label>
                </div>

                <button type="submit" class="btn-auth">
                    Criar Conta
                </button>
            </form>

            <div class="auth-divider">
                <span>ou</span>
            </div>

            <div class="auth-footer">
                <p>Já tem uma conta? <a href="/auth/login">Faça login aqui</a></p>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.auth-form input').forEach(input => {
            input.addEventListener('focus', function() {
                const icon = this.nextElementSibling;
                if (icon && icon.tagName === 'I') {
                    icon.style.color = '#fdb913';
                }
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    const icon = this.nextElementSibling;
                    if (icon && icon.tagName === 'I') {
                        icon.style.color = '#999';
                    }
                }
            });
        });

        function checkPasswordStrength(password) {
            const strengthDiv = document.getElementById('password-strength');
            
            if (password.length === 0) {
                strengthDiv.textContent = '';
                return;
            }
            
            let strength = 0;
            let feedback = '';
            
            if (password.length >= 6) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    strengthDiv.className = 'password-strength password-weak';
                    feedback = 'Senha muito fraca';
                    break;
                case 2:
                case 3:
                    strengthDiv.className = 'password-strength password-medium';
                    feedback = 'Senha média';
                    break;
                case 4:
                case 5:
                    strengthDiv.className = 'password-strength password-strong';
                    feedback = 'Senha forte';
                    break;
            }
            
            strengthDiv.textContent = feedback;
        }

        document.getElementById('senha_confirmation').addEventListener('input', function() {
            const senha = document.getElementById('senha').value;
            const confirmacao = this.value;
            
            if (confirmacao && senha !== confirmacao) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#e1e5e9';
            }
        });
    </script>
</body>
</html>
