@extends('admin.layouts.app')

@section('title', 'Témoignages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-quote-left me-2"></i> Témoignages clients</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Nouveau témoignage
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Fonction</th>
                        <th>Avis</th>
                        <th>Note</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $item)
                    <tr>
                        <td>{{ $item->client_name }}</td>
                        <td>{{ $item->roleLine() ?: '—' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->quote, 80) }}</td>
                        <td>{{ $item->rating }}/5</td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.testimonials.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.testimonials.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce témoignage ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Aucun témoignage pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $testimonials->links() }}</div>
    </div>
</div>
@endsection
