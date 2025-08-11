<?php

namespace App\Models;

use App\Contracts\IsUser as IsUserContract;
use App\Traits\IsUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model implements IsUserContract
{
    use HasFactory, HasUuids, IsUser;

    protected $guarded = ['id'];

    public function authParent()
    {
        return $this->morphOne(User::class, 'user');
    }
}
