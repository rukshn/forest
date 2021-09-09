<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Posts;
use App\Http\Controllers\Comments;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Team;
use App\Http\Controllers\Kanban;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ComposeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QaController;
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

Route::get('/issues', [Posts::class, 'get_posts_by_issues'])->middleware(['auth'])->name('issues');

Route::get('/tasks', [Posts::class, 'get_posts_by_tasks'])->middleware(['auth'])->name('tasks');

Route::get('/milestones', [Posts::class, 'get_posts_by_milestones'])->middleware(['auth'])->name('milestones');

Route::get('/new/post', [ComposeController::class, 'index'])->middleware(['auth'])->name('compose');

Route::get('/new/announcement', function() {
    return view('create_announcement');
})->middleware(['auth'])->name('announcement');

Route::get('/post/{id}', [Posts::class, 'get_post'])->middleware(['auth'])->name('post');

Route::post('/endpoint/new/post', [Posts::class, 'new_post'])->middleware(['auth']);

Route::post('/endpoint/new/announcement', [AnnouncementController::class, 'new_announcement'])->middleware(['auth']);

Route::post('/endpiont/edit_post', [Posts::class, 'edit_post'])->middleware(['auth']);

Route::post('/endpiont/delete_post', [Posts::class, 'delete_post'])->middleware(['auth']);

Route::post('/endpoint/create_comment', [Comments::class, 'create_comment'])->middleware(['auth']);

Route::post('/endpoint/edit_comment', [Comments::class, 'edit_comment'])->middleware(['auth']);

Route::post('/endpoint/delete_comment', [Comments::class, 'delete_comment'])->middleware(['auth']);

Route::post('/endpoint/change_status', [Posts::class, 'change_status'])->middleware(['auth']);

Route::post('/endpoint/asign_user', [Posts::class, 'asign_user'])->middleware(['auth']);

Route::post('/endpoint/unasign_user', [Posts::class, 'unasign_user'])->middleware(['auth']);

Route::get('/profile', [UserController::class, 'index'])->middleware(['auth'])->name('profile');

Route::get('/team', [Team::class, 'index'])->middleware(['auth'])->name('team');

Route::get('/user/{id}', [UserController::class, 'user'])->middleware(['auth'])->name('user');

Route::get('/tasks/kanban', [Kanban::class, 'index'])->middleware(['auth'])->name('kanban');

Route::get('/endpoint/kanban/tasks', [Kanban::class, 'tasks'])->middleware(['auth']);

Route::post('/endpoint/kanban/beginTask', [Kanban::class, 'beginTask'])->middleware(['auth']);

Route::post('/endpoint/kanban/completeTask', [Kanban::class, 'completeTask'])->middleware(['auth']);

Route::get('/notifications', [NotificationsController::class, 'get_all_notifications'])->middleware(['auth'])->name('notifications');

Route::post('/endpoint/notification/read', [NotificationsController::class, 'read_notification'])->middleware(['auth']);

Route::post('/endpoint/post/archive', [Posts::class, 'archive_post'])->middleware(['auth']);

Route::get('/announcement/{announcement_id}', [AnnouncementController::class, 'get_announcement'])->middleware(['auth']);

Route::post('/endpoint/announcement/archive', [AnnouncementController::class, 'archive_announcement'])->middleware(['auth']);

Route::post('/endpoint/post/set_deadline', [Posts::class, 'set_deadline'])->middleware(['auth']);

Route::post('/endpoint/post/change_priority', [Posts::class, 'change_priority'])->middleware(['auth']);

Route::post('/endpoint/post/set_milestone', [Posts::class, 'set_milestone'])->middleware(['auth']);

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/feed', [Posts::class, 'get_feed'])->middleware(['auth'])->name('feed');

Route::post('/endpoint/review/request_review', [QaController::class, 'request_review'])->middleware(['auth']);

Route::post('/endpoint/review/assign_user', [QaController::class, 'assign_user'])->middleware(['auth']);

Route::get('/review/{id}', [QaController::class, 'get_post_for_review'])->middleware(['auth']);

Route::post('/endpoint/review/complete', [QaController::class, 'complete_review'])->middleware(['auth']);

require __DIR__.'/auth.php';

