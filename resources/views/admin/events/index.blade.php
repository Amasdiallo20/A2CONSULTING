@extends('admin.layouts.app')

@section('title', 'Gestion des événements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-alt me-2"></i> Gestion des événements</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Nouvel événement
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
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Lieu</th>
                        <th>Inscrits</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->event_date->format('d/m/Y') }}</td>
                        <td>
                            @if($event->start_time)
                                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                @if($event->end_time)
                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $event->venue ?? $event->location ?? '-' }}</td>
                        <td>
                            {{ $event->registered_count }}
                            @if($event->capacity)
                                / {{ $event->capacity }}
                            @endif
                        </td>
                        <td>
                            @if($event->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                            @if($event->is_featured)
                                <span class="badge bg-warning">Mis en avant</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
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
                        <td colspan="8" class="text-center">Aucun événement trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection



