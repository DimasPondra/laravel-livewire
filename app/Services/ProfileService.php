<?php

namespace App\Services;

use App\Models\Profile;
use App\Repositories\ProfileRepository;

class ProfileService
{
    private $profileRepo;

    /**
     * Create a new class instance.
     */
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepo = $profileRepository;
    }

    public function create(Array $data)
    {
        $profile = new Profile([
            'address' => $data['address'],
            'province_id' => $data['provinceId'],
            'city_id' => $data['cityId'],
            'subdistrict_id' => $data['subdistrictId'],
            'user_id' => $data['userId']
        ]);

        return $this->profileRepo->save($profile);
    }

    public function update(Array $data)
    {
        $profile = Profile::where('user_id', $data['userId'])->first();
        $profile->address = $data['address'];
        $profile->province_id = $data['provinceId'];
        $profile->city_id = $data['cityId'];
        $profile->subdistrict_id = $data['subdistrictId'];

        return $this->profileRepo->save($profile);
    }
}
