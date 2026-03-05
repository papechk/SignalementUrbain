@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Terrain</label>
        <select name="terrain_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($terrains as $terrain)
                <option value="{{ $terrain->id }}" data-prix="{{ $terrain->prix_heure }}" @selected((string) old('terrain_id', $reservation->terrain_id ?? '') === (string) $terrain->id)>
                    {{ $terrain->nom }} ({{ number_format($terrain->prix_heure, 2, ',', ' ') }} MAD/h)
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Client</label>
        <input type="text" class="form-control" name="client_nom" required value="{{ old('client_nom', $reservation->client_nom ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Email client</label>
        <input type="email" class="form-control" name="client_email" value="{{ old('client_email', $reservation->client_email ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Telephone client</label>
        <input type="text" class="form-control" name="client_telephone" value="{{ old('client_telephone', $reservation->client_telephone ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Debut</label>
        <input type="datetime-local" class="form-control" name="debut" required
               value="{{ old('debut', isset($reservation) && $reservation->debut ? $reservation->debut->format('Y-m-d\\TH:i') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Fin</label>
        <input type="datetime-local" class="form-control" name="fin" required
               value="{{ old('fin', isset($reservation) && $reservation->fin ? $reservation->fin->format('Y-m-d\\TH:i') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select">
            @foreach(['en_attente' => 'En attente', 'confirmee' => 'Confirmee', 'annulee' => 'Annulee'] as $value => $label)
                <option value="{{ $value }}" @selected(old('statut', $reservation->statut ?? 'en_attente') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Montant total (optionnel)</label>
        <input type="number" step="0.01" min="0" class="form-control" name="montant_total" value="{{ old('montant_total', $reservation->montant_total ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $reservation->notes ?? '') }}</textarea>
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-check2-circle me-1"></i> Enregistrer
    </button>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>
