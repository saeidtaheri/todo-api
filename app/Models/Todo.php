<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children');
    }

    public function scopeParentTasks($query)
    {
        return $query->where('parent_id', null);
    }

    public function scopeChilds($query, $parent)
    {
        return $query->where('parent_id', $parent);
    }
}
