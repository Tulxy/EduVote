<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name', 'address', 'student_code'];

    public function users() { return $this->hasMany(User::class); }
    public function ideas() { return $this->hasMany(Idea::class); }
}
