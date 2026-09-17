@extends('admin.layouts.app')

@section('title', 'Détails de l\'inscription')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails de l'inscription</h1>
    <div>
        <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>Informations de l'inscription</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nom:</strong></div>
                    <div class="col-md-8">{{ $registration->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Email:</strong></div>
                    <div class="col-md-8">{{ $registration->email }}</div>
                </div>
                @if($registration->phone)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Téléphone:</strong></div>
                    <div class="col-md-8">{{ $registration->phone }}</div>
                </div>
                @endif
                @if($registration->message)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Message:</strong></div>
                    <div class="col-md-8">{{ $registration->message }}</div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Date d'inscription:</strong></div>
                    <div class="col-md-8">{{ $registration->created_at->format('d/m/Y à H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Informations du cours</h5>
                <hr>
                @if($registration->course)
                    <p><strong>Titre:</strong> 
                        <a href="{{ route('admin.courses.show', $registration->course->id) }}">
                            {{ $registration->course->title }}
                        </a>
                    </p>
                    @if($registration->course->teacher)
                    <p><strong>Enseignant:</strong> {{ $registration->course->teacher->name }}</p>
                    @endif
                    @if($registration->course->price > 0)
                    <p><strong>Prix:</strong> {{ format_price($registration->course->price) }}</p>
                    @else
                    <p><strong>Prix:</strong> <span class="badge bg-success">Gratuit</span></p>
                    @endif
                @else
                    <p class="text-muted">Le cours associé a été supprimé.</p>
                @endif
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <h5>Statut</h5>
                <hr>
                <form action="{{ route('admin.registrations.updateStatus', $registration->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Statut de l'inscription</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmed" {{ $registration->status == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                            <option value="cancelled" {{ $registration->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i> Mettre à jour le statut
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5>Actions</h5>
                <hr>
                <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i> Supprimer l'inscription
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



