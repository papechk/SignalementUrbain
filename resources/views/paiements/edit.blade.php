@extends('layouts.admin')

@section('title', 'Modifier paiement')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.paiements.index') }}" class="text-decoration-none">Paiements</a></li>
<li class="breadcrumb-item active">Modifier</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil me-2"></i>Modifier paiement</h2>
    <p class="text-muted mb-0">{{ $paiement->reference }}</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.paiements.update', $paiement) }}">
            @method('PUT')
            @csrf
            @include('paiements._form')
        </form>
    </div>
</div>
@endsection
