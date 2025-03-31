<?php

namespace App\Services;

use App\Models\User;

class HelloWorldService
{
    public function get() : User
    {
        return User::find(1);
    }
}
