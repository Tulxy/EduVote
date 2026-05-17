<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'idea_id',
        'choice'
    ];

    // TENTO VZTAH CHYBĚL: Hlas patří konkrétnímu nápadu
    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
