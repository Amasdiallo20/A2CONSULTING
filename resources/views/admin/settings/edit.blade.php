@extends('admin.layouts.app')

@section('title', 'Paramètres du site')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-cog me-2"></i> Paramètres du site</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.partials.form-errors')
            <h5 class="mb-3">Coordonnées</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom du site *</label>
                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $setting->site_name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Horaires</label>
                    <input type="text" name="opening_hours" class="form-control" value="{{ old('opening_hours', $setting->opening_hours) }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $setting->address) }}">
                </div>
            </div>

            <h5 class="mb-3 mt-2">Réseaux sociaux</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Facebook</label>
                    <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $setting->facebook) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Twitter</label>
                    <input type="text" name="twitter" class="form-control" value="{{ old('twitter', $setting->twitter) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $setting->instagram) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">LinkedIn</label>
                    <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin', $setting->linkedin) }}">
                </div>
            </div>

            <h5 class="mb-3 mt-2">Bannière d'accueil</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $setting->hero_title) }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Sous-titre</label>
                    <textarea name="hero_subtitle" class="form-control" rows="3">{{ old('hero_subtitle', $setting->hero_subtitle) }}</textarea>
                </div>
                <div class="col-md-12">
                    @include('admin.partials.image-field', ['name' => 'hero_image', 'current' => $setting->hero_image, 'label' => 'Image de bannière'])
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Texte du bouton</label>
                    <input type="text" name="hero_button_text" class="form-control" value="{{ old('hero_button_text', $setting->hero_button_text) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Lien du bouton</label>
                    <input type="text" name="hero_button_url" class="form-control" value="{{ old('hero_button_url', $setting->hero_button_url) }}" placeholder="/courses">
                </div>
            </div>

            <h5 class="mb-3 mt-2">À propos</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="about_title" class="form-control" value="{{ old('about_title', $setting->about_title) }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Texte</label>
                    <textarea name="about_text" class="form-control rich-editor" rows="6">{{ old('about_text', $setting->about_text) }}</textarea>
                </div>
                <div class="col-md-12">
                    @include('admin.partials.image-field', ['name' => 'about_image', 'current' => $setting->about_image, 'label' => 'Image À propos'])
                </div>
            </div>

            <h5 class="mb-3 mt-2">Identité visuelle</h5>
            <p class="text-muted">Logo, favicon et décor de la section À propos de l’accueil.</p>
            <div class="row">
                <div class="col-md-4">
                    @include('admin.partials.image-field', ['name' => 'logo_image', 'current' => $setting->logoUrl(), 'label' => 'Logo (en-tête et pied de page)'])
                </div>
                <div class="col-md-4">
                    @include('admin.partials.image-field', ['name' => 'favicon_image', 'current' => $setting->faviconUrl(), 'label' => 'Favicon (onglet du navigateur)'])
                </div>
                <div class="col-md-4">
                    @include('admin.partials.image-field', ['name' => 'about_bg_image', 'current' => $setting->aboutBgUrl(), 'label' => 'Décor À propos (accueil)'])
                </div>
            </div>

            <h5 class="mb-3 mt-2">Bannières des pages</h5>
            <p class="text-muted">Images de fond affichées en haut de chaque page. Envoyez un fichier pour remplacer l’image actuelle.</p>
            <div class="row">
                @foreach(\App\Models\SiteSetting::PAGE_BANNERS as $key => $meta)
                    <div class="col-md-6">
                        @include('admin.partials.image-field', [
                            'name' => 'banner_'.$key,
                            'current' => $setting->pageBanner($key),
                            'label' => $meta['label'],
                            'wide' => true,
                        ])
                    </div>
                @endforeach
            </div>

            <h5 class="mb-3 mt-2">Paiement Mobile Money</h5>
            <p class="text-muted">Numéros qui recevront les paiements des clients.</p>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Orange Money</label>
                    <input type="text" name="orange_money_number" class="form-control" value="{{ old('orange_money_number', $setting->orange_money_number) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">MTN Mobile Money</label>
                    <input type="text" name="mtn_money_number" class="form-control" value="{{ old('mtn_money_number', $setting->mtn_money_number) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Moov Money</label>
                    <input type="text" name="moov_money_number" class="form-control" value="{{ old('moov_money_number', $setting->moov_money_number) }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Enregistrer</button>
        </form>
    </div>
</div>
@endsection
