@extends('admin.layouts.app')

@section('title', 'Détails de l\'article')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails de l'article</h1>
    <div>
        <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $blog->title }}</h3>
                @if($blog->excerpt)
                <p class="text-muted">{{ $blog->excerpt }}</p>
                @endif
                <div class="mt-3">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Informations</h5>
                <hr>
                <p><strong>Auteur:</strong> {{ $blog->author->name ?? 'N/A' }}</p>
                <p><strong>Catégorie:</strong> {{ $blog->category->name ?? 'Aucune' }}</p>
                @if($blog->tags)
                <p><strong>Tags:</strong> {{ $blog->tags }}</p>
                @endif
                <p><strong>Statut:</strong> 
                    @if($blog->is_published)
                        <span class="badge bg-success">Publié</span>
                    @else
                        <span class="badge bg-secondary">Brouillon</span>
                    @endif
                </p>
                @if($blog->is_featured)
                <p><strong>Mise en avant:</strong> <span class="badge bg-warning">Oui</span></p>
                @endif
                @if($blog->published_at)
                <p><strong>Date de publication:</strong> {{ \Carbon\Carbon::parse($blog->published_at)->format('d/m/Y H:i') }}</p>
                @endif
                <p><strong>Créé le:</strong> {{ $blog->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le:</strong> {{ $blog->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection



