<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupuserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JoingroupController;
use App\Http\Controllers\JoinmeetingController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() { 
    // ALL USERS CHANGE USERNAME
    Route::resource('users', UserController::class);

    // MEETINGS CRUD ONLY FOR FSR:IF MEMBERS
    Route::get('/hidden', [MeetingController::class ,'hidden'])->name('hidden');
    Route::get('/meetings', [MeetingController::class,'index'])->name('meetings.index');
    Route::get('/meetings/create', [MeetingController::class,'create'])->name('meetings.create')->middleware('role:Fsr');
    Route::post('/meetings', [MeetingController::class,'store'])->name('meetings.store')->middleware('role:Fsr');
    Route::get('/meetings/{meeting}', [MeetingController::class ,'show'])->name('meetings.show');
    Route::get('/meetings/{meeting}/edit', [MeetingController::class,'edit'])->name('meetings.edit')->middleware('role:Fsr');
    Route::put('/meetings/{meeting}', [MeetingController::class,'update'])->name('meetings.update')->middleware('role:Fsr');
    Route::delete('/meetings/{meeting}', [MeetingController::class,'destroy'])->name('meetings.destroy')->middleware('role:Fsr');


    // GROUPS CRUD ONLY FOR USERS
    Route::get('/groups', [GroupController::class,'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class,'create'])->name('groups.create')->middleware('role:user');
    Route::post('/groups', [GroupController::class,'store'])->name('groups.store')->middleware('role:user');
    Route::get('/groups/{group}', [GroupController::class ,'show'])->name('groups.show');
    Route::get('/groups/{group}/edit', [GroupController::class,'edit'])->name('groups.edit')->middleware('role:user');
    Route::put('/groups/{group}', [GroupController::class,'update'])->name('groups.update')->middleware('role:user');
    Route::delete('/groups/{group}', [GroupController::class,'destroy'])->name('groups.destroy')->middleware('role:user');

    // JOIN 
    Route::get('/joinmeetings', [JoinmeetingController::class,'index'])->name('joinmeetings.index')->middleware('role:user');
    Route::get('/joinmeetings/create', [JoinmeetingController::class,'create'])->name('joinmeetings.create')->middleware('role:user');
    Route::post('/joinmeetings', [JoinmeetingController::class,'store'])->name('joinmeetings.store')->middleware('role:user');
    
    Route::get('/joingroups', [JoingroupController::class,'index'])->name('joingroups.index')->middleware('role:user');
    Route::get('/joingroups/create', [JoingroupController::class,'create'])->name('joingroups.create')->middleware('role:user');
    Route::post('/joingroups', [JoingroupController::class,'store'])->name('joingroups.store')->middleware('role:user');

    // LEAVE
    Route::get('/leave', [JoingroupController::class ,'leave'])->name('leave')->middleware('role:user');;
    // Route::resource('joingroups', JoingroupController::class)->middleware('role:user');
    // Route::resource('joinmeetings', JoinmeetingController::class)->middleware('role:user');
});











// https://medium.com/fabcoding/laravel-redirect-users-according-to-roles-and-protect-routes-bde324fe1823
// Laravel — Redirect to different views based on user role

// https://www.youtube.com/watch?v=-PXpZGYEBwY&ab_channel=Bitfumes

// https://www.youtube.com/watch?v=a-BvmVoBpbE&ab_channel=PillBugInteractive

// https://www.codegrepper.com/code-examples/php/Many+to+one+relationship+laravel


// How to use PostgreSQL with Laravel | EDB - https://www.enterprisedb.com/postgres-tutorials/how-use-postgresql-laravel
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
