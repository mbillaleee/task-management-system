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
use App\Http\Controllers\User\TaskLabelController;
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
use App\Http\Controllers\User\CalendarController;
use App\Http\Controllers\User\UserSubscriptionController;
use App\Http\Controllers\User\SettingsController;


use App\Http\Controllers\Admin\GamificationController as AdminGamificationController;
use App\Http\Controllers\Admin\BadgeController as AdminBadgeController;
use App\Http\Controllers\Admin\ChallengeController as AdminChallengeController;
use App\Http\Controllers\Admin\DailyRewardController as AdminDailyRewardController;
use App\Http\Controllers\User\GamificationController as UserGamificationController;
use App\Http\Controllers\User\ChallengeController as UserChallengeController;

use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\SubscriptionController;



Route::get('/', [FrontendController::class, 'welcome'])->name('welcome');



Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['setLocale','auth', 'verified', 'role:super_admin'])->name('admin.dashboard');

Route::middleware(['auth','setLocale'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/account/update', [ProfileController::class, 'updateAccount'])->name('profile.update.account');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth','role:user','setLocale'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'userDashboard'])->name('dashboard');

    // Reorder tasks
    Route::patch('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');

    
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

    
    Route::delete('comments/{comment}', [TaskCommentController::class, 'destroy'])->name('tasks.comments.destroy');


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
    Route::get('/journals-statistics', [JournalController::class, 'statistics'])->name('journals.statistics');

    Route::patch('/journals/{journal}/favorite', [JournalController::class, 'toggleFavorite'])->name('journals.favorite');
    Route::get('/journal-categories', [JournalCategoryController::class, 'index'])->name('journal.categories.index');
    Route::post('/journal-categories', [JournalCategoryController::class, 'store'])->name('journal.categories.store');
    Route::put('/journal-categories/{category}', [JournalCategoryController::class, 'update'])->name('journal.categories.update');
    Route::delete('/journal-categories/{category}', [JournalCategoryController::class, 'destroy'])->name('journal.categories.destroy');



    // Gamification dashboard + daily reward claim
    Route::get('/gamification', [UserGamificationController::class, 'index'])->name('gamification.index');
    Route::post('/gamification/claim-daily-reward', [UserGamificationController::class, 'claimDailyReward'])->name('gamification.claimDailyReward');
    
    // User can only JOIN challenges and update their own progress (no create/delete)
    Route::post('/challenges/{challenge}/join', [UserChallengeController::class, 'join'])->name('challenges.join');
    Route::patch('/user-challenges/{userChallenge}/progress', [UserChallengeController::class, 'progress'])->name('userChallenges.progress');


    Route::post('/languages/update/status/{language}', [UserDashboardController::class, 'updateStatus'])->name('languages.update.status');


    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/',         [CalendarController::class, 'index'])    ->name('index');
        Route::get('/week',     [CalendarController::class, 'week'])     ->name('week');
        Route::get('/day',      [CalendarController::class, 'day'])      ->name('day');
        Route::get('/timeline', [CalendarController::class, 'timeline']) ->name('timeline');
        Route::get('/events',   [CalendarController::class, 'events'])   ->name('events');
 
        Route::post('/',                        [CalendarController::class, 'store'])        ->name('store');
        Route::get('/{calendarEvent}',          [CalendarController::class, 'show'])         ->name('show');
        Route::put('/{calendarEvent}',          [CalendarController::class, 'update'])       ->name('update');
        Route::delete('/{calendarEvent}',       [CalendarController::class, 'destroy'])      ->name('destroy');
        Route::patch('/{calendarEvent}/status', [CalendarController::class, 'updateStatus']) ->name('updateStatus');
    });


    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/',           [UserSubscriptionController::class, 'index'])          ->name('index');
        Route::post('/upgrade',   [UserSubscriptionController::class, 'upgradeRequest']) ->name('upgrade');
        Route::post('/cancel',    [UserSubscriptionController::class, 'cancel'])         ->name('cancel');
    });


    Route::get('/settings',                 [SettingsController::class, 'index'])               ->name('settings');
    Route::patch('/settings/account',       [SettingsController::class, 'updateAccount'])        ->name('settings.account');
    Route::patch('/settings/password',      [SettingsController::class, 'updatePassword'])       ->name('settings.password');
    Route::patch('/settings/appearance',    [SettingsController::class, 'updateAppearance'])     ->name('settings.appearance');
    Route::patch('/settings/notifications', [SettingsController::class, 'updateNotifications'])  ->name('settings.notifications');
    Route::patch('/settings/privacy',       [SettingsController::class, 'updatePrivacy'])        ->name('settings.privacy');
    Route::delete('/settings/delete',       [SettingsController::class, 'destroy'])              ->name('settings.destroy');


    Route::get('/features', function () {
        return view('user.features');
    })->name('features');

    Route::get('/tools', function () {
        return view('user.tools');
    })->name('tools');

    Route::get('/pricing', [UserDashboardController::class, 'pricing'])->name('pricing');

    Route::get('/changelog', function () {
        return view('user.changelog');
    })->name('changelog');

    Route::get('/about', function () {
        return view('user.about');
    })->name('about');

});


