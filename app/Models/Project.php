<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    /**
     * The user who created/owns this project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Project has many tasks.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get task counts by status.
     */
    public function taskCountsByStatus(): array
    {
        return [
            'todo' => $this->tasks()->where('status', 'todo')->count(),
            'in_progress' => $this->tasks()->where('status', 'in_progress')->count(),
            'done' => $this->tasks()->where('status', 'done')->count(),
        ];
    }
}
