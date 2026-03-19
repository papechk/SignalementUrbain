@extends('layouts.admin')

@section('title', 'Nouvelle reservation')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}" class="text-decoration-none">Reservations</a></li>
<li class="breadcrumb-item active">Creer</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-plus-circle me-2"></i>Nouvelle reservation</h2>
    <p class="text-muted mb-0">Reserver un creneau sur un terrain</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.reservations.store') }}">
            @include('reservations._form')
        </form>
    </div>
</div>
@endsection
