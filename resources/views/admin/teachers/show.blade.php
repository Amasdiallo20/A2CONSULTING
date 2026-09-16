@extends('admin.layouts.app')

@section('title', 'Détails du formateur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails du formateur</h1>
    <div>
        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $teacher->name }}</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Titre:</strong></div>
                    <div class="col-md-8">{{ $teacher->title ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Poste:</strong></div>
                    <div class="col-md-8">{{ $teacher->position ?? '-' }}</div>
                </div>
                @if($teacher->email)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Email:</strong></div>
                    <div class="col-md-8">{{ $teacher->email }}</div>
                </div>
                @endif
                @if($teacher->phone)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Téléphone:</strong></div>
                    <div class="col-md-8">{{ $teacher->phone }}</div>
                </div>
                @endif
                @if($teacher->bio)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Biographie:</strong></div>
                    <div class="col-md-8">{{ $teacher->bio }}</div>
                </div>
                @endif
                @if($teacher->description)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Description:</strong></div>
                    <div class="col-md-8">{{ $teacher->description }}</div>
                </div>
                @endif
            </div>
        </div>
        
        @if($teacher->courses->count() > 0)
        <div class="card">
            <div class="card-body">
                <h5>Cours associés ({{ $teacher->courses->count() }})</h5>
                <hr>
                <ul>
                    @foreach($teacher->courses as $course)
                    <li>
                        <a href="{{ route('admin.courses.show', $course->id) }}">{{ $course->title }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Statut</h5>
                <hr>
                <p>
                    @if($teacher->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                    @if($teacher->is_featured)
                        <span class="badge bg-warning">Mis en avant</span>
                    @endif
                </p>
                <p><strong>Cours:</strong> {{ $teacher->courses_count ?? 0 }}</p>
                <p><strong>Étudiants:</strong> {{ $teacher->students_count ?? 0 }}</p>
            </div>
        </div>
        
        @if($teacher->facebook || $teacher->twitter || $teacher->linkedin || $teacher->instagram)
        <div class="card mb-4">
            <div class="card-body">
                <h5>Réseaux sociaux</h5>
                <hr>
                @if($teacher->facebook)
                <p><a href="{{ $teacher->facebook }}" target="_blank"><i class="fab fa-facebook me-2"></i> Facebook</a></p>
                @endif
                @if($teacher->twitter)
                <p><a href="{{ $teacher->twitter }}" target="_blank"><i class="fab fa-twitter me-2"></i> Twitter</a></p>
                @endif
                @if($teacher->linkedin)
                <p><a href="{{ $teacher->linkedin }}" target="_blank"><i class="fab fa-linkedin me-2"></i> LinkedIn</a></p>
                @endif
                @if($teacher->instagram)
                <p><a href="{{ $teacher->instagram }}" target="_blank"><i class="fab fa-instagram me-2"></i> Instagram</a></p>
                @endif
            </div>
        </div>
        @endif
        
        <div class="card">
            <div class="card-body">
                <h5>Actions</h5>
                <hr>
                <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce formateur ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