Route::middleware(['auth','role:super_admin','setLocale'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);


    // Gamification overview
    Route::get('/gamification', [AdminGamificationController::class, 'index'])->name('gamification.index');
    
    // Badge CRUD (admin creates/edits/deletes globally)
    Route::get('/badges', [AdminBadgeController::class, 'index'])->name('badges.index');
    Route::post('/badges', [AdminBadgeController::class, 'store'])->name('badges.store');
    Route::put('/badges/{badge}', [AdminBadgeController::class, 'update'])->name('badges.update');
    Route::delete('/badges/{badge}', [AdminBadgeController::class, 'destroy'])->name('badges.destroy');
    
    // Challenge CRUD (admin creates/edits/deletes globally)
    Route::get('/challenges', [AdminChallengeController::class, 'index'])->name('challenges.index');
    Route::post('/challenges', [AdminChallengeController::class, 'store'])->name('challenges.store');
    Route::put('/challenges/{challenge}', [AdminChallengeController::class, 'update'])->name('challenges.update');
    Route::delete('/challenges/{challenge}', [AdminChallengeController::class, 'destroy'])->name('challenges.destroy');
    
    // Daily Rewards CRUD
    Route::get('/daily-rewards', [AdminDailyRewardController::class, 'index'])->name('daily-rewards.index');
    Route::post('/daily-rewards', [AdminDailyRewardController::class, 'store'])->name('daily-rewards.store');
    Route::put('/daily-rewards/{dailyReward}', [AdminDailyRewardController::class, 'update'])->name('daily-rewards.update');
    Route::delete('/daily-rewards/{dailyReward}', [AdminDailyRewardController::class, 'destroy'])->name('daily-rewards.destroy');



     Route::get('languages',[LanguageController::class,'index'])->name('languages');
    Route::get('language/create',[LanguageController::class,'create'])->name('language.create');
    Route::post('language/store',[LanguageController::class,'store'])->name('language.store');
    Route::get('language/edit/{language}',[LanguageController::class,'edit'])->name('language.edit');
    Route::post('language/update/{language}',[LanguageController::class,'update'])->name('language.update');
    Route::post('language/delete/{language}',[LanguageController::class,'destroy'])->name('language.delete');
    Route::post('language/status',[LanguageController::class,'toggleStatus'])->name('language.status');

    Route::get('language/translations/{language}',[LanguageController::class,'translations'])->name('language.translations');
    Route::post('language/translation/value/store',[LanguageController::class,'storeTranslationValues'])->name('language.translation.value.store');
    Route::get('language/translation/search/ajax',[LanguageController::class,'translationSearchAjax'])->name('language.translation.search.ajax');

    Route::post('/languages/update/status/{language}', [LanguageController::class, 'updateStatus'])->name('languages.update.status');



        // ─── Subscription Plans (Admin CRUD) ───
    Route::get('/subscriptions',                           [SubscriptionController::class, 'index'])             ->name('subscriptions.index');
    Route::post('/subscriptions',                          [SubscriptionController::class, 'store'])             ->name('subscriptions.store');
    Route::put('/subscriptions/{subscription}',            [SubscriptionController::class, 'update'])            ->name('subscriptions.update');
    Route::delete('/subscriptions/{subscription}',         [SubscriptionController::class, 'destroy'])           ->name('subscriptions.destroy');
    Route::post('/subscriptions/{subscription}/toggle',    [SubscriptionController::class, 'toggleStatus'])      ->name('subscriptions.toggle');

    // ─── Subscriber Management ───
    Route::get('/subscriptions/subscribers',               [SubscriptionController::class, 'subscribers'])       ->name('subscriptions.subscribers');
    Route::post('/subscriptions/assign',                   [SubscriptionController::class, 'assignPlan'])        ->name('subscriptions.assign');
    Route::patch('/subscriptions/cancel/{userSubscription}',[SubscriptionController::class, 'cancelSubscription'])->name('subscriptions.cancel');


    Route::middleware('auth')->get('/clear', function () {
        Artisan::call('optimize:clear');
        Artisan::call('storage:link');
        return redirect()->back()->with('success', 'Cache cleared and storage linked successfully.');
    })->name('clear');

});




require __DIR__.'/auth.php';
