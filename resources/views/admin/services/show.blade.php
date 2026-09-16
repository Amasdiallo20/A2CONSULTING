@extends('admin.layouts.app')

@section('title', 'Détails du service')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye me-2"></i> Détails du service</h1>
    <div>
        <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Modifier
        </a>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $service->title }}</h3>
                <p class="text-muted">{{ $service->description }}</p>
                <div class="mt-3">
                    {!! $service->content !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Informations</h5>
                <hr>
                <p><strong>Prix:</strong> 
                    @if($service->price > 0)
                        {{ number_format($service->price, 2) }} GNF
                    @else
                        Sur devis
                    @endif
                </p>
                <p><strong>Type:</strong> <span class="badge bg-secondary">{{ $service->price_type }}</span></p>
                <p><strong>Ordre:</strong> {{ $service->order }}</p>
                <p><strong>Statut:</strong> 
                    @if($service->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </p>
                @if($service->is_featured)
                <p><strong>Mise en avant:</strong> <span class="badge bg-warning">Oui</span></p>
                @endif
                <p><strong>Créé le:</strong> {{ $service->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le:</strong> {{ $service->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection



