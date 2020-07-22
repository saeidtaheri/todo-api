<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function todotasks()
    {
        return $this->hasMany(Todo::class)->parenttasks();
    }
}
