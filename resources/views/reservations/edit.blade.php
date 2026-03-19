@extends('layouts.admin')

@section('title', 'Modifier reservation')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}" class="text-decoration-none">Reservations</a></li>
<li class="breadcrumb-item active">Modifier</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil me-2"></i>Modifier reservation</h2>
    <p class="text-muted mb-0">{{ $reservation->reference }}</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
            @method('PUT')
            @include('reservations._form')
        </form>
    </div>
</div>
@endsection
