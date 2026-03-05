<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Signalement extends Model
{
    use HasFactory;

    protected $table = 'signalements';

    protected $fillable = [
        'reference',
        'titre',
        'description',
        'categorie_id',
        'adresse',
        'quartier',
        'latitude',
        'longitude',
        'statut',
        'priorite',
        'photo',
        'signale_par',
        'email_signaleur',
        'telephone_signaleur',
        'commentaire_mairie',
        'date_resolution',
    ];

    protected $casts = [
        'date_resolution' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Génère automatiquement une référence unique à la création
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($signalement) {
            if (empty($signalement->reference)) {
                $signalement->reference = 'SIG-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Relation : un signalement appartient à une catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Obtenir la couleur du badge selon le statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return match ($this->statut) {
            'nouveau'  => 'primary',
            'en_cours' => 'warning',
            'resolu'   => 'success',
            'rejete'   => 'danger',
            default    => 'secondary',
        };
    }

    /**
     * Obtenir la couleur du badge selon la priorité
     */
    public function getPrioriteBadgeAttribute(): string
    {
        return match ($this->priorite) {
            'faible'  => 'info',
            'moyenne' => 'primary',
            'haute'   => 'warning',
            'urgente' => 'danger',
            default   => 'secondary',
        };
    }

    /**
     * Obtenir le libellé du statut
     */
    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'nouveau'  => 'Nouveau',
            'en_cours' => 'En cours',
            'resolu'   => 'Résolu',
            'rejete'   => 'Rejeté',
            default    => $this->statut,
        };
    }

    /**
     * Scope : filtrer par statut
     */
    public function scopeParStatut($query, string $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope : filtrer par priorité
     */
    public function scopeParPriorite($query, string $priorite)
    {
        return $query->where('priorite', $priorite);
    }

    /**
     * Scope : filtrer par catégorie
     */
    public function scopeParCategorie($query, int $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }
}
