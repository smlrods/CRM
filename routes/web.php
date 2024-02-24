<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('LandingPage');
});

Route::middleware(['auth', 'check_organitation'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::apiResource('organizations', OrganizationController::class)->withoutMiddleware('check_organitation');

    Route::controller(MemberController::class)->group(function () {
        Route::get('/members', 'index')->name('members.index');
        Route::put('/members/{member}', 'update')->name('members.update');
        Route::delete('/members/{member}', 'destroy')->name('members.destroy');
    });

    Route::controller(InvitationController::class)->group(function () {
        Route::post('/invitations', 'store')->name('invitations.store');
        Route::put('/invitations/{invitation}', 'update')->name('invitations.update');
    })->withoutMiddleware('check_organitation');

    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles.index');
        Route::post('/roles', 'store')->name('roles.store');
        Route::put('/roles/{role}', 'update')->name('roles.update');
        Route::delete('/roles/{role}', 'destroy')->name('roles.destroy');
    });

    Route::controller(ContactController::class)->group(function () {
        Route::get('/contacts', 'index')->name('contacts.index');
        Route::post('/contacts', 'index')->name('contacts.store');
        Route::put('/contacts/{contact}', 'update')->name('contacts.update');
        Route::delete('/contacts/{contact}', 'destroy')->name('contacts.destroy');
    });

    Route::controller(CompanyController::class)->group(function () {
        Route::get('/companies', 'index')->name('companies.index');
        Route::post('/companies', 'store')->name('companies.store');
        Route::put('/companies/{company}', 'update')->name('companies.update');
        Route::delete('/companies/{company}', 'destroy')->name('companies.destroy');
    });

    Route::controller(LeadController::class)->group(function () {
        Route::get('/leads', 'index')->name('leads.index');
        Route::post('/leads', 'store')->name('leads.store');
        Route::put('/leads/{lead}', 'update')->name('leads.update');
        Route::delete('/leads/{lead}', 'destroy')->name('leads.destroy');
    });

    Route::controller(DealController::class)->group(function () {
        Route::get('/deals', 'index')->name('deals.index');
        Route::post('/deals', 'store')->name('deals.store');
        Route::put('/deals/{deal}', 'update')->name('deals.update');
        Route::delete('/deals/{deal}', 'destroy')->name('deals.destroy');
    });

    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activities', 'index')->name('activities.index');
        Route::post('/activities', 'store')->name('activities.store');
        Route::put('/activities/{activity}', 'update')->name('activities.update');
        Route::delete('/activities/{activity}', 'destroy')->name('activities.destroy');
    });

    Route::put('/users/organization', [UserController::class, 'setOrganization'])
        ->name('users.organization')
        ->withoutMiddleware('check_organitation');
});

require __DIR__ . '/auth.php';
