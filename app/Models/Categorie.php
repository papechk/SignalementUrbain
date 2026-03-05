<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'icone',
        'description',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    /**
     * Relation : une catégorie a plusieurs signalements
     */
    public function signalements()
    {
        return $this->hasMany(Signalement::class, 'categorie_id');
    }

    /**
     * Scope : catégories actives uniquement
     */
    public function scopeActives($query)
    {
        return $query->where('actif', true);
    }
}
