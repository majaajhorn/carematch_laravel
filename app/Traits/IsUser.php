<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait IsUser
{
    public function authParent(): MorphOne
    {
        return $this->morphOne(User::class, 'user');
    }
}