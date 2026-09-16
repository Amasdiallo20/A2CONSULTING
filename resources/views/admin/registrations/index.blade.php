@extends('admin.layouts.app')

@section('title', 'Gestion des inscriptions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user-check me-2"></i> Gestion des inscriptions</h1>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.registrations.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Filtrer par statut</label>
                <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="course_id" class="form-label">Filtrer par cours</label>
                <select class="form-select" id="course_id" name="course_id" onchange="this.form.submit()">
                    <option value="">Tous les cours</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-times me-2"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Cours</th>
                        <th>Date d'inscription</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                    <tr>
                        <td>{{ $registration->id }}</td>
                        <td>{{ $registration->name }}</td>
                        <td>{{ $registration->email }}</td>
                        <td>{{ $registration->phone ?? '-' }}</td>
                        <td>
                            @if($registration->course)
                                <a href="{{ route('admin.courses.show', $registration->course->id) }}">
                                    {{ $registration->course->title }}
                                </a>
                            @else
                                <span class="text-muted">Cours supprimé</span>
                            @endif
                        </td>
                        <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.registrations.updateStatus', $registration->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto; display: inline-block;">
                                    <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="confirmed" {{ $registration->status == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                                    <option value="cancelled" {{ $registration->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.registrations.show', $registration->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Aucune inscription trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $registrations->links() }}
        </div>
    </div>
</div>
@endsection



