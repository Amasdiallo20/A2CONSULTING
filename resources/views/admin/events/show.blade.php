@extends('admin.layouts.app')

@section('title', 'Détails de l\'événement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails de l'événement</h1>
    <div>
        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $event->title }}</h3>
                <p class="text-muted">{{ $event->description }}</p>
                <div class="mt-3">
                    {!! $event->content !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Informations</h5>
                <hr>
                <p><strong>Date:</strong> {{ $event->event_date->format('d/m/Y') }}</p>
                @if($event->start_time)
                <p><strong>Heure:</strong> 
                    {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                    @if($event->end_time)
                        - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                    @endif
                </p>
                @endif
                @if($event->location || $event->venue)
                <p><strong>Lieu:</strong> {{ $event->venue ?? $event->location }}</p>
                @endif
                @if($event->capacity)
                <p><strong>Capacité:</strong> {{ $event->registered_count }} / {{ $event->capacity }}</p>
                @else
                <p><strong>Inscrits:</strong> {{ $event->registered_count }}</p>
                @endif
                <p><strong>Prix:</strong> 
                    @if($event->price > 0)
                        {{ number_format($event->price, 2) }} GNF
                    @else
                        Gratuit
                    @endif
                </p>
                <p><strong>Statut:</strong> 
                    @if($event->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </p>
                @if($event->is_featured)
                <p><strong>Mise en avant:</strong> <span class="badge bg-warning">Oui</span></p>
                @endif
                <p><strong>Créé le:</strong> {{ $event->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le:</strong> {{ $event->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection



