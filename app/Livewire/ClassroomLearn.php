<?php

namespace App\Livewire;

use App\Models\Classroom;
use App\Models\Content;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\Image;
// use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Log;

class ClassroomLearn extends Component
{
    use WithFileUploads;
    public $id;
    public $classrooms = [];
    public $isLoading = false;
    public $isTeacher = false;

    #[Validate('image', message: 'image', onUpdate: true)]
    #[Validate('mimes:jpeg,jpg,webp,png', message: 'image', onUpdate: true)]
    #[Validate('max:10240', message: 'max', onUpdate: true)]
    public $image;

    public function mount($id)
    {
        $this->id = $id;
        $this->loadData();
    }

    public function loadData()
    {
        try {
            $data = Classroom::where('id', $this->id)->get();
            $this->classrooms = $data->toArray();
            $this->isLoading = false;
            if (auth()->user()->id == $this->classrooms[0]['user_id']) {
                $this->isTeacher = true;
            }
        } catch (\Throwable $th) {
            $this->classrooms = null;
            $this->isLoading = false;
            session()->flash('FAILED', __('class-learn.failed_class'));
            Log::error($th);
        }
    }

    public function render()
    {
        return view('livewire.classroom-learn')->layout('layouts.app');
    }

    public function addContent()
    {
        try {
            $createContent = Content::create([
                'classroom_id' => $this->id,
                'title' => 'New Content',
                'description' => 'Description',
                'content' => 'Content',
                'visibility' => false,
                'release' => now(),
                'type' => 'task',
            ]);
            $createContent->save();
            return redirect()->route('task-add', ['id' => $this->id, 'task' => $createContent->id]);
        } catch (\Throwable $th) {
            session()->flash('FAILED', __('class-learn.failed_content'));
            Log::error('ClassroomLearn Eroor Add Content' . $th);
        }
    }

    public function savedContent($data)
    {
        try {
            if (auth()->user()->id != $this->classrooms[0]['user_id']) {
                $this->dispatch('show-failed', ['message' => __('class-learn.error_auth')]);
                return;
            }

            $validator = Validator::make(
                $data,
                [
                    'position' => 'string|max:20',
                    'title' => 'required|string|max:100|min:3',
                    'action' => 'required|boolean',
                ],
                [
                    'position.string' => __('class-learn.position.string'),
                    'position.max' => __('class-learn.position.max'),

                    'title.required' => __('class-learn.title.required'),
                    'title.string' => __('class-learn.title.string'),
                    'title.max' => __('class-learn.title.max'),
                    'title.min' => __('class-learn.title.min'),

                    'action.required' => __('class-learn.action.required'),
                    'action.boolean' => __('class-learn.action.boolean'),
                ],
            );

            if ($validator->fails()) {
                $this->dispatch('show-failed', ['message' => $validator->errors()->first()]);
                return;
            }

            $action = $data['action'];
            $position = $data['position'];
            $title = $data['title'];
            $image = '';

            if ($action) {
                $this->validate();
                $filename = $this->image->store(path: 'images', options: 'public');
                $filename = str_replace('public/', '', $filename);
                $image = Storage::url($filename);
                $file_old = str_replace('/storage/', '', $this->classrooms[0]['image']);
                try {
                    if (Storage::disk('public')->exists($file_old)) {
                        Storage::disk('public')->delete($file_old);
                        if (!Storage::disk('public')->exists($file_old)) {
                        } else {
                            Log::warning('File gagal dihapus ClassroomLearn, User Melakukannya : ' . auth()->user()->id . '' . $file_old);
                        }
                    } else {
                        Log::info('File tidak ditemukan ClassroomLearn : User Melakukannya' . auth()->user()->id . '' . $file_old);
                    }
                } catch (\Throwable $th) {
                    Log::error('ClassroomLearn Error Deleted Image: User Melakukannya ' . auth()->user()->id . ' ' . $th->getMessage());
                }
            } else {
                $validator = Validator::make(
                    $data,
                    [
                        'image_path' => 'required|string',
                    ],
                    [
                        'image_path.required' => __('class-learn.image.required'),
                        'image_path.string' => __('class-learn.image.string'),
                    ],
                );
                if ($validator->fails()) {
                    $this->dispatch('show-failed', ['message' => $validator->errors()->first()]);
                    return;
                }
                $image = $data['image_path'];
            }

            Classroom::where('id', $this->id)->update([
                'image' => $image,
                'position' => $position,
                'title' => $title,
            ]);
            $this->dispatch('show-success', ['message' => __('class-learn.success')]);
            $this->loadData();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal!', $e->errors());
            $errors = $e->errors();
            if (isset($errors['image'])) {
                $errorMessage = $errors['image'][0];
                if ($errorMessage === 'image') {
                    $this->dispatch('show-failed', ['message' => __('class-learn.image.image')]);
                } elseif ($errorMessage === 'max') {
                    $this->dispatch('show-failed', ['message' => __('class-learn.image.max')]);
                } else {
                    $this->dispatch('show-failed', ['message' => __('class-learn.image.image')]); // Default error
                }
            }
        } catch (\Throwable $th) {
            Log::error('ClassroomLearn Eroor Saved Content' . $th);
            $this->dispatch('show-failed', ['message' => __('class-learn.error_server')]);
        }
    }

    public function deletedImage()
    {
        $file_old = str_replace('/storage/', '', $this->classrooms[0]['image']);
        try {
            if (Storage::disk('public')->exists($file_old)) {
                Storage::disk('public')->delete($file_old);
                Log::info('File berhasil dihapus: ' . $file_old);
            } else {
                Log::info('File tidak ditemukan: ' . $file_old);
            }
        } catch (\Throwable $th) {
            Log::error('ClassroomLearn Eroor Deleted Image' . $th);
        }
    }
}
