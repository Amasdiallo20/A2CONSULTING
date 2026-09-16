<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label ?? 'Image' }}</label>
            @if(!empty($current))
        <div class="mb-2">
            <img src="{{ asset($current) }}" alt="Image actuelle" class="img-thumbnail" style="max-width: {{ $wide ?? false ? '100%' : '200px' }}; max-height: {{ $wide ?? false ? '140px' : '200px' }}; object-fit: cover;">
            <p class="small text-muted mt-1">Image actuelle — choisissez un fichier pour la remplacer</p>
        </div>
    @endif
    <input type="file"
           class="form-control @error($name) is-invalid @enderror"
           id="{{ $name }}"
           name="{{ $name }}"
           accept="image/jpeg,image/png,image/gif,image/webp">
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Cliquez pour parcourir vos fichiers. JPG, PNG, GIF ou WebP — 4 Mo max.</small>
</div>
