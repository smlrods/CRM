<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
    return view('landing-page');
});

Route::middleware(['auth', 'verified', 'check_organitation'])->group(function () {
Route::get('/dashboard', function () {
        $organizations = auth()->user()->memberships()->with('organization')->get();

        return Inertia::render('Dashboard', [
            'organizations' => $organizations,
        ]);
    })->name('dashboard');

    Route::apiResource('organizations', OrganizationController::class)->withoutMiddleware('check_organitation');
    // Route::apiResource('members', MemberController::class);
    Route::controller(MemberController::class)->group(function () {
        Route::get('/', 'index')->name('members.index');
        Route::put('/{member}', 'update')->name('members.update');
        Route::delete('/{member}', 'destroy')->name('members.destroy');
    })->prefix('members');

    // Route::apiResource('invitations', InvitationController::class)->withoutMiddleware('check_organitation');
    Route::controller(InvitationController::class)->group(function () {
        Route::post('/invitations', 'store')->name('invitations.store');
        Route::put('/invitations/{invitation}', 'update')->name('invitations.update');
    })->withoutMiddleware('check_organitation');

    Route::apiResource('roles', RoleController::class);

});

Route::resource('clients', ClientController::class)->middleware(['auth', 'verified']);

Route::resource('projects', ProjectController::class)->middleware(['auth', 'verified']);

Route::resource('tasks', TaskController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
