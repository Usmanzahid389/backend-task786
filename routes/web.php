<?php

use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserInvitationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');


//    ##### user invitations
    Route::get('user-invitations',[UserInvitationController::class, 'index'])->name('user-invitations');
    Route::get('user-invitations/list',[UserInvitationController::class, 'invitationsWithYajra'])->name('invitations.list');
    Route::post('invite-user/store',[UserInvitationController::class, 'store'])->name('invite-user.store');


//    ### Tasks
    Route::get('tasks',[TaskController::class, 'index'])->name('tasks');
    Route::get('tasks/list', [TaskController::class, 'tasksListWithYajra'])->name('tasks.list');
    Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('tasks/show/{id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('tasks/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('tasks/update/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/delete/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});
