@extends('admin.layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails de l'utilisateur</h1>
    <div>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $user->name }}</h3>
                <p class="text-muted">{{ $user->email }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Informations</h5>
                <hr>
                <p><strong>Rôle:</strong> 
                    @if($user->is_admin)
                        <span class="badge bg-danger">Administrateur</span>
                    @else
                        <span class="badge bg-secondary">Utilisateur</span>
                    @endif
                </p>
                <p><strong>Email vérifié:</strong> 
                    @if($user->email_verified_at)
                        <span class="badge bg-success">Oui</span>
                        <br><small class="text-muted">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                    @else
                        <span class="badge bg-warning">Non</span>
                    @endif
                </p>
                <p><strong>Créé le:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection



