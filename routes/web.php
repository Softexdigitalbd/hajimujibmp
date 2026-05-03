<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\ComplaintQuestionController;
use App\Http\Controllers\Admin\ComplaintStatusController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Settings\BehaviourSettingsController;
use App\Http\Controllers\Admin\StatusTransitionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PublicComplaintController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

/*
|--------------------------------------------------------------------------
| Dev-only utility routes — remove before going to production
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:20,1')->group(function () {
    Route::get('/complaint/new', [PublicComplaintController::class, 'create'])->name('complaint.create');
    Route::post('/complaint', [PublicComplaintController::class, 'store'])->name('complaint.store');
});

Route::get('/complaint/thanks/{reference}', [PublicComplaintController::class, 'thanks'])->name('complaint.thanks');

Route::get('/dashboard', function () {
    $user = auth()->user();

    // Super-admins and any staff user with a role go to the admin panel
    if ($user?->is_admin || $user?->role_id) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // ── Profile ───────────────────────────────────────────────────────────
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'password'])->name('profile.password');

        // ── Complaints ────────────────────────────────────────────────────────
        Route::middleware('permission:complaints.index')->group(function () {
            Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
        });

        Route::middleware('permission:complaints.show')->group(function () {
            Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
            Route::get('/complaints/{complaint}/answers/{answer}/file', [AdminComplaintController::class, 'downloadAnswerFile'])
                ->name('complaints.answers.file');
            Route::get('/complaints/{complaint}/answers/{answer}/file/inline', [AdminComplaintController::class, 'inlineAnswerFile'])
                ->name('complaints.answers.file.inline');
        });

        Route::middleware('permission:complaints.update_status')
            ->patch('/complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])
            ->name('complaints.update-status');

        Route::middleware('permission:complaints.comment')
            ->post('/complaints/{complaint}/comments', [AdminComplaintController::class, 'storeComment'])
            ->name('complaints.comments.store');

        Route::middleware('permission:complaints.download')->group(function () {
            Route::get('/complaints/{complaint}/comments/{comment}/attachment', [AdminComplaintController::class, 'downloadAttachment'])
                ->name('complaints.comments.attachment');
            Route::get('/complaints/{complaint}/comments/{comment}/attachment/inline', [AdminComplaintController::class, 'inlineAttachment'])
                ->name('complaints.comments.attachment.inline');
        });

        // ── Settings ──────────────────────────────────────────────────────────
        Route::middleware('permission:settings.behaviour')->group(function () {
            Route::get('/settings/behaviour', [BehaviourSettingsController::class, 'edit'])->name('settings.behaviour.edit');
            Route::put('/settings/behaviour', [BehaviourSettingsController::class, 'update'])->name('settings.behaviour.update');
        });

        Route::middleware('permission:settings.statuses')->group(function () {
            Route::get('/settings/statuses', [ComplaintStatusController::class, 'index'])->name('settings.statuses.index');
            Route::get('/settings/statuses/create', [ComplaintStatusController::class, 'create'])->name('settings.statuses.create');
            Route::post('/settings/statuses', [ComplaintStatusController::class, 'store'])->name('settings.statuses.store');
            Route::get('/settings/statuses/{status}/edit', [ComplaintStatusController::class, 'edit'])->name('settings.statuses.edit');
            Route::put('/settings/statuses/{status}', [ComplaintStatusController::class, 'update'])->name('settings.statuses.update');
            Route::delete('/settings/statuses/{status}', [ComplaintStatusController::class, 'destroy'])->name('settings.statuses.destroy');
        });

        Route::middleware('permission:settings.trash')->group(function () {
            Route::get('/settings/statuses/trash', [ComplaintStatusController::class, 'trash'])->name('settings.statuses.trash');
            Route::put('/settings/statuses/{id}/restore', [ComplaintStatusController::class, 'restore'])->name('settings.statuses.restore');
            Route::put('/settings/questions/{id}/restore', [ComplaintQuestionController::class, 'restore'])->name('settings.questions.restore');
        });

        Route::middleware('permission:settings.transitions')->group(function () {
            Route::get('/settings/transitions', [StatusTransitionController::class, 'index'])->name('settings.transitions.index');
            Route::put('/settings/transitions', [StatusTransitionController::class, 'sync'])->name('settings.transitions.sync');
        });

        Route::middleware('permission:settings.questions')->group(function () {
            Route::get('/settings/questions', [ComplaintQuestionController::class, 'index'])->name('settings.questions.index');
            Route::get('/settings/questions/create', [ComplaintQuestionController::class, 'create'])->name('settings.questions.create');
            Route::post('/settings/questions', [ComplaintQuestionController::class, 'store'])->name('settings.questions.store');
            Route::get('/settings/questions/{question}/edit', [ComplaintQuestionController::class, 'edit'])->name('settings.questions.edit');
            Route::put('/settings/questions/{question}', [ComplaintQuestionController::class, 'update'])->name('settings.questions.update');
            Route::delete('/settings/questions/{question}', [ComplaintQuestionController::class, 'destroy'])->name('settings.questions.destroy');
            Route::put('/settings/questions/{id}/restore', [ComplaintQuestionController::class, 'restore'])->name('settings.questions.restore');
        });

        // ── User Management ───────────────────────────────────────────────────
        Route::middleware('permission:users.view')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
        });
        Route::middleware('permission:users.create')->group(function () {
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
        });
        Route::middleware('permission:users.edit')->group(function () {
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        });
        Route::middleware('permission:users.delete')
            ->delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');

        // ── Role Management ───────────────────────────────────────────────────
        Route::middleware('permission:roles.view')->group(function () {
            Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        });
        Route::middleware('permission:roles.create')->group(function () {
            Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        });
        Route::middleware('permission:roles.edit')->group(function () {
            Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        });
        Route::middleware('permission:roles.delete')
            ->delete('/roles/{role}', [RoleController::class, 'destroy'])
            ->name('roles.destroy');
    });

require __DIR__ . '/auth.php';
