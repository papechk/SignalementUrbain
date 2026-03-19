<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    use HasFactory;

    protected $table = 'creneaux';

    protected $fillable = [
        'terrain_id',
        'titre',
        'debut',
        'fin',
        'statut',
        'notes',
    ];

    protected $casts = [
        'debut' => 'datetime',
        'fin' => 'datetime',
    ];

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }

    public function getStatutBadgeAttribute(): string
    {
        return match ($this->statut) {
            'disponible' => 'success',
            'reserve' => 'primary',
            'bloque' => 'secondary',
            default => 'secondary',
        };
    }
}
