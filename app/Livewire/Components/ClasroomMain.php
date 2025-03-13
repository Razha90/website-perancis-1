<?php

namespace App\Livewire\Components;

use App\Models\Classroom;
use Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ClasroomMain extends Component
{
    public $classrooms = [];
    public $isLoading = true;
    public $search = '';
    public $desc = 'asc';

    public function render()
    {
        return view('livewire.components.clasroom-main');
    }

    public function mount()
    {
        $this->loadData();
    }

    public function addClass()
    {
        try {
            Log::info('Session User:', ['user' => Auth::user()]);

            if (!Auth::check()) {
                session()->flash('FAILED', 'You need to login first');
                return redirect()->route('login');
            }
            $randomImage = ['class-1.jpeg', 'class-2.jpeg', 'class-3.jpeg', 'class-4.jpeg', 'class-5.jpeg'];
            $classroom = new Classroom();
            $classroom->user_id = Auth::id();
            $classroom->title = 'Untitled';
            $classroom->description = 'No Description';
            $classroom->position = '';
            $classroom->image = '/img/web/' . $randomImage[rand(0, 4)];

            $classroom->save();
            session()->flash('SUCCESS', 'Classroom Added Successfully');
            $this->dispatch('class-response', [
                'status' => true,
                'data' => $classroom,
            ]);
        } catch (\Throwable $th) {
            Log::error('ClasroomMain Error Add Class '.$th);
            session()->flash('FAILED', 'Failed to Add Classroom');
            $this->dispatch('class-response', [
                'status' => false,
                'data' => null,
            ]);
        }
    }

    public function loadData()
    {
        try {
            $query = Classroom::where('user_id', auth()->user()->id);
            if (!empty($this->search)) {
                // $query->where('title', 'like', '%' . $this->search . '%');
                $query->where('title', 'like', '%' . $this->search . '%');
            }
            $query->orderBy('title', $this->desc);
            $result = $query->get();

            if ($result->isEmpty()) {
                $this->classrooms = [];
            } else {
                $this->classrooms = $result->toArray();
            }
        } catch (\Throwable $th) {
            $this->classrooms = null;
            Log::error($th);
        } finally {
            $this->isLoading = false;
        }
    }

    public function updated()
    {
        $this->loadData();
    }
}
