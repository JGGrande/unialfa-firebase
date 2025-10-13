<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $curso['nome'] }} - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .painel-container {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 80px;
        }

        .curso-detail {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 800px;
            margin: 2rem auto;
        }

        .curso-detail-header {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .curso-detail-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .curso-detail-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 51, 102, 0.9));
            color: white;
            padding: 2rem;
        }

        .curso-detail-title {
            font-size: 2rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .curso-detail-body {
            padding: 2rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section h3 {
            color: #003366;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #fdb913;
            padding-bottom: 0.5rem;
        }

        .detail-section p {
            color: #666;
            line-height: 1.7;
            font-size: 1rem;
        }

        .curso-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
            flex-wrap: wrap;
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

        .btn-action {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 2px solid;
        }

        .btn-edit {
            background: transparent;
            color: #fdb913;
            border-color: #fdb913;
        }

        .btn-edit:hover {
            background: #fdb913;
            color: #003366;
        }

        .btn-delete {
            background: transparent;
            color: #dc3545;
            border-color: #dc3545;
        }

        .btn-delete:hover {
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
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
        }

        .curso-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e1e5e9;
        }

        .info-card i {
            font-size: 2rem;
            color: #003366;
            margin-bottom: 0.5rem;
        }

        .info-card h4 {
            color: #003366;
            margin: 0.5rem 0;
        }

        .info-card p {
            color: #666;
            margin: 0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .curso-detail {
                margin: 1rem;
                max-width: none;
            }

            .curso-detail-title {
                font-size: 1.5rem;
            }

            .curso-actions {
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
        <div class="container">
            <a href="/cursos" class="back-btn">
                <i class="fas fa-arrow-left"></i> Voltar aos Cursos
            </a>

            <div class="curso-detail">
                <div class="curso-detail-header">
                    <img src="{{ $curso['image_url'] }}" alt="{{ $curso['nome'] }}" onerror="this.src='https://via.placeholder.com/800x300?text=Imagem+Indisponível'">
                    <div class="curso-detail-overlay">
                        <h1 class="curso-detail-title">{{ $curso['nome'] }}</h1>
                    </div>
                </div>

                <div class="curso-detail-body">
                    <div class="curso-info-grid">
                        <div class="info-card">
                            <i class="fas fa-graduation-cap"></i>
                            <h4>Curso Superior</h4>
                            <p>Graduação reconhecida pelo MEC</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-clock"></i>
                            <h4>Duração</h4>
                            <p>Consulte a coordenação</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-calendar"></i>
                            <h4>Modalidade</h4>
                            <p>Presencial</p>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3><i class="fas fa-info-circle"></i> Sobre o Curso</h3>
                        <p>{{ $curso['descricao'] }}</p>
                    </div>

                    @if($user['perfil'] === 'admin')
                        <div class="curso-actions">
                            <a href="/cursos/{{ $curso['id'] }}/edit" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Editar Curso
                            </a>
                            
                            <form method="POST" action="/cursos/{{ $curso['id'] }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" 
                                        onclick="return confirm('Tem certeza que deseja remover este curso?')">
                                    <i class="fas fa-trash"></i> Remover Curso
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Faculdade UniAlfa. Todos os direitos reservados.</p>
    </footer>
</body>
</html>