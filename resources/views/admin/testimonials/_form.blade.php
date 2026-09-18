@php $testimonial = $testimonial ?? null; @endphp
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="client_name" class="form-label">Nom du client *</label>
            <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name', $testimonial->client_name ?? '') }}" required>
            @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="role" class="form-label">Fonction</label>
                <input type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role" value="{{ old('role', $testimonial->role ?? '') }}" placeholder="Ex. Directeur">
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="company" class="form-label">Organisation</label>
                <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company', $testimonial->company ?? '') }}">
                @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="quote" class="form-label">Témoignage *</label>
            <textarea class="form-control @error('quote') is-invalid @enderror" id="quote" name="quote" rows="5" required maxlength="800">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
            @error('quote')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="rating" class="form-label">Note</label>
                <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating">
                    @for($star = 5; $star >= 1; $star--)
                        <option value="{{ $star }}" @selected((int) old('rating', $testimonial->rating ?? 5) === $star)>{{ $star }} / 5</option>
                    @endfor
                </select>
                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="sort_order" class="form-label">Ordre d’affichage</label>
                <input type="number" min="0" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
            </div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Visible sur le site</label>
        </div>
    </div>
    <div class="col-md-4">
        @include('admin.partials.image-field', [
            'name' => 'photo',
            'label' => 'Photo du client',
            'current' => $testimonial->photo ?? null,
        ])
    </div>
</div>
