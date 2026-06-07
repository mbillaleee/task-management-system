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
use App\Http\Controllers\User\NoteController;
use App\Http\Controllers\User\NoteFolderController;
use App\Http\Controllers\User\NoteCategoryController;
use App\Http\Controllers\User\FocusController;
use App\Http\Controllers\User\GoalController;
use App\Http\Controllers\User\GoalCategoryController;
use App\Http\Controllers\User\GoalMilestoneController;
use App\Http\Controllers\User\JournalController;
use App\Http\Controllers\User\JournalCategoryController;
use App\Http\Controllers\User\GamificationController;
use App\Http\Controllers\User\BadgeController;
use App\Http\Controllers\User\ChallengeController;




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
    Route::get('all-tasks', [TaskController::class, 'allTasks'])->name('allTasks');

    Route::get('tasks-kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    Route::resource('task-categories', TaskCategoryController::class);
    Route::resource('task-labels', TaskLabelController::class);

    Route::post('tasks/{task}/subtasks', [TaskSubtaskController::class, 'store'])->name('tasks.subtasks.store');
    Route::patch('subtasks/{subtask}/toggle', [TaskSubtaskController::class, 'toggle'])->name('subtasks.toggle');
    Route::delete('subtasks/{subtask}', [TaskSubtaskController::class, 'destroy'])->name('subtasks.destroy');
    Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store'])->name('tasks.comments.store');


    Route::resource('habits', HabitController::class);
    Route::get('all-habits', [HabitController::class, 'allHabits'])->name('allHabits');
    Route::get('habits-board', [HabitController::class, 'board'])->name('habits.board');
    Route::post('habits/{habit}/toggle', [HabitLogController::class, 'toggle'])->name('habits.toggle');


    Route::resource('notes', NoteController::class);

    Route::post('/notes/{note}/toggle-pin', [NoteController::class, 'togglePin'])
        ->name('notes.toggle-pin');

    Route::post('/notes/{note}/toggle-favorite', [NoteController::class, 'toggleFavorite'])
        ->name('notes.toggle-favorite');

    Route::put('/notes/{note}/autosave', [NoteController::class, 'autosave'])
        ->name('notes.autosave');

    Route::resource('note-folders', NoteFolderController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::resource('note-categories', NoteCategoryController::class)
        ->only(['index', 'store', 'update', 'destroy']);


    
    Route::get('focus/statistics', [FocusController::class, 'statistics'])->name('focus.statistics');
    Route::get('focus/history', [FocusController::class, 'history'])->name('focus.history');
    Route::get('focus/{focus}/fullscreen', [FocusController::class, 'fullscreen'])->name('focus.fullscreen');

    Route::post('focus/{focus}/start', [FocusController::class, 'start'])->name('focus.start');
    Route::post('focus/{focus}/pause', [FocusController::class, 'pause'])->name('focus.pause');
    Route::post('focus/{focus}/complete', [FocusController::class, 'complete'])->name('focus.complete');
    Route::post('focus/{focus}/cancel', [FocusController::class, 'cancel'])->name('focus.cancel');

    Route::resource('focus', FocusController::class);




    Route::resource('goals', GoalController::class);

    Route::post('/goals/{goal}/milestones', [GoalMilestoneController::class, 'store'])->name('goals.milestones.store');
    Route::patch('/goal-milestones/{milestone}/toggle', [GoalMilestoneController::class, 'toggle'])->name('goal.milestones.toggle');
    Route::delete('/goal-milestones/{milestone}', [GoalMilestoneController::class, 'destroy'])->name('goal.milestones.destroy');

    Route::get('/goal-categories', [GoalCategoryController::class, 'index'])->name('goal.categories.index');
    Route::post('/goal-categories', [GoalCategoryController::class, 'store'])->name('goal.categories.store');
    Route::put('/goal-categories/{category}', [GoalCategoryController::class, 'update'])->name('goal.categories.update');
    Route::delete('/goal-categories/{category}', [GoalCategoryController::class, 'destroy'])->name('goal.categories.destroy');




    Route::resource('journals', JournalController::class);

    Route::patch('/journals/{journal}/favorite', [JournalController::class, 'toggleFavorite'])->name('journals.favorite');
    Route::get('/journal-categories', [JournalCategoryController::class, 'index'])->name('journal.categories.index');
    Route::post('/journal-categories', [JournalCategoryController::class, 'store'])->name('journal.categories.store');
    Route::put('/journal-categories/{category}', [JournalCategoryController::class, 'update'])->name('journal.categories.update');
    Route::delete('/journal-categories/{category}', [JournalCategoryController::class, 'destroy'])->name('journal.categories.destroy');



    Route::get('/gamification', [\App\Http\Controllers\User\GamificationController::class,'index'])->name('gamification.index');
    Route::post('/gamification/add-xp', [\App\Http\Controllers\User\GamificationController::class,'addXp'])->name('gamification.addXp');
    Route::post('/gamification/claim-daily-reward', [\App\Http\Controllers\User\GamificationController::class,'claimDailyReward'])->name('gamification.claimDailyReward');

    // User badges and challenges
    Route::get('/badges', [\App\Http\Controllers\User\BadgeController::class,'index'])->name('badges.index');
    Route::get('/challenges', [\App\Http\Controllers\User\ChallengeController::class,'index'])->name('challenges.index');
    Route::post('/challenges/{challenge}/join', [\App\Http\Controllers\User\ChallengeController::class,'join'])->name('challenges.join');
    Route::patch('/user-challenges/{userChallenge}/progress', [\App\Http\Controllers\User\ChallengeController::class,'progress'])->name('userChallenges.progress');


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


    // Badge CRUD
    Route::resource('badges', \App\Http\Controllers\Admin\BadgeController::class);

    // Challenge CRUD
    Route::resource('challenges', \App\Http\Controllers\Admin\ChallengeController::class);

    // Optional Admin dashboard for stats
    Route::get('/gamification/dashboard', [\App\Http\Controllers\Admin\GamificationController::class,'dashboard'])->name('gamification.dashboard');
});




require __DIR__.'/auth.php';
