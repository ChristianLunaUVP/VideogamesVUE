<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Videogames extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'genre',
        'image',
    ];

    public function platforms() : BelongsToMany
    {
        return $this->belongsToMany(Platforms::class, 'platforms_videogames');
    }
}
