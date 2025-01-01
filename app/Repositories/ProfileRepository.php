<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function save(Profile $profile)
    {
        $profile->save();

        return $profile;
    }
}
