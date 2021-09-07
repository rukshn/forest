<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MilestoneModel;
use App\Models\PostModel;
use App\Models\AnnouncementModel;

class HomeController extends Controller
{
    public function index() {
        $tasks = DB::table('posts')->where('is_archived', false)->where('post_meta.category_id', 2)
        ->join('post_meta', 'posts.id', '=', 'post_meta.post_id')
        ->leftJoin('post_status', 'posts.id', '=', 'post_status.post_id')
        ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
        ->leftJoin('priority_codes', 'posts.priority', '=', 'priority_codes.id')
        ->join('categories', 'post_meta.category_id', '=', 'categories.id')
        ->join('users','users.id', '=', 'posts.created_by')
        ->select('post_meta.category_id',
                'post_status.status_id as status_code',
                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                'categories.name as category_name', 'categories.slug as category_slug', 'categories.color as category_color',
                'posts.title as post_title', 'posts.created_at as post_date', 'posts.id as post_id',
                'users.name as user_name', 'users.id as user_id',
                'priority_codes.priority_code as priority_code', 'priority_codes.color as priority_color',
                DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count'))
        ->limit(12)
        ->orderByDesc('posts.id')
        ->get();

        $issues = DB::table('posts')->where('is_archived', false)->where('post_meta.category_id', 1)
        ->join('post_meta', 'posts.id', '=', 'post_meta.post_id')
        ->leftJoin('post_status', 'posts.id', '=', 'post_status.post_id')
        ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
        ->leftJoin('priority_codes', 'posts.priority', '=', 'priority_codes.id')
        ->join('categories', 'post_meta.category_id', '=', 'categories.id')
        ->join('users','users.id', '=', 'posts.created_by')
        ->select('post_meta.category_id',
                'post_status.status_id as status_code',
                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                'categories.name as category_name', 'categories.slug as category_slug', 'categories.color as category_color',
                'posts.title as post_title', 'posts.created_at as post_date', 'posts.id as post_id',
                'users.name as user_name', 'users.id as user_id',
                'priority_codes.priority_code as priority_code', 'priority_codes.color as priority_color',
                DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count'))
        ->limit(12)
        ->orderByDesc('posts.id')
        ->get();

        $get_milestones = DB::table('post_meta')->where('category_id', 3)->where('posts.is_archived', false)
        ->join('posts', 'posts.id', '=', 'post_meta.post_id')
        ->select('posts.id as milestone_id', 'posts.title as milestone')
        ->get();

        $get_announcement = AnnouncementModel::where('is_pinned', true)->first();

        if (isset($get_announcement)) {
            $has_announcement = true;
        } else {
            $has_announcement = false;
        }

        return view('home', [
            'milestones' => $get_milestones,
            'has_announcement' => $has_announcement,
            'announcement' => $get_announcement,
            'tasks' => $tasks,
            'issues' => $issues
        ]);
    }
}
