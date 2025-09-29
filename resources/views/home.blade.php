<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <script defer src="{{ asset('js/script.js') }}"></script>
    </head>
    <body>
          <header class="header">
            <nav class="navbar">
                <a href="#home" class="logo">
                    <img src="https://www.alfaumuarama.edu.br/fau/images/logo_novo.png" alt="Logo UniAlfa">
                </a>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="#home" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#cursos" class="nav-link">Cursos</a></li>
                    <li class="nav-item"><a href="#sobre" class="nav-link">Sobre Nós</a></li>
                    <li class="nav-item"><a href="#contato" class="nav-link">Contato</a></li>
                    <li class="nav-item"><a href="/auth/login" class="nav-link">Login</a></li>
                </ul>
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </header>

        <main>
            <section id="home" class="hero">
                <div class="hero-content">
                    <h1 class="hero-title">O seu futuro começa na UniAlfa.</h1>
                    <p class="hero-subtitle">Cursos de graduação e pós-graduação com foco no mercado de trabalho e excelência acadêmica.</p>
                    <a href="#cursos" class="btn btn-primary">Conheça nossos cursos</a>
                </div>
            </section>

            <section id="cursos" class="cursos-section">
                <div class="container">
                    <h2 class="section-title">Cursos Disponíveis</h2>
                    <p class="section-description">Formação de qualidade que prepara você para os desafios do futuro.</p>
                    <div class="cursos-grid">
                        <div class="curso-card">
                            <img src="https://www.alfaumuarama.edu.br//downloads/cursos/1571659223g.jpg" alt="Estudantes de Administração">
                            <div class="curso-info">
                                <h3>Administração</h3>
                                <p>Prepare-se para gerenciar e liderar organizações com uma visão estratégica e inovadora.</p>
                                <a href="#" class="btn btn-secondary">Saiba Mais</a>
                            </div>
                        </div>
                        <div class="curso-card">
                            <img src="https://www.alfaumuarama.edu.br//downloads/cursos/1635342576g.jpg" alt="Estudante de Direito">
                            <div class="curso-info">
                                <h3>Direito</h3>
                                <p>Uma formação sólida para quem busca atuar nas diversas áreas da carreira jurídica.</p>
                                <a href="#" class="btn btn-secondary">Saiba Mais</a>
                            </div>
                        </div>
                        <div class="curso-card">
                            <img src="https://www.alfaumuarama.edu.br//downloads/cursos/1571662070g.jpg" alt="Estudantes de Pedagogia">
                            <div class="curso-info">
                                <h3>Pedagogia</h3>
                                <p>Forme-se para transformar a educação e impactar positivamente a vida de alunos.</p>
                                <a href="#" class="btn btn-secondary">Saiba Mais</a>
                            </div>
                        </div>
                        <div class="curso-card">
                            <img src="https://www.alfaumuarama.edu.br//downloads/cursos/1571230066g.jpg" alt="Laboratório de Engenharia">
                            <div class="curso-info">
                                <h3>Sistemas para Internet</h3>
                                <p>Desenvolva habilidades em programação, design e gestão de projetos para a web.</p>
                                <a href="#" class="btn btn-secondary">Saiba Mais</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="sobre" class="sobre-section">
                <div class="container sobre-container">
                    <div class="sobre-image">
                        <img src="https://www.alfaumuarama.edu.br/fau/images/alfa.jpg" alt="Campus da Faculdade UniAlfa">
                    </div>
                    <div class="sobre-content">
                        <h2 class="section-title">Sobre a UniAlfa</h2>
                        <p>Com anos de tradição em Umuarama e região, a Faculdade UniAlfa se destaca pelo compromisso com a educação de qualidade, formando profissionais competentes e cidadãos conscientes.</p>
                        <p>Nossa missão é promover o desenvolvimento humano e social por meio do ensino, da pesquisa e da extensão, oferecendo um ambiente acadêmico inovador, com infraestrutura moderna e um corpo docente altamente qualificado.</p>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Corpo docente com mestres e doutores.</li>
                            <li><i class="fas fa-check-circle"></i> Infraestrutura completa e moderna.</li>
                            <li><i class="fas fa-check-circle"></i> Cursos com foco na prática e no mercado.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section id="contato" class="contato-section">
                <div class="container">
                    <h2 class="section-title">Entre em Contato</h2>
                    <p class="section-description">Tire suas dúvidas ou agende uma visita. Estamos prontos para atender você!</p>
                    <div class="contato-wrapper">
                        <div class="contato-form">
                            <form id="contactForm">
                                <div class="form-group">
                                    <input type="text" id="name" name="name" placeholder="Seu nome" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" placeholder="Sua mensagem" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                            </form>
                        </div>
                        <div class="contato-info">
                            <h3>Nossas Informações</h3>
                            <p><i class="fas fa-map-marker-alt"></i> Av. Paraná, 7060 - Zona III, Umuarama - PR, 87502-000</p>
                            <p><i class="fas fa-phone"></i> (44) 3621-2850</p>
                            <p><i class="fas fa-envelope"></i> contato@unialfa.com.br</p>
                            <div class="social-icons">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <p>&copy; 2025 Faculdade UniAlfa. Todos os direitos reservados.</p>
        </footer>

        <script src="script.js"></script>
    </body>
</html>
