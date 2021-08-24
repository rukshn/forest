<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Posts;
use App\Http\Controllers\Comments;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', [Posts::class, 'get_feed'])->middleware(['auth'])->name('dashboard');

Route::get('/issues', [Posts::class, 'get_posts_by_issues'])->middleware(['auth'])->name('issues');

Route::get('/tasks', [Posts::class, 'get_posts_by_tasks'])->middleware(['auth'])->name('tasks');

Route::get('/milestones', [Posts::class, 'get_posts_by_milestones'])->middleware(['auth'])->name('milestones');

Route::get('/compose', function() {
    return view('compose');
})->middleware(['auth'])->name('compose');

Route::get('/post/{id}', [Posts::class, 'get_post'])->middleware(['auth'])->name('post');

Route::post('/endpoint/compose', [Posts::class, 'new_post'])->middleware(['auth']);

Route::post('/endpiont/edit_post', [Posts::class, 'edit_post'])->middleware(['auth']);

Route::post('/endpiont/delete_post', [Posts::class, 'delete_post'])->middleware(['auth']);

Route::post('/endpoint/create_comment', [Comments::class, 'create_comment'])->middleware(['auth']);

Route::post('/endpoint/edit_comment', [Comments::class, 'edit_comment'])->middleware(['auth']);

Route::post('/endpoint/delete_comment', [Comments::class, 'delete_comment'])->middleware(['auth']);

Route::post('/endpoint/change_status', [Posts::class, 'change_status'])->middleware(['auth']);

Route::post('/endpoint/asign_user', [Posts::class, 'asign_user'])->middleware(['auth']);

Route::post('/endpoint/unasign_user', [Posts::class, 'unasign_user'])->middleware(['auth']);

Route::get('/profile', [UserController::class, 'index'])->middleware(['auth'])->name('profile');

require __DIR__.'/auth.php';

