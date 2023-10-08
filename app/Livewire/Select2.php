<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Select2 extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.select2');
    }

    public function scripts()
{
    return view('livewire.scripts.select2');
}
}
