<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_id',
        'title',
        'category',    // PŘIDÁNO: Povolení zápisu kategorie
        'status',      // PŘIDÁNO: Povolení zápisu statusu
        'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }
}
