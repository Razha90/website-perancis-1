<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureClassOwner;
use App\Livewire\AddClass;
use App\Livewire\AddTask;
use App\Livewire\Chat;
use App\Livewire\Classroom;
use App\Livewire\ClassroomLearn;
use App\Livewire\Contoh;
use App\Livewire\Dashboard;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('lang', [LanguageController::class, 'change'])->name('change.lang');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', action: Welcome::class)->name('welcome');
Route::get('/contoh', action: Contoh::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('app');
        // return view('dashboard');
    })->name('dashboard');
    Route::get('/app', action: Dashboard::class)->name('app');
    Route::get('/chat', Chat::class)->name('chat');
    Route::get('/classroom', Classroom::class)->name('classroom');
    Route::get('/add-class', AddClass::class)->name('add-class');
    Route::get('/classroom/{id}', ClassroomLearn::class)->name('classroom-learn');
    Route::middleware([EnsureClassOwner::class])->group(function () {
        Route::get('/classroom/{id}/add/{task}', AddTask::class)->name('task-add');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/chat-try', function () {
//     return view('chatView');
// });

// Route::get('/chat', Counter::class);
