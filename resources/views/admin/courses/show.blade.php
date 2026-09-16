@extends('admin.layouts.app')

@section('title', 'Détails du cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails du cours</h1>
    <div>
        <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $course->title }}</h3>
                @if($course->description)
                <p class="text-muted">{{ $course->description }}</p>
                @endif
                <div class="mt-3">
                    {!! $course->content !!}
                </div>
            </div>
        </div>
        
        @if($course->registrations && $course->registrations->count() > 0)
        <div class="card">
            <div class="card-body">
                <h5>Inscriptions ({{ $course->registrations->count() }})</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->registrations->take(10) as $registration)
                            <tr>
                                <td>{{ $registration->name }}</td>
                                <td>{{ $registration->email }}</td>
                                <td>{{ $registration->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $registration->status == 'approved' ? 'success' : ($registration->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Informations</h5>
                <hr>
                <p><strong>Enseignant:</strong> {{ $course->teacher->name ?? 'Non assigné' }}</p>
                <p><strong>Catégorie:</strong> {{ $course->category->name ?? 'Aucune' }}</p>
                <p><strong>Prix:</strong> 
                    @if($course->price > 0)
                        {{ number_format($course->price, 2) }} GNF
                    @else
                        <span class="badge bg-success">Gratuit</span>
                    @endif
                </p>
                @if($course->duration)
                <p><strong>Durée:</strong> {{ $course->duration }}</p>
                @endif
                <p><strong>Leçons:</strong> {{ $course->lessons_count ?? 0 }}</p>
                <p><strong>Quiz:</strong> {{ $course->quizzes_count ?? 0 }}</p>
                <p><strong>Étudiants:</strong> {{ $course->students_count ?? 0 }}</p>
                <p><strong>Statut:</strong> 
                    @if($course->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </p>
                @if($course->is_featured)
                <p><strong>Mise en avant:</strong> <span class="badge bg-warning">Oui</span></p>
                @endif
                <p><strong>Créé le:</strong> {{ $course->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le:</strong> {{ $course->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection



