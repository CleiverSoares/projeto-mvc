<!doctype html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Projeto Doar') - Sistema de Gestão</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Overlay para mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-brand">
                <span class="brand-icon">
                    <i class="fas fa-heart"></i>
                </span>
                <span class="brand-text">Projeto Doar</span>
            </div>

            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pessoas.index') }}" class="nav-link {{ request()->routeIs('pessoas.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Pessoas</span>
                        </a>
                    </li>
                    @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                    <li class="nav-item">
                        <a href="{{ route('pessoas.create') }}" class="nav-link {{ request()->routeIs('pessoas.create') ? 'active' : '' }}">
                            <i class="fas fa-user-plus"></i>
                            <span>Cadastrar Pessoa</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('projetos.index') }}" class="nav-link {{ request()->routeIs('projetos.*') ? 'active' : '' }}">
                            <i class="fas fa-project-diagram"></i>
                            <span>Projetos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categorias.index') }}" class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Categorias</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('eventos.index') }}" class="nav-link {{ request()->routeIs('eventos.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Eventos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doacoes.index') }}" class="nav-link {{ request()->routeIs('doacoes.*') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding-heart"></i>
                            <span>Doações</span>
                        </a>
                    </li>
                    @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                    <li class="nav-item">
                        <a href="{{ route('relatorios.index') }}" class="nav-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Relatórios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('configuracoes.index') }}" class="nav-link {{ request()->routeIs('configuracoes.*') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i>
                            <span>Configurações</span>
                        </a>
                    </li>
                    @endif
                    @if(in_array(auth()->user()->role ?? 'usuario', ['admin']))
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <span>Gerenciar Usuários</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-wrapper">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb">
                        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="topbar-right">
                    <button class="btn-icon" id="darkModeToggle" title="Alternar tema">
                        <i class="fas fa-moon"></i>
                    </button>
                    
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none user-menu" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user-circle"></i>
                                    @endif
                                </div>
                                <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.show', auth()->id()) }}">
                                        <i class="fas fa-user-circle me-2"></i>Meu Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @endauth
                </div>
            </header>

            <!-- Content Area -->
            <main class="content-area">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="footer">
                <div class="footer-content">
                    <p>&copy; 2025 Projeto Doar - Todos os direitos reservados</p>
                    <p>Desenvolvido com <i class="fas fa-heart text-danger"></i> para o projeto social</p>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
