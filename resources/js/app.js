import './bootstrap';
import './dark-mode';

// Sidebar Toggle e Funcionalidades
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.querySelector('.main-wrapper');
    
    if (sidebarToggle && sidebar && mainWrapper) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('collapsed');
            
            // Ajustar margem do conteúdo
            if (sidebar.classList.contains('collapsed')) {
                mainWrapper.style.marginLeft = '80px';
            } else {
                mainWrapper.style.marginLeft = '280px';
            }
        });
    }

    // Add active class based on current route (permitindo múltiplas rotas ativas)
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath && href !== '/') {
            // Remove qualquer '/' no final e compara
            const cleanHref = href.replace(/\/$/, '');
            const cleanPath = currentPath.replace(/\/$/, '');
            
            // Se a rota atual começa com o href OU é exatamente igual
            if (cleanPath.startsWith(cleanHref) || cleanPath === cleanHref) {
                link.classList.add('active');
            }
        }
    });
});
