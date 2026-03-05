<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'reference',
        'montant',
        'mode_paiement',
        'statut',
        'date_paiement',
        'transaction_id',
        'notes',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $paiement) {
            if (empty($paiement->reference)) {
                $paiement->reference = 'PAY-' . strtoupper(Str::random(8));
            }
        });
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function getStatutBadgeAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'warning',
            'partiel' => 'info',
            'paye' => 'success',
            'rembourse' => 'secondary',
            'echec' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'En attente',
            'partiel' => 'Partiel',
            'paye' => 'Payé',
            'rembourse' => 'Remboursé',
            'echec' => 'Échec',
            default => ucfirst($this->statut),
        };
    }
}
