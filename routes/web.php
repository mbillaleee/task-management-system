<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\TaskCategoryController;
use App\Http\Controllers\User\TaskSubtaskController;
use App\Http\Controllers\User\TaskCommentController;
use App\Http\Controllers\User\HabitController;
use App\Http\Controllers\User\HabitLogController;



Route::get('/', [FrontendController::class, 'welcome'])->name('welcome');



Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified', 'role:super_admin'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/account/update', [ProfileController::class, 'updateAccount'])->name('profile.update.account');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth','role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'userDashboard'])->name('dashboard');

    Route::resource('tasks', TaskController::class);

    Route::get('tasks-kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    Route::resource('task-categories', TaskCategoryController::class);
    Route::resource('task-labels', TaskLabelController::class);

    Route::post('tasks/{task}/subtasks', [TaskSubtaskController::class, 'store'])->name('tasks.subtasks.store');
    Route::patch('subtasks/{subtask}/toggle', [TaskSubtaskController::class, 'toggle'])->name('subtasks.toggle');
    Route::delete('subtasks/{subtask}', [TaskSubtaskController::class, 'destroy'])->name('subtasks.destroy');
    Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store'])->name('tasks.comments.store');


    Route::resource('habits', HabitController::class);
    Route::get('habits-board', [HabitController::class, 'board'])->name('habits.board');
    Route::post('habits/{habit}/toggle', [HabitLogController::class, 'toggle'])->name('habits.toggle');




    Route::get('/features', function () {
        return view('user.features');
    })->name('features');

    Route::get('/tools', function () {
        return view('user.tools');
    })->name('tools');

    Route::get('/pricing', function () {
        return view('user.pricing');
    })->name('pricing');

    Route::get('/changelog', function () {
        return view('user.changelog');
    })->name('changelog');

    Route::get('/about', function () {
        return view('user.about');
    })->name('about');

});


Route::middleware(['auth','role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
});




require __DIR__.'/auth.php';
