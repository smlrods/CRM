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

Route::get('/dashboard', function () {
    $userData = User::getCountChartDataForWeek();
    $clientData = Client::getCountChartDataForWeek();
    $projectData = Project::getCountChartData();
    $taskData = Task::getCountChartData();

    return view('dashboard', [
        'userChartData' => $userData,
        'clientChartData' => $clientData,
        'projectChartData' => $projectData,
        'taskChartData' => $taskData,
    ]);
})->middleware(['auth', 'verified']);

Route::resource('users', UserController::class)->middleware(['auth', 'verified']);

Route::resource('clients', ClientController::class)->middleware(['auth', 'verified']);

Route::resource('projects', ProjectController::class)->middleware(['auth', 'verified']);

Route::resource('tasks', TaskController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
