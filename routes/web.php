<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Posts;

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

Route::get('/post/{id}', [Posts::class, 'get_post'])->name('post');

Route::post('/endpoint/compose', [Posts::class, 'new_post']);

Route::post('/endpiont/edit_post', [Posts::class, 'edit_post']);

Rout::post('/endpiont/delete_post' [Posts::class, 'delete_post']);

Route::post('/endpoint/create_comment', [Comments::class, 'new_comment']);

Route::post('/endpoint/edit_comment', [Comments::class, 'edit_comment']);

Route::post('/endpoint/delete_comment', [Comments::class, 'delete_comment']);

require __DIR__.'/auth.php';
