<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'posted_date' => 'date',
            'active' => 'boolean',
            'salary' => 'decimal:2',
        ];
    }
    /**
     * Get the employer that posted this job.
     */
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * Scope to only get active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope to get jobs posted recently.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('posted_date', '>=', now()->subDays($days));
    }
}
