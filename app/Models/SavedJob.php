<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['job_id', 'jobseeker_id'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }
}
