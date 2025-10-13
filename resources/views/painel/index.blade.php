<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .painel-container {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 80px;
        }

        .painel-header {
            background: linear-gradient(135deg, #003366, #004080);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .painel-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .painel-title {
            font-size: 1.8rem;
            margin: 0;
        }

        .painel-subtitle {
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #fdb913;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #003366;
            font-weight: bold;
        }

        .user-details h3 {
            margin: 0;
            font-size: 1.1rem;
        }

        .user-details p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.8;
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

        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #28a745;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #dc3545;
        }

        .painel-nav {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .painel-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .painel-nav li {
            flex: 1;
        }

        .painel-nav a {
            display: block;
            padding: 1rem 1.5rem;
            color: #666;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }

        .painel-nav a:hover,
        .painel-nav a.active {
            background: #003366;
            color: white;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .user-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #e1e5e9;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .user-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .user-card-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fdb913, #f5a623);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #003366;
            font-weight: bold;
        }

        .user-card-info h3 {
            margin: 0 0 0.5rem 0;
            color: #003366;
            font-size: 1.1rem;
        }

        .user-card-info p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .user-card-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            border-radius: 6px;
        }

        .btn-outline-primary {
            background: transparent;
            color: #003366;
            border: 2px solid #003366;
        }

        .btn-outline-primary:hover {
            background: #003366;
            color: white;
        }

        .btn-outline-warning {
            background: transparent;
            color: #fdb913;
            border: 2px solid #fdb913;
        }

        .btn-outline-warning:hover {
            background: #fdb913;
            color: #003366;
        }

        .btn-outline-danger {
            background: transparent;
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #003366;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
        }

        @media (max-width: 768px) {
            .painel-header .container {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .painel-nav ul {
                flex-direction: column;
            }

            .users-grid {
                grid-template-columns: 1fr;
            }

            .user-card-actions {
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
                @if($user['perfil'] === 'admin')
                    <li class="nav-item"><a href="{{ route('cursos.index') }}" class="nav-link">Cursos</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Relatórios</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Configurações</a></li>
                @endif
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
        <div class="painel-header">
            <div class="container">
                <div>
                    <h1 class="painel-title">
                        @if($user['perfil'] === 'admin')
                            Painel Administrativo
                        @else
                            Meu Painel
                        @endif
                    </h1>
                    <p class="painel-subtitle">
                        Bem-vindo(a), {{ $user['nome'] }}!
                    </p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user['nome'], 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h3>{{ $user['nome'] }}</h3>
                        <p>{{ $user['email'] }}</p>
                        <span class="badge badge-{{ $user['perfil'] }}">{{ $user['perfil'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if($user['perfil'] === 'admin')
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ count($users) }}</div>
                        <div class="stat-label">Total de Usuários</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ count(array_filter($users, fn($u) => $u['perfil'] === 'aluno')) }}</div>
                        <div class="stat-label">Alunos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ count(array_filter($users, fn($u) => $u['perfil'] === 'admin')) }}</div>
                        <div class="stat-label">Administradores</div>
                    </div>
                </div>

                <div class="admin-actions" style="margin: 2rem 0;">
                    <a href="{{ route('cursos.index') }}" class="action-card" style="display: inline-block; background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-decoration: none; color: #003366; margin-right: 1rem; transition: transform 0.3s ease;">
                        <div style="text-align: center;">
                            <i class="fas fa-graduation-cap" style="font-size: 2rem; margin-bottom: 0.5rem; color: #fdb913;"></i>
                            <h3 style="margin: 0; font-size: 1.1rem;">Gerenciar Cursos</h3>
                            <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem;">Adicionar, editar e visualizar cursos</p>
                        </div>
                    </a>
                </div>

                <h2 class="section-title">Gerenciar Usuários</h2>
            @else
                <h2 class="section-title">Meus Dados</h2>
            @endif

            <div class="users-grid">
                @foreach($users as $userItem)
                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-card-avatar">
                                {{ strtoupper(substr($userItem['nome'], 0, 1)) }}
                            </div>
                            <div class="user-card-info">
                                <h3>{{ $userItem['nome'] }}</h3>
                                <p>{{ $userItem['email'] }}</p>
                                <span class="badge badge-{{ $userItem['perfil'] }}">
                                    {{ $userItem['perfil'] }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="user-card-actions">
                            <a href="/painel/users/{{ $userItem['id'] }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="/painel/users/{{ $userItem['id'] }}/edit" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            @if($user['perfil'] === 'admin' && $userItem['id'] !== session('user_id'))
                                <form method="POST" action="/painel/users/{{ $userItem['id'] }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Tem certeza que deseja remover este usuário?')">
                                        <i class="fas fa-trash"></i> Remover
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($user['perfil'] === 'admin')
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="/auth/register" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Adicionar Novo Usuário
                    </a>
                </div>
            @endif
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Faculdade UniAlfa. Todos os direitos reservados.</p>
    </footer>

    <script>
        function confirmDelete(userName) {
            return confirm(`Tem certeza que deseja remover o usuário ${userName}?`);
        }

        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>