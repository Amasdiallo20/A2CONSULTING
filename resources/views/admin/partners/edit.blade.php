@extends('admin.layouts.app')

@section('title', 'Modifier le partenaire')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit me-2"></i> Modifier le partenaire</h1>
    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Retour</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.partners._form', ['partner' => $partner])
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
