<?php

namespace App\Models;

use App\Contracts\IsUser as IsUserContract;
use App\Traits\IsUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobseeker extends Model implements IsUserContract
{
    use HasFactory, HasUuids, IsUser;

    protected $fillable = [
    'id',
    'gender',
    'location',
    'contact',
    'english_level',
    'live_in_experience',
    'driving_license',
    'about_yourself',
];

}
