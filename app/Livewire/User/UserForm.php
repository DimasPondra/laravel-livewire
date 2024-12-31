<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class UserForm extends Component
{
    private $userRepo;

    public $name, $email, $password, $userId,
        $isOpen = false;

    public function boot(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function render()
    {
        return view('livewire.user.user-form');
    }

    #[On('open-user-modal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'email', 'password', 'userId']);
        $this->resetValidation();
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
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

                $this->userRepo->save($user->fill($data));
                
                $this->dispatch('open-alert', status: 'success', message: 'User successfully created.');
            } else {
                $user = User::findOrFail($this->userId);

                $this->password = empty($this->password) ? $user->password : bcrypt($this->password);
    
                $data = $this->only(['name', 'email', 'password']);
    
                $this->userRepo->save($user->fill($data));
    
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

        $this->openModal();
    }
}
