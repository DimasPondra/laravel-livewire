<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public $name, $email, $password, $userId, 
        $isOpen = false, $sortName = 'ASC', $sortEmail = 'ASC';

    #[Url(as: 'name')]
    public $searchName = '';
    
    #[Url(as: 'email')]
    public $searchEmail = '';

    #[Title('User Manager')]
    public function render()
    {
        $users = User::where('name', 'LIKE', '%'.$this->searchName.'%')
                    ->where('email', 'LIKE', '%'.$this->searchEmail.'%')
                    ->orderBy('name', $this->sortName)
                    ->orderBy('email', $this->sortEmail)
                    ->paginate(10);

        return view('livewire.user-manager', [
            'users' => $users
        ]);
    }

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
                
                $data = $this->only(['name', 'email', 'password']);
                User::create($data);
                
                session()->flash('message', 'User successfully created.');
            } else {
                $user = User::findOrFail($this->userId);
    
                if (empty($this->password)) {
                    $this->password = $user->password;
                } else {
                    $this->password = bcrypt($this->password);
                }
    
                $data = $this->only(['name', 'email', 'password']);
    
                $user->fill($data);
                $user->save();
    
                session()->flash('message', 'User successfully updated.');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            session()->flash('error', 'Error creating user: ' . $th->getMessage());
        }

        $this->closeModal();
        $this->resetPage();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->openModal();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User successfully deleted.');
    }

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function updatingSearchEmail()
    {
        $this->resetPage();
    }

    public function removeFilterSearch()
    {
        $this->searchName = '';
        $this->searchEmail = '';
    }

    public function sortByName()
    {
        $this->sortName = $this->sortName === 'ASC' ? 'DESC' : 'ASC';
    }

    public function sortByEmail()
    {
        $this->sortEmail = $this->sortEmail === 'ASC' ? 'DESC' : 'ASC';
    }
}
