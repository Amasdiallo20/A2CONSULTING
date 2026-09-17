@extends('admin.layouts.app')

@section('title', 'Gestion des cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-book me-2"></i> Gestion des cours</h1>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Nouveau cours
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Enseignant</th>
                        <th>Catégorie</th>
                        <th>Format</th>
                        <th>Prix</th>
                        <th>Étudiants</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->teacher->name ?? 'N/A' }}</td>
                        <td>{{ $course->category->name ?? 'N/A' }}</td>
                        <td>{{ $course->deliveryModeLabel() }}</td>
                        <td>
                            @if($course->price > 0)
                                {{ format_price($course->price) }}
                            @else
                                <span class="badge bg-success">Gratuit</span>
                            @endif
                        </td>
                        <td>{{ $course->students_count }}</td>
                        <td>
                            @if($course->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
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
                        <td colspan="9" class="text-center">Aucun cours trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection

