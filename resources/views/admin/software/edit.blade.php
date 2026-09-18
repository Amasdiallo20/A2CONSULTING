@extends('admin.layouts.app')

@section('title', 'Modifier '.$software->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier {{ $software->name }}</h1>
    <a href="{{ route('admin.software.index') }}" class="btn btn-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.software.update', $software) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.software._form', ['software' => $software])
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.software.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
