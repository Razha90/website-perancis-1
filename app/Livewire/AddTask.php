<?php

namespace App\Livewire;

use App\Models\Content;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AddTask extends Component
{
    public $id;
    public $task;
    public $content = [];
    public $isLoading = false;
    protected $listeners = ['savedContent'];

    public function mount($id, $task)
    {
        $this->id = $id;
        $this->task = $task;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.add-task')->layout('layouts.app');
    }

    private function loadData()
    {
        try {
            $data = Content::where('id', $this->task)->get();
            $this->content = $data->toArray();
        } catch (\Throwable $th) {
            Log::error('Load data task, in Add Task' . $th);
        } finally {
            $this->isLoading = true;
        }
    }

    public function savedContent($data)
    {
        try {
            Content::where('id', $this->task)->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'type' => $data['type'],
            ]);
            sleep(2);
        } catch (\Throwable $th) {
            session()->flash('FAILED', __('add-task.failed_saved'));
            Log::error('Update data task, in Add Task' . $th);
        } finally {
            session()->flash('SUCCESS', __('add-task.failed_saved'));
            $this->dispatch('savedSuccess');
        }
    }
}
