@extends('admin.layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tachometer-alt me-2"></i> Tableau de bord</h1>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, rgba(1, 104, 163, 1) 0%, rgba(1, 104, 163, 0.8) 100%);">
            <div class="card-body">
                <h5 class="card-title">Cours</h5>
                <h2>{{ $stats['courses'] }}</h2>
                <small>{{ $stats['active_courses'] }} actifs</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, rgba(235, 174, 98, 1) 0%, rgba(235, 174, 98, 0.8) 100%);">
            <div class="card-body">
                <h5 class="card-title">Inscriptions</h5>
                <h2>{{ $stats['registrations'] }}</h2>
                <small>{{ $stats['pending_registrations'] }} en attente</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, rgba(1, 104, 163, 1) 0%, rgba(1, 104, 163, 0.8) 100%);">
            <div class="card-body">
                <h5 class="card-title">Articles Blog</h5>
                <h2>{{ $stats['blog_posts'] }}</h2>
                <small>{{ $stats['published_posts'] }} publiés</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, rgba(235, 174, 98, 1) 0%, rgba(235, 174, 98, 0.8) 100%);">
            <div class="card-body">
                <h5 class="card-title">Produits</h5>
                <h2>{{ $stats['shop_products'] }}</h2>
                <small>{{ $stats['active_products'] }} actifs</small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-1">Événements</h6>
                <h3>{{ $stats['events'] }}</h3>
                <a href="{{ route('admin.events.index') }}">Gérer</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-1">Services</h6>
                <h3>{{ $stats['services'] }}</h3>
                <a href="{{ route('admin.services.index') }}">Gérer</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-1">Formateurs</h6>
                <h3>{{ $stats['teachers'] }}</h3>
                <a href="{{ route('admin.teachers.index') }}">Gérer</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Inscriptions récentes</h5>
            </div>
            <div class="card-body">
                @if($recentRegistrations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Cours</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRegistrations as $registration)
                            <tr>
                                <td>{{ $registration->name }}</td>
                                <td>{{ $registration->email }}</td>
                                <td>
                                    @if($registration->course)
                                        <a href="{{ route('admin.courses.show', $registration->course->id) }}">
                                            {{ $registration->course->title }}
                                        </a>
                                    @else
                                        <span class="text-muted">Cours supprimé</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'En attente',
                                            'confirmed' => 'Confirmé',
                                            'cancelled' => 'Annulé'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$registration->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$registration->status] ?? ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.registrations.show', $registration->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">Aucune inscription récente.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

