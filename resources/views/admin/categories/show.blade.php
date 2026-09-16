@extends('admin.layouts.app')

@section('title', 'Détails de la catégorie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails de la catégorie</h1>
    <div>
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $category->name }}</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Type:</strong></div>
                    <div class="col-md-8">
                        <span class="badge bg-info">
                        @if($category->type == 'course') Formations
                        @elseif($category->type == 'blog') Blog
                        @elseif($category->type == 'shop') Produits
                        @elseif($category->type == 'event') Événement
                            @else {{ $category->type }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Ordre:</strong></div>
                    <div class="col-md-8">{{ $category->order }}</div>
                </div>
                @if($category->description)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Description:</strong></div>
                    <div class="col-md-8">{{ $category->description }}</div>
                </div>
                @endif
                @if($category->icon)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Icône:</strong></div>
                    <div class="col-md-8">
                        <i class="{{ $category->icon }}"></i> {{ $category->icon }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Statut</h5>
                <hr>
                <p>
                    @if($category->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5>Actions</h5>
                <hr>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



