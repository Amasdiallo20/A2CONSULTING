<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - A2 Consulting</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600,700|Roboto:400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: rgba(1, 104, 163, 1);
            --secondary-color: rgba(235, 174, 98, 1);
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, rgba(1, 104, 163, 0.8) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        
        .login-card h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }
        .brand-logo__mark {
            height: 48px;
            width: auto;
        }
        .brand-logo__text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 0.06em;
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
            font-size: 11px;
            color: #6b7c90;
            margin-top: 2px;
            white-space: nowrap;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: rgba(1, 104, 163, 0.9);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-3">
            @include('partials.brand-logo')
        </div>
        <h2 class="text-center mb-4">
            <i class="fas fa-lock me-2"></i> Administration
        </h2>
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Se souvenir de moi
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
            </button>
        </form>
    </div>
    
    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

