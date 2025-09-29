<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuário - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .painel-container {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 80px;
        }

        .edit-form {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 600px;
            margin: 2rem auto;
        }

        .edit-form-header {
            background: linear-gradient(135deg, #003366, #004080);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .edit-form-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #003366;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #fdb913;
            box-shadow: 0 0 0 3px rgba(253, 185, 19, 0.1);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            margin-bottom: 1rem;
        }

        .back-btn:hover {
            color: #003366;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
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

        @media (max-width: 768px) {
            .edit-form {
                margin: 1rem;
                max-width: none;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="/painel" class="logo">
                <img src="https://www.alfaumuarama.edu.br/fau/images/logo_novo.png" alt="Logo UniAlfa">
            </a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="/painel" class="nav-link">Painel</a></li>
                <li class="nav-item">
                    <form method="POST" action="/logout" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="painel-container">
        <div class="container">
            <a href="/painel/users/{{ $user['id'] }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>

            <div class="edit-form">
                <div class="edit-form-header">
                    <h1>Editar Usuário</h1>
                    <p>{{ $user['nome'] }}</p>
                </div>

                <div class="edit-form-body">
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

                    @if (session('error'))
                        <div class="error-message">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="/painel/users/{{ $user['id'] }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input 
                                type="text" 
                                id="nome" 
                                name="nome" 
                                value="{{ old('nome', $user['nome']) }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user['email']) }}"
                                required
                            >
                        </div>

                        @if($currentUser['perfil'] === 'admin')
                            <div class="form-group">
                                <label for="perfil">Perfil</label>
                                <select id="perfil" name="perfil">
                                    <option value="aluno" {{ $user['perfil'] === 'aluno' ? 'selected' : '' }}>
                                        Aluno
                                    </option>
                                    <option value="admin" {{ $user['perfil'] === 'admin' ? 'selected' : '' }}>
                                        Administrador
                                    </option>
                                </select>
                            </div>
                        @endif

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                            <a href="/painel/users/{{ $user['id'] }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Faculdade UniAlfa. Todos os direitos reservados.</p>
    </footer>
</body>
</html>