<?php

namespace App\Livewire\Components;

use App\Models\Classroom;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CardClassroom extends Component
{
    public $classroom;
    // public $isLoading = false;
    // public $search = '';

    // public function loadData() {
    //     try {
    //         // $this->classroom = Classroom::find(auth()->user()->id);
    //         $query = Classroom::where('user_id', auth()->user()->id)->get();
    //         $this->classrooms = $query;
    //         $this->isLoading = false;
    //     } catch (\Throwable $th) {
    //         $this->classrooms = null;
    //         $this->isLoading = false;
    //         Log::error($th);
    //     }
    // }

    public function render()
    {
        return view('livewire.components.card-classroom');
    }
}
