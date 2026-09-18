@extends('admin.layouts.app')

@section('title', 'Nouveau partenaire')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus me-2"></i> Nouveau partenaire</h1>
    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Retour</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.partners._form')
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Enregistrer</button>
        </form>
    </div>
</div>
@endsection
