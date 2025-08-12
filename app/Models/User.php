<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Employer;
use App\Models\Jobseeker;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    /*protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'location',
        'password',
        'contact',
        'user_type',
        'user_id',
    ];
    */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user()
    {
        return $this->morphTo();
    }

    public function isJobseeker() 
    {
        return $this->user_type === Jobseeker::class;
    }
    public function isEmployer() 
    {
        return $this->user_type === Employer::class;
    }

    /* helper funkcija ako bude trebala, ali zasad ne treba
    public function getRole() 
    {
        return $this->isJobseeker() ? 'jobseeker' : 'employer';
    }*/
}
