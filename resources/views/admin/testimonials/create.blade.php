@extends('admin.layouts.app')

@section('title', 'Nouveau témoignage')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus me-2"></i> Nouveau témoignage</h1>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Retour</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.testimonials._form')
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Enregistrer</button>
        </form>
    </div>
</div>
@endsection
