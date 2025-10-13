<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar {{ $curso['nome'] }} - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .painel-container {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 80px;
        }

        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 700px;
            margin: 2rem auto;
        }

        .form-header {
            background: linear-gradient(135deg, #003366, #004080);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .form-body {
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
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #fdb913;
            box-shadow: 0 0 0 3px rgba(253, 185, 19, 0.1);
        }

        .form-group small {
            color: #666;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: block;
        }

        .image-preview {
            margin-top: 1rem;
            text-align: center;
        }

        .image-preview img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e1e5e9;
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

        .btn-save {
            background: linear-gradient(135deg, #fdb913, #f5a623);
            color: #003366;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #f5a623, #e89611);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(253, 185, 19, 0.3);
            color: #003366;
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
            .form-container {
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
            <a href="/cursos/{{ $curso['id'] }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Voltar ao Curso
            </a>

            <div class="form-container">
                <div class="form-header">
                    <h1>Editar Curso</h1>
                    <p>{{ $curso['nome'] }}</p>
                </div>

                <div class="form-body">
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

                    <form method="POST" action="/cursos/{{ $curso['id'] }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="nome">Nome do Curso</label>
                            <input 
                                type="text" 
                                id="nome" 
                                name="nome" 
                                value="{{ old('nome', $curso['nome']) }}"
                                placeholder="Ex: Administração"
                                required
                            >
                            <small>Nome que aparecerá na listagem de cursos</small>
                        </div>

                        <div class="form-group">
                            <label for="image_url">URL da Imagem</label>
                            <input 
                                type="url" 
                                id="image_url" 
                                name="image_url" 
                                value="{{ old('image_url', $curso['image_url']) }}"
                                placeholder="https://exemplo.com/imagem.jpg"
                                required
                                onchange="previewImage(this.value)"
                            >
                            <small>URL da imagem que representará o curso (formato: JPG, PNG, WebP)</small>
                            <div class="image-preview" id="imagePreview">
                                <img id="previewImg" src="{{ $curso['image_url'] }}" alt="Preview da imagem">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea 
                                id="descricao" 
                                name="descricao" 
                                placeholder="Descreva o curso, suas características principais e diferenciais..."
                                required
                            >{{ old('descricao', $curso['descricao']) }}</textarea>
                            <small>Descrição detalhada do curso (máximo 1000 caracteres)</small>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                            <a href="/cursos/{{ $curso['id'] }}" class="btn btn-secondary">
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

    <script>
        function previewImage(url) {
            const preview = document.getElementById('imagePreview');
            const img = document.getElementById('previewImg');
            
            if (url && url.length > 0) {
                img.src = url;
                img.onload = function() {
                    preview.style.display = 'block';
                };
                img.onerror = function() {
                    preview.style.display = 'none';
                };
            } else {
                preview.style.display = 'none';
            }
        }

        // Contador de caracteres para descrição
        const descricaoField = document.getElementById('descricao');
        descricaoField.addEventListener('input', function() {
            const maxLength = 1000;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            let counterEl = document.getElementById('charCounter');
            if (!counterEl) {
                counterEl = document.createElement('small');
                counterEl.id = 'charCounter';
                counterEl.style.float = 'right';
                this.parentNode.appendChild(counterEl);
            }
            
            counterEl.textContent = `${currentLength}/${maxLength} caracteres`;
            counterEl.style.color = remaining < 50 ? '#dc3545' : '#666';
        });

        // Inicializar contador se já tem conteúdo
        if (descricaoField.value.length > 0) {
            descricaoField.dispatchEvent(new Event('input'));
        }
    </script>
</body>
</html>