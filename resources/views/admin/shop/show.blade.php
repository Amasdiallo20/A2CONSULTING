@extends('admin.layouts.app')

@section('title', 'Détails du produit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails du produit</h1>
    <div>
        <a href="{{ route('admin.shop.edit', $shop->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.shop.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $shop->title }}</h3>
                @if($shop->author)
                <p class="text-muted">Par {{ $shop->author }}</p>
                @endif
                @if($shop->description)
                <p class="text-muted">{{ $shop->description }}</p>
                @endif
                <div class="mt-3">
                    {!! $shop->content !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Informations</h5>
                <hr>
                <p><strong>Prix:</strong> 
                    @if($shop->hasPromo())
                        <span class="text-decoration-line-through text-muted">{{ format_price($shop->price) }}</span>
                        <span class="text-danger fw-bold">{{ format_price($shop->sale_price) }}</span>
                    @else
                        {{ format_price($shop->price) }}
                    @endif
                </p>
                <p><strong>Stock:</strong> 
                    @if($shop->stock_quantity > 0)
                        <span class="badge bg-success">{{ $shop->stock_quantity }}</span>
                    @else
                        <span class="badge bg-danger">Rupture de stock</span>
                    @endif
                </p>
                @if($shop->sku)
                <p><strong>SKU:</strong> {{ $shop->sku }}</p>
                @endif
                <p><strong>Catégorie produit:</strong> {{ $shop->category->name ?? 'Aucune' }}</p>
                <p><strong>Statut:</strong> 
                    @if($shop->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </p>
                @if($shop->is_featured)
                <p><strong>Mise en avant:</strong> <span class="badge bg-warning">Oui</span></p>
                @endif
                <p><strong>Créé le:</strong> {{ $shop->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le:</strong> {{ $shop->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection



