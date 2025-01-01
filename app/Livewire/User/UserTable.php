<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    private $userRepo;

    #[Url('name')]
    public $searchName = '';

    #[Url('email')]
    public $searchEmail = '';

    public $sortName = 'ASC', $sortEmail = 'ASC';

    public function boot(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function render()
    {
        $users = $this->userRepo->get([
            'search' => [
                'name' => $this->searchName,
                'email' => $this->searchEmail
            ],
            'sort' => [
                'name' => $this->sortName,
                'email' => $this->sortEmail
            ],
            'perPage' => 10
        ]);

        return view('livewire.user.user-table', [
            'users' => $users
        ]);
    }

    public function updatingSearchName()
    {
        $this->resetPagination();
    }

    public function updatingSearchEmail()
    {
        $this->resetPagination();
    }

    public function removeFilter()
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

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            if ($user->profile) {
                $this->dispatch('open-alert', status: 'error', message: "Can't delete this data because it's in use.");
                return;
            }
            
            $user->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->dispatch('open-alert', status: 'error', message: 'Error creating user: ' . $th->getMessage());
        }

        $this->dispatch('open-alert', status: 'success', message: 'User successfully deleted.');
    }

    public function openUserForm()
    {
        $this->dispatch('open-user-modal');
    }

    public function editUser($id)
    {
        $this->dispatch('edit-user', id: $id);
    }

    #[On('reset-user-pagination')]
    public function resetPagination()
    {
        $this->resetPage();
    }
}
