<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserManager extends Component
{
    #[Title('User Manager')]
    public function render()
    {
        return view('livewire.user.user-manager');
    }
}
