<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerQualification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'jobseeker_id',
        'qualification_name',
    ];

    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }
}
