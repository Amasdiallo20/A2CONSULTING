@extends('admin.layouts.app')

@section('title', 'Commande '.$order->reference)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Commande {{ $order->reference }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Retour</a>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="row">
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Client</h5>
                <p class="mb-1"><strong>{{ $order->name }}</strong></p>
                <p class="mb-1">{{ $order->email }}</p>
                <p class="mb-1">{{ $order->phone }}</p>
                <p class="mb-1">{{ $order->address }}</p>
                @if($order->notes)<p class="mt-3">{{ $order->notes }}</p>@endif
                <hr>
                <h5>Mobile Money</h5>
                <p class="mb-1">{{ $order->operatorLabel() }}</p>
                <p class="mb-1">N° client : {{ $order->momo_phone ?: '—' }}</p>
                <p class="mb-1">Transaction : {{ $order->payment_reference ?: '—' }}</p>
                <p class="mb-1">Paiement : <strong>{{ $order->paymentStatusLabel() }}</strong></p>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Statut commande</label>
                    <select name="status" class="form-select mb-2">
                        <option value="pending" @selected($order->status==='pending')>En attente</option>
                        <option value="confirmed" @selected($order->status==='confirmed')>Confirmée</option>
                        <option value="cancelled" @selected($order->status==='cancelled')>Annulée</option>
                    </select>
                    <label class="form-label">Statut paiement</label>
                    <select name="payment_status" class="form-select mb-2">
                        <option value="awaiting" @selected($order->payment_status==='awaiting')>En attente de paiement</option>
                        <option value="processing" @selected($order->payment_status==='processing')>Paiement en cours</option>
                        <option value="declared" @selected($order->payment_status==='declared')>Déclaré par le client</option>
                        <option value="paid" @selected($order->payment_status==='paid')>Payé</option>
                        <option value="failed" @selected($order->payment_status==='failed')>Échoué</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
                </form>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="mt-3" onsubmit="return confirm('Supprimer cette commande ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5>Articles</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th>Type</th>
                            <th>Qté</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->item_type === 'course' ? 'Formation' : 'Produit' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ format_price($item->line_total) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <h4 class="text-end">Total : {{ format_price($order->total) }}</h4>
            </div>
        </div>
    </div>
</div>
@endsection
