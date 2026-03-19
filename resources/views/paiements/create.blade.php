@extends('layouts.admin')

@section('title', 'Nouveau paiement')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.paiements.index') }}" class="text-decoration-none">Paiements</a></li>
<li class="breadcrumb-item active">Creer</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-plus-circle me-2"></i>Nouveau paiement</h2>
    <p class="text-muted mb-0">Enregistrer un paiement pour une reservation</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.paiements.store') }}">
            @csrf
            @include('paiements._form', ['paiement' => null])
        </form>
    </div>
</div>
@endsection
