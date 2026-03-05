<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Terrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'type',
        'surface',
        'capacite',
        'prix_heure',
        'adresse',
        'ville',
        'proprietaire_id',
        'description',
        'actif',
    ];

    protected $casts = [
        'prix_heure' => 'decimal:2',
        'actif' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $terrain) {
            if (empty($terrain->slug)) {
                $terrain->slug = Str::slug($terrain->nom);
            }
        });
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    public function creneaux()
    {
        return $this->hasMany(Creneau::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'football' => 'Football',
            'basketball' => 'Basket',
            'tennis' => 'Tennis',
            'multi_sport' => 'Multi-sport',
            default => 'Autre',
        };
    }
}
