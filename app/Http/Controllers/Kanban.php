<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PostModel;

class Kanban extends Controller
{
    //
    public function tasks(Request $request) {
        $tasks = DB::table('post_meta')->where('category_id', '2')->orWhere('category_id', '1')
            ->join('posts', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'post_status.post_id', '=', 'posts.id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->leftJoin('categories', 'categories.id', '=', 'post_meta.category_id')
            ->select('posts.title as post_title', 'posts.id as post_id', 'posts.created_at as date',
                    'status_codes.status_name as status_code',
                    'status_codes.id as status_code_id',
                    'status_codes.color as status_color',
                    'categories.name as category_name', 'categories.color as category_color')
            ->get();

        return $tasks;
    }

    public function beginTask(Request $request) {
        // $rules = [
        //     'post_id' => 'numeric|required'
        // ];

        // $validat
    }
}
