<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];
    

    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
    public function getStarRatingText()
    {
        return str_repeat('⭐', $this->rating_star);
    }
}
