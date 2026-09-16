@extends('admin.layouts.app')

@section('title', 'Gestion des catégories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tags me-2"></i>
        @if(request('type') === 'shop')
            Catégories produits
        @elseif(request('type') === 'course')
            Catégories formations
        @else
            Gestion des catégories
        @endif
    </h1>
    <a href="{{ route('admin.categories.create', request()->only('type')) }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Nouvelle catégorie
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="type" class="form-label">Filtrer par type</label>
                <select class="form-select" id="type" name="type" onchange="this.form.submit()">
                    <option value="">Tous les types</option>
                    <option value="course" {{ request('type') == 'course' ? 'selected' : '' }}>Formations</option>
                    <option value="blog" {{ request('type') == 'blog' ? 'selected' : '' }}>Blog</option>
                    <option value="shop" {{ request('type') == 'shop' ? 'selected' : '' }}>Produits (boutique)</option>
                    <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Événements</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-times me-2"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Ordre</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <span class="badge bg-info">
                                @if($category->type == 'course') Formations
                                @elseif($category->type == 'blog') Blog
                                @elseif($category->type == 'shop') Produits
                                @elseif($category->type == 'event') Événement
                                @else {{ $category->type }}
                                @endif
                            </span>
                        </td>
                        <td>{{ $category->order }}</td>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucune catégorie trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection



