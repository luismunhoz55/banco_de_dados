<?php

use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class);
Route::get("/clientes", \App\Livewire\Clientes\Index::class);
