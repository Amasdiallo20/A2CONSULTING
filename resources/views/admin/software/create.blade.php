@extends('admin.layouts.app')

@section('title', 'Nouveau logiciel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nouveau logiciel</h1>
    <a href="{{ route('admin.software.index') }}" class="btn btn-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.software.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.software._form')
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.software.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
