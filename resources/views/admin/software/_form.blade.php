@php
    $software = $software ?? null;
    $modulesText = old('modules_text', $software ? implode("\n", $software->moduleList()) : '');
@endphp
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">Nom *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $software->name ?? '') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug URL</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $software->slug ?? '') }}" placeholder="a2stock">
            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted">Laissé vide, il est généré à partir du nom.</small>
        </div>
        <div class="mb-3">
            <label for="tagline" class="form-label">Accroche</label>
            <input type="text" class="form-control @error('tagline') is-invalid @enderror" id="tagline" name="tagline" value="{{ old('tagline', $software->tagline ?? '') }}">
            @error('tagline')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description courte</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $software->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Présentation</label>
            <textarea class="form-control rich-editor @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content', $software->content ?? '') }}</textarea>
            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="modules_text" class="form-label">Modules (un par ligne)</label>
            <textarea class="form-control @error('modules_text') is-invalid @enderror" id="modules_text" name="modules_text" rows="6" placeholder="Facturation">{{ $modulesText }}</textarea>
            @error('modules_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="youtube_url" class="form-label">Vidéo de présentation (YouTube ou Facebook)</label>
            <input type="text" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $software->youtube_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=... ou https://www.facebook.com/.../videos/...">
            @error('youtube_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted">Collez le lien d’une vidéo YouTube ou d’une vidéo publiée sur votre page Facebook (elle doit être publique).</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Accès démo en ligne</label>
            <input type="text" class="form-control @error('demo_url') is-invalid @enderror mb-2" id="demo_url" name="demo_url" value="{{ old('demo_url', $software->demo_url ?? '') }}" placeholder="https://demo.exemple.com">
            @error('demo_url')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" class="form-control @error('demo_login') is-invalid @enderror" id="demo_login" name="demo_login" value="{{ old('demo_login', $software->demo_login ?? '') }}" placeholder="Identifiant">
                    @error('demo_login')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('demo_password') is-invalid @enderror" id="demo_password" name="demo_password" value="{{ old('demo_password', $software->demo_password ?? '') }}" placeholder="Mot de passe">
                    @error('demo_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <small class="text-muted">Ces identifiants sont affichés publiquement sur la fiche du logiciel.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Captures d’écran</label>
            @if($software && $software->screenshotList())
                <div class="d-flex flex-wrap gap-3 mb-3">
                    @foreach($software->screenshotList() as $shotPath)
                        <label class="d-block border rounded p-2" style="width:140px;">
                            <img src="{{ asset($shotPath) }}" alt="" class="img-thumbnail mb-2" style="width:100%;height:90px;object-fit:cover;">
                            <span class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_screenshots[]" value="{{ $shotPath }}">
                                <span class="form-check-label small">Supprimer</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            @endif
            <input type="file" class="form-control @error('screenshots') is-invalid @enderror @error('screenshots.*') is-invalid @enderror" id="screenshots" name="screenshots[]" accept="image/jpeg,image/png,image/gif,image/webp" multiple>
            @error('screenshots')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            @error('screenshots.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            <small class="text-muted">Plusieurs images possibles (JPG, PNG, WebP — 4 Mo max, 12 au total).</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="sort_order" class="form-label">Ordre d’affichage</label>
            <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $software->sort_order ?? 0) }}">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        @include('admin.partials.image-field', [
            'name' => 'image',
            'label' => 'Image',
            'current' => $software->image ?? null,
        ])
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $software->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Visible sur le site</label>
        </div>
    </div>
</div>
