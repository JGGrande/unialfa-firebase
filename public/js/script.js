document.addEventListener("DOMContentLoaded", function() {
    // Funcionalidade do Menu Hamburger
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");
    const navLinks = document.querySelectorAll(".nav-link");

    hamburger.addEventListener("click", () => {
        hamburger.classList.toggle("active");
        navMenu.classList.toggle("active");
    });

    // Fecha o menu ao clicar em um link
    navLinks.forEach(link => link.addEventListener("click", () => {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
    }));

    // Efeito de sombra no header ao rolar a página
    const header = document.querySelector('.header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        } else {
            header.style.backgroundColor = '#fff';
            header.style.boxShadow = 'none';
        }
    });

    // Validação do Formulário de Contato
    const contactForm = document.getElementById('contactForm');
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        // Validação simples
        if (name.trim() === '' || email.trim() === '' || message.trim() === '') {
            alert('Por favor, preencha todos os campos.');
            return;
        }

        // Simulação de envio
        alert(`Obrigado pelo seu contato, ${name}! Sua mensagem foi enviada.`);
        
        // Limpa o formulário após o "envio"
        contactForm.reset();
    });

});