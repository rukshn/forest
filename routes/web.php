<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/issues', function () {
    return view('dashboard');
})->middleware(['auth'])->name('issues');

Route::get('/tasks', function () {
    return view('dashboard');
})->middleware(['auth'])->name('tasks');

Route::get('/milestones', function () {
    return view('dashboard');
})->middleware(['auth'])->name('milestones');

Route::get('/compose', function() {
    return view('compose');
})->middleware(['auth'])->name('compose');

Route::get('/post/{id}', [Post::class, 'get_post']);

require __DIR__.'/auth.php';
