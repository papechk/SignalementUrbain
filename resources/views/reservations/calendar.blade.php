@extends('layouts.admin')

@section('title', 'Calendrier')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}" class="text-decoration-none">Reservations</a></li>
<li class="breadcrumb-item active">Calendrier</li>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
    #calendar { min-height: 600px; }
    .fc-event { cursor: pointer; border-radius: 6px; padding: 2px 6px; font-size: 0.8rem; }
</style>
@endpush

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-calendar3 me-2"></i>Calendrier des reservations</h2>
        <p class="text-muted mb-0">Vue mensuelle des creneaux et reservations</p>
    </div>
    <div class="d-flex gap-2">
        <select id="terrainFilter" class="form-select form-select-sm" style="width:220px">
            <option value="">Tous les terrains</option>
            @foreach($terrains as $terrain)
                <option value="{{ $terrain->id }}">{{ $terrain->nom }}</option>
            @endforeach
        </select>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-list me-1"></i> Liste
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const terrainFilter = document.getElementById('terrainFilter');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
        events: function(info, successCallback, failureCallback) {
            const params = new URLSearchParams({
                start: info.startStr,
                end: info.endStr,
                terrain_id: terrainFilter.value
            });
            fetch("{{ route('admin.reservations.events') }}?" + params)
                .then(r => r.json())
                .then(successCallback)
                .catch(failureCallback);
        },
        eventClick: function(info) {
            const id = info.event.id;
            if (id.startsWith('reservation-')) {
                window.location.href = "{{ url('admin/reservations') }}/" + id.replace('reservation-', '');
            }
        }
    });

    calendar.render();

    terrainFilter.addEventListener('change', function() {
        calendar.refetchEvents();
    });
});
</script>
@endpush
