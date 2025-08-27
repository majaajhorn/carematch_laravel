<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ApplicationStatus::class,
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }
    public function isPending()
    {
        return $this->status === ApplicationStatus::Pending;
    }

    public function isApproved()
    {
        return $this->status === ApplicationStatus::Approved;
    }
    
    public function isRejected()
    {
        return $this->status === ApplicationStatus::Rejected;
    }
}
