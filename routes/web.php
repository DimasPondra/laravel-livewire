<?php

use App\Livewire\User\UserManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', UserManager::class);