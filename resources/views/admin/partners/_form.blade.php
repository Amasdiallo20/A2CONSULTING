@php $partner = $partner ?? null; @endphp
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">Nom *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $partner->name ?? '') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="website_url" class="form-label">Site web</label>
            <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url" value="{{ old('website_url', $partner->website_url ?? '') }}" placeholder="https://">
            @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="sort_order" class="form-label">Ordre d’affichage</label>
            <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted">Plus le chiffre est petit, plus le logo apparaît tôt.</small>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $partner->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Visible sur le site</label>
        </div>
    </div>
    <div class="col-md-4">
        @include('admin.partials.image-field', [
            'name' => 'logo',
            'label' => 'Logo',
            'current' => $partner->logo ?? null,
            'wide' => true,
        ])
    </div>
</div>
