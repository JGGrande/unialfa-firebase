<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ver Usuário - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .painel-container {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 80px;
        }

        .user-profile {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 600px;
            margin: 2rem auto;
        }

        .user-profile-header {
            background: linear-gradient(135deg, #003366, #004080);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #fdb913;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #003366;
            font-weight: bold;
            margin: 0 auto 1rem auto;
        }

        .user-profile-body {
            padding: 2rem;
        }

        .profile-field {
            margin-bottom: 1.5rem;
        }

        .profile-field label {
            display: block;
            color: #003366;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .profile-field-value {
            background: #f8f9fa;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            border: 1px solid #e1e5e9;
            font-size: 1rem;
        }

        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-admin {
            background: #dc3545;
            color: white;
        }

        .badge-aluno {
            background: #28a745;
            color: white;
        }

        .profile-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
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

        @media (max-width: 768px) {
            .user-profile {
                margin: 1rem;
                max-width: none;
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
            <a href="/painel" class="back-btn">
                <i class="fas fa-arrow-left"></i> Voltar ao Painel
            </a>

            <div class="user-profile">
                <div class="user-profile-header">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user['nome'], 0, 1)) }}
                    </div>
                    <h1>{{ $user['nome'] }}</h1>
                    <span class="badge badge-{{ $user['perfil'] }}">
                        {{ $user['perfil'] }}
                    </span>
                </div>

                <div class="user-profile-body">
                    <div class="profile-field">
                        <label>Nome Completo</label>
                        <div class="profile-field-value">{{ $user['nome'] }}</div>
                    </div>

                    <div class="profile-field">
                        <label>E-mail</label>
                        <div class="profile-field-value">{{ $user['email'] }}</div>
                    </div>

                    <div class="profile-field">
                        <label>Perfil</label>
                        <div class="profile-field-value">
                            <span class="badge badge-{{ $user['perfil'] }}">
                                {{ ucfirst($user['perfil']) }}
                            </span>
                        </div>
                    </div>

                    <div class="profile-actions">
                        <a href="/painel/users/{{ $user['id'] }}/edit" class="btn btn-secondary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        
                        @if($currentUser['perfil'] === 'admin' && $user['id'] !== session('user_id'))
                            <form method="POST" action="/painel/users/{{ $user['id'] }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" 
                                        onclick="return confirm('Tem certeza que deseja remover este usuário?')">
                                    <i class="fas fa-trash"></i> Remover
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Faculdade UniAlfa. Todos os direitos reservados.</p>
    </footer>
</body>
</html>