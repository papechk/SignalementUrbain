@extends('layouts.admin')

@section('title', 'Modifier terrain')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.terrains.index') }}" class="text-decoration-none">Terrains</a></li>
<li class="breadcrumb-item active">Modifier</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil me-2"></i>Modifier terrain</h2>
    <p class="text-muted mb-0">{{ $terrain->nom }}</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.terrains.update', $terrain) }}">
            @method('PUT')
            @include('terrains._form')
        </form>
    </div>
</div>
@endsection
