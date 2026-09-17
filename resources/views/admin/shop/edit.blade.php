@extends('admin.layouts.app')

@section('title', 'Modifier un produit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit me-2"></i> Modifier un produit</h1>
    <a href="{{ route('admin.shop.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.shop.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.partials.form-errors')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $shop->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="author" class="form-label">Auteur</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" 
                               id="author" name="author" value="{{ old('author', $shop->author) }}">
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $shop->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea class="form-control rich-editor @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10">{{ old('content', $shop->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie produit</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id">
                            <option value="">Aucune</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $shop->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <a href="{{ route('admin.categories.create', ['type' => 'shop']) }}">Créer une catégorie produit</a>
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix affiché sur le site (GNF) *</label>
                        <input type="number" step="1" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', integer_price($shop->price)) }}" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="sale_price" class="form-label">Prix promo (GNF)</label>
                        <small class="form-text text-muted">Optionnel. S’il est inférieur au prix, c’est ce montant qui s’affiche.</small>
                        <input type="number" step="1" class="form-control @error('sale_price') is-invalid @enderror" 
                               id="sale_price" name="sale_price" value="{{ old('sale_price', $shop->sale_price !== null ? integer_price($shop->sale_price) : '') }}" min="0">
                        @error('sale_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Stock *</label>
                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                               id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $shop->stock_quantity) }}" min="0" required>
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU (Code produit)</label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                               id="sku" name="sku" value="{{ old('sku', $shop->sku) }}" placeholder="ex: PROD-001">
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @include('admin.partials.image-field', ['name' => 'image', 'current' => $shop->image, 'label' => 'Image principale (vue de face)'])
                    @include('admin.partials.image-field', ['name' => 'image_secondary', 'current' => $shop->image_secondary, 'label' => '2e image (profil, dos ou détail)'])
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" {{ old('is_featured', $shop->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Mise en avant
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $shop->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Actif
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Enregistrer
                </button>
                <a href="{{ route('admin.shop.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection



