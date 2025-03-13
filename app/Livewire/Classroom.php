<?php

namespace App\Livewire;

use Livewire\Component;

class Classroom extends Component
{
    public function render()
    {
        return view('livewire.classroom')->layout('layouts.app');
    }
}
