<?php

namespace App\Livewire\User;

use App\Models\City;
use App\Models\Province;
use App\Models\Subdistrict;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ProfileService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class UserForm extends Component
{
    private $userRepo, $profileService;

    public $name, $email, $password, $userId,
        $address, $provinceId, $cityId, $subdistrictId,
        $isOpen = false;


    public function boot(UserRepository $userRepository, ProfileService $profileService)
    {
        $this->userRepo = $userRepository;
        $this->profileService = $profileService;
    }

    public function render()
    {
        $provinces = Province::all();
        $cities = City::where('province_id', $this->provinceId)->get();
        $subdistricts = Subdistrict::where('city_id', $this->cityId)->get();

        return view('livewire.user.user-form', [
            'provinces' => $provinces,
            'cities' => $cities,
            'subdistricts' => $subdistricts
        ]);
    }

    #[On('open-user-modal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset([
            'name', 'email', 'password', 'userId',
            'address', 'provinceId', 'cityId', 'subdistrictId'
        ]);
        $this->resetValidation();
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string|max:255',
            'provinceId' => 'required|exists:provinces,id',
            'cityId' => 'required|exists:cities,id',
            'subdistrictId' => 'required|exists:subdistricts,id'
        ];

        if (!empty($this->userId)) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->userId;
            $rules['password'] = 'nullable|string|min:6';
        } else {
            $rules['password'] = 'required|string|min:6';
        }
        
        return $rules;
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            if (empty($this->userId)) {
                $this->password = bcrypt($this->password);
                
                $user = new User();
                $data = $this->only(['name', 'email', 'password']);
                $user = $this->userRepo->save($user->fill($data));

                $this->userId = $user->id;
                $dataProfile = $this->only(['address', 'provinceId', 'cityId', 'subdistrictId', 'userId']);
                $this->profileService->create($dataProfile);
                
                $this->dispatch('open-alert', status: 'success', message: 'User successfully created.');
            } else {
                $user = User::findOrFail($this->userId);

                $this->password = empty($this->password) ? $user->password : bcrypt($this->password);
    
                $data = $this->only(['name', 'email', 'password']);
                $this->userRepo->save($user->fill($data));

                $dataProfile = $this->only(['address', 'provinceId', 'cityId', 'subdistrictId', 'userId']);
                $this->profileService->update($dataProfile);
    
                $this->dispatch('open-alert', status: 'success', message: 'User successfully updated.');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->dispatch('open-alert', status: 'error', message: 'Error creating user: ' . $th->getMessage());
        }

        $this->closeModal();
        $this->dispatch('reset-user-pagination');
    }

    #[On('edit-user')]
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;

        if (!empty($user->profile)) {
            $this->address = $user->profile->address;
            $this->provinceId = $user->profile->province_id;
            $this->cityId = $user->profile->city_id;
            $this->subdistrictId = $user->profile->subdistrict_id;
        }

        $this->openModal();
    }

    public function updatingProvinceId()
    {
        $this->cityId = null;
        $this->subdistrictId = null;
    }

    public function updatingCityId()
    {
        $this->subdistrictId = null;
    }
}
