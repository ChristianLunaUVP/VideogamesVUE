<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platforms extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function videogames() : BelongsToMany
    {
        return $this->belongsToMany(Videogames::class, 'platforms_videogames', 'platforms_id', 'videogames_id');
    }
}
