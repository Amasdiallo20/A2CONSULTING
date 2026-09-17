@extends('admin.layouts.app')

@section('title', 'Commandes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-shopping-bag me-2"></i> Commandes</h1>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Tous les statuts</option>
                    <option value="pending" @selected(request('status')==='pending')>En attente</option>
                    <option value="confirmed" @selected(request('status')==='confirmed')>Confirmée</option>
                    <option value="cancelled" @selected(request('status')==='cancelled')>Annulée</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Articles</th>
                    <th>Date</th>
                    <th>Paiement</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->reference }}</td>
                    <td>{{ $order->name }}<br><small>{{ $order->email }}</small></td>
                    <td>{{ format_price($order->total) }}</td>
                    <td>{{ $order->items_count }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <small>{{ $order->operatorLabel() }}</small><br>
                        @if($order->payment_status === 'paid')
                            <span class="badge bg-success">Payé</span>
                        @elseif($order->payment_status === 'declared')
                            <span class="badge bg-info">À vérifier</span>
                        @elseif($order->payment_status === 'processing')
                            <span class="badge bg-warning text-dark">En cours</span>
                        @else
                            <span class="badge bg-secondary">{{ $order->paymentStatusLabel() }}</span>
                        @endif
                    </td>
                    <td>
                        @if($order->status === 'confirmed')
                            <span class="badge bg-success">Confirmée</span>
                        @elseif($order->status === 'cancelled')
                            <span class="badge bg-danger">Annulée</span>
                        @else
                            <span class="badge bg-warning text-dark">En attente</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</div>
@endsection
