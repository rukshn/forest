<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Model\AsignModel;
use App\Model\PostModel;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request) {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->select('name as user_name')->first();

        $asignments = DB::table('asigns')->where('user_id', $user_id)
                        ->join('posts', 'posts.id' , '=', 'asigns.post_id')
                        ->leftJoin('users', 'users.id', '=', 'posts.created_by')
                        ->leftJoin('post_status', 'post_status.post_id', '=', 'posts.id')
                        ->leftJoin('status_codes', 'status_codes.id', '=', 'status_id')
                        ->leftJoin('post_meta', 'post_meta.post_id', '=', 'posts.id')
                        ->leftJoin('categories', 'categories.id', '=', 'post_meta.category_id')
                        ->select('posts.id as post_id', 'posts.title as post_title', 'posts.created_at as post_date',
                                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                                'categories.name as category_name', 'categories.color as category_color',
                                'users.name as user_name',
                                'asigns.created_at as asigned_date',
                                DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count')
                                )->get();

        // return json_encode($asignments);
        return view('user', ['asignments' => $asignments, 'userData' => $user]);
    }

    public function user(Request $request) {
        $user_id = $request->id;
        $user = User::where('id', $user_id)->select('name as user_name')->first();

        $asignments = DB::table('asigns')->where('user_id', $user_id)
                        ->join('posts', 'posts.id' , '=', 'asigns.post_id')
                        ->leftJoin('users', 'users.id', '=', 'posts.created_by')
                        ->leftJoin('post_status', 'post_status.post_id', '=', 'posts.id')
                        ->leftJoin('status_codes', 'status_codes.id', '=', 'status_id')
                        ->leftJoin('post_meta', 'post_meta.post_id', '=', 'posts.id')
                        ->leftJoin('categories', 'categories.id', '=', 'post_meta.category_id')
                        ->select('posts.id as post_id', 'posts.title as post_title', 'posts.created_at as post_date',
                                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                                'categories.name as category_name', 'categories.color as category_color',
                                'users.name as user_name',
                                'asigns.created_at as asigned_date',
                                DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count')
                                )->get();

        // return json_encode($asignments);
        return view('user', ['asignments' => $asignments, 'userData' => $user]);
    }
}
