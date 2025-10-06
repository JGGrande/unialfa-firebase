<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciar Cursos - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Estilos específicos para gerenciamento de cursos */
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

        .cursos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .curso-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e1e5e9;
        }

        .curso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .curso-card-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .curso-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .curso-card:hover .curso-card-image img {
            transform: scale(1.05);
        }

        .curso-card-content {
            padding: 1.5rem;
        }

        .curso-card-title {
            color: #003366;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .curso-card-description {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .curso-card-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            border-radius: 6px;
            flex: 1;
            text-align: center;
            min-width: 80px;
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

        .add-curso-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .btn-create {
            background: linear-gradient(135deg, #fdb913, #f5a623);
            color: #003366;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-create:hover {
            background: linear-gradient(135deg, #f5a623, #e89611);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(253, 185, 19, 0.3);
            color: #003366;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
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
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
        }

        @media (max-width: 768px) {
            .painel-header .container {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .cursos-grid {
                grid-template-columns: 1fr;
            }

            .curso-card-actions {
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
                <li class="nav-item"><a href="/cursos" class="nav-link">Cursos</a></li>
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
                    <h1 class="painel-title">Gerenciar Cursos</h1>
                    <p class="painel-subtitle">Administre os cursos da UniAlfa</p>
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

            <div class="add-curso-section">
                <a href="/cursos/create" class="btn-create">
                    <i class="fas fa-plus"></i> Adicionar Novo Curso
                </a>
            </div>

            @if(count($cursos) > 0)
                <div class="cursos-grid">
                    @foreach($cursos as $curso)
                        <div class="curso-card">
                            <div class="curso-card-image">
                                <img src="{{ $curso['image_url'] }}" alt="{{ $curso['nome'] }}" onerror="this.src='https://via.placeholder.com/350x200?text=Imagem+Indisponível'">
                            </div>
                            <div class="curso-card-content">
                                <h3 class="curso-card-title">{{ $curso['nome'] }}</h3>
                                <p class="curso-card-description">{{ $curso['descricao'] }}</p>
                                
                                <div class="curso-card-actions">
                                    <a href="/cursos/{{ $curso['id'] }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="/cursos/{{ $curso['id'] }}/edit" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form method="POST" action="/cursos/{{ $curso['id'] }}" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="width: 100%;"
                                                onclick="return confirm('Tem certeza que deseja remover este curso?')">
                                            <i class="fas fa-trash"></i> Remover
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Nenhum curso cadastrado</h3>
                    <p>Comece adicionando o primeiro curso da UniAlfa.</p>
                </div>
            @endif
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Faculdade UniAlfa. Todos os direitos reservados.</p>
    </footer>

    <script>
        // Auto-hide alerts após 5 segundos
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