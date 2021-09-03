<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComposeController extends Controller
{
    //
    public function index() {
        $get_milestones = DB::table('post_meta')->where('category_id', 3)->where('posts.is_archived', false)
                        ->join('posts', 'posts.id', '=', 'post_meta.post_id')
                        ->select('posts.id as milestone_id', 'posts.title as milestone')
                        ->get();

        return view('compose', ['milestones' => $get_milestones]);
    }
}
