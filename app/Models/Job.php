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
            'salary' => 'string',
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

    public function scopeLocation($query, $location)
    {
        if(empty($location)) {
            return $query;
        }

        return $query->where('location', 'like', $location.'%'); // % ne pišemo ispred jer rijetko kad napišemo npr. 'ula' umjesto Pula
    }

    public function scopeMinSalary($query, $minSalary)
    {
        if(empty($minSalary)) {
            return $query;
        }

        return $query->where('salary', '>=', $minSalary);
    }
    public function scopeMaxSalary($query, $maxSalary)
    {
        if(empty($maxSalary)) {
            return $query;
        }

        return $query->where('salary', '<=', $maxSalary);
    }
    public function scopeSalaryRange($query, $minSalary = null, $maxSalary = null)
    {
        return $query->minSalary($minSalary)->maxSalary($maxSalary);
    }

    public function scopeSearch($query, $search)
    {
        if(empty($search)) {
            return $query;
        }

        return $query->where(function($searchQuery) use ($search) {
            $searchQuery
            ->where('title', 'like', "{$search}%")
            ->orWhere('location', 'like', "{$search}%");
        });
    }


    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
