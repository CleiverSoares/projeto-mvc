/**
 * PROJETO DOAR - SISTEMA DE DARK MODE
 * JavaScript para controle do tema escuro/claro
 */

class DarkModeToggle {
    constructor() {
        this.theme = localStorage.getItem('theme') || this.getSystemTheme();
        this.init();
    }

    init() {
        this.setTheme(this.theme);
        this.createToggleButton();
        this.bindEvents();
    }

    getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    setTheme(theme) {
        this.theme = theme;
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        // Atualizar ícone do botão
        this.updateToggleIcon();
        
        // Disparar evento customizado
        document.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
    }

    toggleTheme() {
        const newTheme = this.theme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
    }

    createToggleButton() {
        // Verificar se o botão já existe
        if (document.getElementById('dark-mode-toggle')) {
            return;
        }

        const toggleButton = document.createElement('button');
        toggleButton.id = 'dark-mode-toggle';
        toggleButton.className = 'dark-mode-toggle';
        toggleButton.innerHTML = this.getToggleIcon();
        toggleButton.setAttribute('aria-label', 'Alternar tema');
        toggleButton.setAttribute('title', 'Alternar entre tema claro e escuro');

        // Adicionar ao navbar
        const navbar = document.querySelector('.navbar-nav');
        if (navbar) {
            const li = document.createElement('li');
            li.className = 'nav-item';
            li.appendChild(toggleButton);
            navbar.appendChild(li);
        }
    }

    getToggleIcon() {
        return this.theme === 'dark' 
            ? '<i class="fas fa-sun"></i>' 
            : '<i class="fas fa-moon"></i>';
    }

    updateToggleIcon() {
        const toggleButton = document.getElementById('darkModeToggle');
        if (toggleButton) {
            const icon = toggleButton.querySelector('i');
            if (icon) {
                icon.className = this.theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
        }
    }

    bindEvents() {
        // Event listener para o botão de toggle
        const toggleButton = document.getElementById('darkModeToggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleTheme();
            });
        }

        // Event listener para mudanças no sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                this.setTheme(e.matches ? 'dark' : 'light');
            }
        });

        // Event listener para mudanças de tema
        document.addEventListener('themeChanged', (e) => {
            this.onThemeChanged(e.detail.theme);
        });
    }

    onThemeChanged(theme) {
        // Atualizar gráficos se existirem
        this.updateCharts(theme);
        
        // Atualizar outros componentes que precisam de ajuste
        this.updateComponents(theme);
    }

    updateCharts(theme) {
        // Se Chart.js estiver disponível, atualizar gráficos
        if (typeof Chart !== 'undefined') {
            Chart.defaults.color = theme === 'dark' 
                ? 'var(--dark-text-primary)' 
                : 'var(--secondary-gray-700)';
            
            Chart.defaults.borderColor = theme === 'dark' 
                ? 'var(--dark-border)' 
                : 'var(--secondary-gray-200)';
        }
    }

    updateComponents(theme) {
        // Atualizar componentes específicos que precisam de ajuste manual
        const components = document.querySelectorAll('[data-theme-dependent]');
        components.forEach(component => {
            component.setAttribute('data-theme', theme);
        });
    }
}

/**
 * PROJETO DOAR - UTILITÁRIOS JAVASCRIPT
 * Funções auxiliares para o sistema
 */

class ProjetoDoarUtils {
    static init() {
        this.initTooltips();
        this.initAlerts();
        this.initConfirmations();
    }

    static initTooltips() {
        // Inicializar tooltips do Bootstrap se disponível
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    static initAlerts() {
        // Auto-hide alerts após 5 segundos
        const alerts = document.querySelectorAll('.alert-custom');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });
    }

    static initConfirmations() {
        // Confirmar exclusões
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-confirm]')) {
                e.preventDefault();
                const message = e.target.closest('[data-confirm]').getAttribute('data-confirm');
                if (confirm(message)) {
                    // Executar ação original
                    const href = e.target.closest('[data-confirm]').getAttribute('href');
                    if (href) {
                        window.location.href = href;
                    }
                }
            }
        });
    }

    static showLoading(element) {
        if (element) {
            element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Carregando...';
            element.disabled = true;
        }
    }

    static hideLoading(element, originalText) {
        if (element) {
            element.innerHTML = originalText;
            element.disabled = false;
        }
    }

    static formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    }

    static formatDate(date) {
        return new Intl.DateTimeFormat('pt-BR').format(new Date(date));
    }

    static formatDateTime(date) {
        return new Intl.DateTimeFormat('pt-BR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    }
}

/**
 * PROJETO DOAR - INICIALIZAÇÃO
 * Executar quando o DOM estiver carregado
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar sistema de dark mode
    const darkModeBtn = document.getElementById('darkModeToggle');
    if (darkModeBtn) {
        darkModeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            // Aplicar novo tema
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Atualizar ícone
            const icon = darkModeBtn.querySelector('i');
            if (icon) {
                icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
        });
        
        // Aplicar tema salvo
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        
        // Atualizar ícone inicial
        const icon = darkModeBtn.querySelector('i');
        if (icon && savedTheme === 'dark') {
            icon.className = 'fas fa-sun';
        }
    }
    
    // Inicializar utilitários
    ProjetoDoarUtils.init();
    
    // Log de inicialização
    console.log('🎨 Projeto Doar - Sistema inicializado com sucesso!');
});

/**
 * PROJETO DOAR - EXPORTS
 * Para uso em outros módulos se necessário
 */

if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        DarkModeToggle,
        ProjetoDoarUtils
    };
}
