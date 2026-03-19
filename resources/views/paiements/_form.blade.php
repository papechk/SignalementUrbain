@csrf
<div class="row g-3">
    @if(!isset($paiement) || !$paiement)
    {{-- Selection reservation (uniquement en creation) --}}
    <div class="col-12">
        <label class="form-label">Reservation</label>
        <select name="reservation_id" class="form-select" required>
            <option value="">-- Choisir une reservation --</option>
            @foreach($reservations as $res)
                <option value="{{ $res->id }}"
                    data-montant="{{ $res->montant_total }}"
                    @selected((string) old('reservation_id', $selectedReservation?->id ?? '') === (string) $res->id)>
                    {{ $res->reference }} — {{ $res->client_nom }} — {{ $res->terrain?->nom ?? '?' }}
                    ({{ number_format($res->montant_total, 0, ',', ' ') }} FCFA)
                </option>
            @endforeach
        </select>
    </div>
    @else
    <div class="col-12">
        <label class="form-label">Reservation</label>
        <input type="text" class="form-control" disabled
               value="{{ $paiement->reservation?->reference }} — {{ $paiement->reservation?->client_nom }}">
    </div>
    @endif

    <div class="col-md-4">
        <label class="form-label">Montant</label>
        <input type="number" step="0.01" min="0" class="form-control" name="montant" required
               value="{{ old('montant', $paiement->montant ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Mode de paiement</label>
        <select name="mode_paiement" class="form-select" required>
            @foreach(['carte' => 'Carte bancaire', 'especes' => 'Especes', 'virement' => 'Virement', 'mobile_money' => 'Mobile Money', 'autre' => 'Autre'] as $val => $label)
                <option value="{{ $val }}" @selected(old('mode_paiement', $paiement->mode_paiement ?? '') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select" required>
            @foreach(['en_attente' => 'En attente', 'partiel' => 'Partiel', 'paye' => 'Payé', 'rembourse' => 'Remboursé', 'echec' => 'Échec'] as $val => $label)
                <option value="{{ $val }}" @selected(old('statut', $paiement->statut ?? 'en_attente') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Date de paiement</label>
        <input type="datetime-local" class="form-control" name="date_paiement"
               value="{{ old('date_paiement', isset($paiement) && $paiement->date_paiement ? $paiement->date_paiement->format('Y-m-d\\TH:i') : '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">ID Transaction</label>
        <input type="text" class="form-control" name="transaction_id"
               value="{{ old('transaction_id', $paiement->transaction_id ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $paiement->notes ?? '') }}</textarea>
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-check2-circle me-1"></i> Enregistrer
    </button>
    <a href="{{ route('admin.paiements.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>
