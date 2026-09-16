@extends('admin.layouts.app')

@section('title', 'Message')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Message de {{ $message->name }}</h1>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        <p><strong>Email :</strong> {{ $message->email }}</p>
        <p><strong>Téléphone :</strong> {{ $message->phone ?: '—' }}</p>
        <p><strong>Sujet :</strong> {{ $message->subject ?: '—' }}</p>
        <p><strong>Date :</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>
        <hr>
        <p>{!! nl2br(e($message->message)) !!}</p>
    </div>
</div>
@endsection
