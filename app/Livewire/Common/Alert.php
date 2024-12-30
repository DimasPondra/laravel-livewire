<?php

namespace App\Livewire\Common;

use Livewire\Attributes\On;
use Livewire\Component;

class Alert extends Component
{
    public $status, $message, $isAlert = false;

    public function render()
    {
        return view('livewire.common.alert');
    }

    #[On('open-alert')]
    public function openAlert($status, $message)
    {
        $this->isAlert = true;
        $this->status = $status;
        $this->message = $message;
    }

    public function closeAlert()
    {
        $this->isAlert = false;
        $this->status = '';
        $this->message = '';
    }
}
