<?php

namespace App\Models;

use App\Contracts\IsUser as IsUserContract;
use App\Traits\IsUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobseekerQualification;
use App\Models\JobseekerExperience;
use App\Models\SavedJob;

class Jobseeker extends Model implements IsUserContract
{
    use HasFactory, HasUuids, IsUser;

    protected $guarded = ['id'];

    // Koristimo casts 'boolean' jer kad fetchamo model, dobit ćemo true/false umjesto 1/0
    protected $casts = [
        'driving_license' => 'boolean',
    ];
    
    public function authParent()
    {
        return $this->morphOne(User::class, 'user');
    }

    public function qualifications()
    {
        return $this->hasMany(JobseekerQualification::class);
    }

    public function experiences()
    {
        return $this->hasMany(JobseekerExperience::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    public function appliedJobs()
    {
        return $this->belongsToMany(Job::class, 'applications', 'jobseeker_id', 'job_id')->withTimestamps();
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function getAverageRating()
    {
        return $this->reviews()->avg('rating_star') ?? 0;
    }
    public function getTotalReviews()
    {
        return $this->reviews()->count();
    }
    /**
 * Scope to filter by location
 */
public function scopeLocation($query, $location)
{
    if (empty($location)) {
        return $query;
    }

    return $query->whereHas('authParent', function($q) use ($location) {
        $q->where('location', 'like', $location. '%');
    });
}

/**
 * Scope to filter by gender
 */
public function scopeGender($query, $gender)
{
    if (empty($gender)) {
        return $query;
    }

    return $query->where('gender', $gender);
}

/**
 * Scope to filter by qualification
 */
public function scopeQualification($query, $qualification)
{
    if (empty($qualification)) {
        return $query;
    }

    return $query->whereHas('qualifications', function($q) use ($qualification) {
        $q->where('qualification_name', 'like', $qualification. '%');
    });
}

/**
 * Scope to filter by experiences
 */
public function scopeExperience($query, $experience)
{
    if (empty($experience)) {
        return $query;
    }

    return $query->whereHas('experiences', function($q) use ($experience) {
        $q->where('job_title', 'like', $experience. '%');
    });
}

/**
 * Scope to search in multiple fields
 */
public function scopeSearch($query, $search)
{
    if (empty($search)) {
        return $query;
    }

    return $query->where(function($searchQuery) use ($search) {
        $searchQuery->whereHas('authParent', function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        })
        ->orWhere('about_yourself', 'like', "%{$search}%")
        ->orWhereHas('qualifications', function($q) use ($search) {
            $q->where('qualification_name', 'like', "%{$search}%");
        })
        ->orWhereHas('experiences', function($q) use ($search) {
            $q->where('job_title', 'like', "%{$search}%");
        });
    });
}
}
