@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" required value="{{ old('nom', $terrain->nom ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
            @foreach(['football' => 'Football', 'basketball' => 'Basketball', 'tennis' => 'Tennis', 'multi_sport' => 'Multi-sport', 'autre' => 'Autre'] as $value => $label)
                <option value="{{ $value }}" @selected(old('type', $terrain->type ?? 'multi_sport') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Surface</label>
        <input type="text" name="surface" class="form-control" required value="{{ old('surface', $terrain->surface ?? 'synthetique') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Capacite</label>
        <input type="number" min="1" name="capacite" class="form-control" value="{{ old('capacite', $terrain->capacite ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Prix / heure</label>
        <input type="number" step="0.01" min="0" name="prix_heure" class="form-control" required value="{{ old('prix_heure', $terrain->prix_heure ?? '0') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Adresse</label>
        <input type="text" name="adresse" class="form-control" required value="{{ old('adresse', $terrain->adresse ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control" value="{{ old('ville', $terrain->ville ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Proprietaire</label>
        <select name="proprietaire_id" class="form-select">
            <option value="">-- Aucun --</option>
            @foreach($proprietaires as $user)
                <option value="{{ $user->id }}" @selected((string) old('proprietaire_id', $terrain->proprietaire_id ?? '') === (string) $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1" @checked(old('actif', $terrain->actif ?? true))>
            <label class="form-check-label" for="actif">Terrain actif</label>
        </div>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $terrain->description ?? '') }}</textarea>
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-check2-circle me-1"></i> Enregistrer
    </button>
    <a href="{{ route('admin.terrains.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>
