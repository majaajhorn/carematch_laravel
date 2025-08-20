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
}
