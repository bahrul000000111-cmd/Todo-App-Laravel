<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Todo extends Model
{
    protected $fillable = [
        'user_id', 
        'title', 
        'description', 
        'is_completed', 
        'due_date'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }

    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }
}