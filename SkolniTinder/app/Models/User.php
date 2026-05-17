<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'school_id',
        'role',
        'accepted',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relace
    public function school() { return $this->belongsTo(School::class); }
    public function ideas() { return $this->hasMany(Idea::class); }
    public function votedIdeas(): BelongsToMany
    {
        return $this->belongsToMany(Idea::class, 'votes', 'user_id', 'idea_id')
            ->withPivot('choice')
            ->withTimestamps();
    }
}
