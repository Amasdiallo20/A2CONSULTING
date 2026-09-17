<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset($site?->faviconUrl() ?? 'images/favicon.png') }}" type="image/png">
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600,700|Roboto:400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: rgba(1, 104, 163, 1);
            --secondary-color: rgba(235, 174, 98, 1);
            --admin-sidebar-width: 260px;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            min-height: 100%;
        }

        body {
            background-color: #f4f7fb;
            font-family: 'Roboto', sans-serif;
        }

        .admin-shell {
            display: flex;
            align-items: stretch;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--admin-sidebar-width);
            flex: 0 0 var(--admin-sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, rgba(1, 104, 163, 0.92) 100%);
            color: white;
            padding: 16px 0 24px;
            position: sticky;
            top: 0;
            align-self: flex-start;
            overflow-y: auto;
            max-height: 100vh;
        }

        .sidebar .nav {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar .nav-item {
            list-style: none;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.88);
            padding: 11px 20px;
            border-left: 3px solid transparent;
            text-decoration: none;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-left-color: var(--secondary-color);
        }

        .sidebar .nav-link .badge {
            margin-left: auto;
        }

        .main-content {
            flex: 1 1 auto;
            min-width: 0;
            padding: 24px 28px;
            background: #f4f7fb;
        }

        @media (max-width: 991.98px) {
            .admin-shell {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                flex-basis: auto;
                min-height: 0;
                max-height: none;
                position: relative;
            }
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: rgba(1, 104, 163, 0.9);
            border-color: rgba(1, 104, 163, 0.9);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .brand-logo__mark {
            height: 40px;
            width: auto;
        }
        .brand-logo__text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #1d2025;
            line-height: 1.15;
        }
        .brand-logo__copy {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .brand-logo__slogan {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 9px;
            color: #6b7c90;
            margin-top: 1px;
            white-space: nowrap;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-shell">
            <nav class="sidebar">
                <div>
                    <div class="px-3 mb-4">
                        <div class="bg-white rounded p-2 mb-2 text-center">
                            @include('partials.brand-logo')
                        </div>
                        <small class="text-white-50">Administration</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">
                                <i class="fas fa-chalkboard-teacher me-2"></i> Formateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') && request('type') !== 'shop' ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-tags me-2"></i> Catégories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                                <i class="fas fa-book me-2"></i> Cours
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                                <i class="fas fa-concierge-bell me-2"></i> Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                                <i class="fas fa-calendar-alt me-2"></i> Événements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}" href="{{ route('admin.registrations.index') }}">
                                <i class="fas fa-user-check me-2"></i> Inscriptions
                                @php
                                    $pendingCount = \App\Models\CourseRegistration::where('status', 'pending')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
                                <i class="fas fa-blog me-2"></i> Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.shop.*') ? 'active' : '' }}" href="{{ route('admin.shop.index') }}">
                                <i class="fas fa-shopping-cart me-2"></i> Boutique
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-bag me-2"></i> Commandes
                                @php
                                    $pendingOrders = \Illuminate\Support\Facades\Schema::hasTable('orders')
                                        ? \App\Models\Order::where('status', 'pending')->count()
                                        : 0;
                                @endphp
                                @if($pendingOrders > 0)
                                    <span class="badge bg-warning text-dark ms-2">{{ $pendingOrders }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') && request('type') === 'shop' ? 'active' : '' }}" href="{{ route('admin.categories.index', ['type' => 'shop']) }}">
                                <i class="fas fa-boxes me-2"></i> Catégories produits
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users me-2"></i> Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                                <i class="fas fa-envelope me-2"></i> Messages
                                @php
                                    $unreadMessages = \Illuminate\Support\Facades\Schema::hasTable('contact_messages')
                                        ? \App\Models\ContactMessage::query()->where('is_read', false)->count()
                                        : 0;
                                @endphp
                                @if($unreadMessages > 0)
                                    <span class="badge bg-danger ms-2">{{ $unreadMessages }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
                                <i class="fas fa-cog me-2"></i> Paramètres du site
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent text-white w-100 text-start">
                                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <main class="main-content">
                @php
                    $unreadContactMessages = \Illuminate\Support\Facades\Schema::hasTable('contact_messages')
                        ? \App\Models\ContactMessage::query()->where('is_read', false)->count()
                        : 0;
                @endphp
                @if($unreadContactMessages > 0 && ! request()->routeIs('admin.messages.*'))
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" role="status">
                        <span>
                            <i class="fas fa-envelope me-2"></i>
                            {{ $unreadContactMessages }} nouveau{{ $unreadContactMessages > 1 ? 'x' : '' }} message{{ $unreadContactMessages > 1 ? 's' : '' }} de contact.
                        </span>
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-warning">Voir les messages</a>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>
    </div>

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.4/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        if (document.querySelector('textarea.rich-editor')) {
            tinymce.init({
                selector: 'textarea.rich-editor',
                menubar: false,
                plugins: 'lists link image table autolink',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | removeformat',
                height: 380,
                branding: false,
                promotion: false,
                relative_urls: false,
                convert_urls: true,
                setup: (editor) => {
                    const persist = () => editor.save();
                    editor.on('change keyup undo redo blur', persist);
                },
                images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    fetch('{{ url("/admin/upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                    .then(async (response) => {
                        const data = await response.json();
                        if (!response.ok || !data.location) {
                            reject(data.message || 'Échec de l\'envoi de l\'image');
                            return;
                        }
                        resolve(data.location);
                    })
                    .catch(() => reject('Échec de l\'envoi de l\'image'));
                }),
            });
            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', () => {
                    if (window.tinymce) {
                        tinymce.triggerSave();
                    }
                }, true);
            });
        }
    </script>
    @stack('scripts')
</body>
</html>

