@extends('admin.layouts.app')

@section('title', 'Partenaires')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-handshake me-2"></i> Partenaires</h1>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Nouveau partenaire
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Nom</th>
                        <th>Site</th>
                        <th>Ordre</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $partner)
                    <tr>
                        <td>
                            @if($partner->logo)
                                <img src="{{ asset($partner->logo) }}" alt="" style="height:40px;max-width:90px;object-fit:contain;">
                            @else
                                <span class="badge bg-light text-dark">{{ $partner->initials() }}</span>
                            @endif
                        </td>
                        <td>{{ $partner->name }}</td>
                        <td>
                            @if($partner->website_url)
                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener">Lien</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $partner->sort_order }}</td>
                        <td>
                            @if($partner->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce partenaire ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Aucun partenaire. Ajoutez-en un pour l’afficher sur le site.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $partners->links() }}</div>
    </div>
</div>
@endsection
