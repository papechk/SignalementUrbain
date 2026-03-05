@extends('layouts.admin')

@section('title', 'Nouveau terrain')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.terrains.index') }}" class="text-decoration-none">Terrains</a></li>
<li class="breadcrumb-item active">Creer</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-plus-circle me-2"></i>Nouveau terrain</h2>
    <p class="text-muted mb-0">Ajouter un terrain a la plateforme</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.terrains.store') }}">
            @include('terrains._form')
        </form>
    </div>
</div>
@endsection
