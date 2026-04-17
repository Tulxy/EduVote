<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'school_id',
        'votes'
    ];

    // Zpětné vazby
    public function user() { return $this->belongsTo(User::class); }
    public function school() { return $this->belongsTo(School::class); }
}
