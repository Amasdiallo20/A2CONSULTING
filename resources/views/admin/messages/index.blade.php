@extends('admin.layouts.app')

@section('title', 'Messages de contact')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-envelope me-2"></i> Messages</h1>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->subject }}</td>
                    <td>
                        @if($message->is_read)
                            <span class="badge bg-secondary">Lu</span>
                        @else
                            <span class="badge bg-primary">Nouveau</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce message ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Aucun message.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $messages->links() }}
    </div>
</div>
@endsection
