@extends('admin.layouts.app')

@section('title', 'Gestion de la boutique')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-shopping-cart me-2"></i> Gestion de la boutique</h1>
    <div>
        <a href="{{ route('admin.categories.index', ['type' => 'shop']) }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-boxes me-2"></i> Catégories produits
        </a>
        <a href="{{ route('admin.shop.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Nouveau produit
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>
                            @if($product->sale_price)
                                <span class="text-decoration-line-through text-muted">{{ number_format($product->price, 2) }} GNF</span>
                                <span class="text-danger fw-bold">{{ number_format($product->sale_price, 2) }} GNF</span>
                            @else
                                {{ number_format($product->price, 2) }} GNF
                            @endif
                        </td>
                        <td>
                            @if($product->stock_quantity > 0)
                                <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                            @else
                                <span class="badge bg-danger">Rupture</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                            @if($product->is_featured)
                                <span class="badge bg-warning">Mis en avant</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.shop.show', $product->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.shop.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.shop.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
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
                        <td colspan="7" class="text-center">Aucun produit trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection



