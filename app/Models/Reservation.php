<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'terrain_id',
        'user_id',
        'client_nom',
        'client_email',
        'client_telephone',
        'debut',
        'fin',
        'statut',
        'montant_total',
        'notes',
    ];

    protected $casts = [
        'debut' => 'datetime',
        'fin' => 'datetime',
        'montant_total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $reservation) {
            if (empty($reservation->reference)) {
                $reservation->reference = 'RES-' . strtoupper(Str::random(8));
            }
        });
    }

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function scopeDuJour($query)
    {
        return $query->whereDate('debut', today());
    }

    public function getStatutBadgeAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'warning',
            'confirmee' => 'success',
            'annulee' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'En attente',
            'confirmee' => 'Confirmée',
            'annulee' => 'Annulée',
            default => ucfirst($this->statut),
        };
    }
}
