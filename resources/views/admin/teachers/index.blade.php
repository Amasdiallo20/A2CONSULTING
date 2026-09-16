@extends('admin.layouts.app')

@section('title', 'Gestion des formateurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-chalkboard-teacher me-2"></i> Gestion des formateurs</h1>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Nouveau formateur
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Titre</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Cours</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->id }}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->title ?? '-' }}</td>
                        <td>{{ $teacher->email ?? '-' }}</td>
                        <td>{{ $teacher->phone ?? '-' }}</td>
                        <td>{{ $teacher->courses_count ?? 0 }}</td>
                        <td>
                            @if($teacher->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                            @if($teacher->is_featured)
                                <span class="badge bg-warning">Mis en avant</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce formateur ?');">
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
                        <td colspan="8" class="text-center">Aucun formateur trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection



