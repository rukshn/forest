<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\PostModel;
use App\Models\PostMetaModel;
use App\Models\PostStatusModel;
use App\Models\AsignModel;
use App\Models\NotificationsModel;
use App\Models\AnnouncementModel;

class Posts extends Controller
{
    //

    public function new_post(Request $request) {
        $rules = [
            'title' => 'required',
            'post' => 'required',
            'category' => 'required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error creating post');
        } else {
            $user_id = Auth::id();
            $new_post = new PostModel();
            $new_post->title = $request->title;
            $new_post->post = $request->post;
            $new_post->created_by = $user_id;
            $new_post->save();

            $post_meta = new PostMetaModel;
            $post_meta->post_id = $new_post->id;
            $post_meta->category_id = $request->category;
            $post_meta->save();

            return redirect()->route('post', ['id' => $new_post->id]);
        }
    }

    public function get_post(Request $request) {
        $get_post = DB::table('posts')->where('posts.id', $request->id)
            ->join('post_meta', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'posts.id', '=', 'post_status.post_id')
            ->leftJoin('priority_codes', 'posts.priority', '=', 'priority_codes.id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->join('categories', 'post_meta.category_id', '=', 'categories.id')
            ->join('users', 'users.id', '=', 'posts.created_by')
            ->select('post_meta.category_id',
                'post_status.status_id',
                'posts.deadline as deadline',
                'priority_codes.priority_code as priority', 'priority_codes.color as priority_color',
                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                'categories.name as category_name', 'categories.slug as category_slug', 'categories.color as category_color',
                'posts.title as post_title', 'posts.id as post_id', 'posts.post as post_content', 'posts.created_at as created_at', 'posts.is_archived as is_archived',
                'users.name as user_name', 'users.id as user_id'
            )->first();

        $get_users = DB::table('users')->select('users.name as name', 'users.id as user_id')->get();

        $get_comments = DB::table('posts')->where('posts.id', $request->id)
            ->join('comments', 'comments.post_id', '=', 'posts.id')
            ->join('users', 'comments.created_by', '=', 'users.id')
            ->select('comments.comment as comment', 'users.name as username', 'users.id as user_id', 'comments.created_at as created_at')
            ->get();

        $get_assigns = DB::table('asigns')->where('asigns.post_id', $request->id)
            ->join('users', 'asigns.user_id', '=', 'users.id')
            ->select('users.name as user_name', 'users.id as user_id')->get();

        return view('post', ['post' => $get_post, 'comments'=> $get_comments, 'users' => $get_users, 'asigns' => $get_assigns]);
    }

    public function edit_post(Request $request) {

    }

    public function delete_post(Request $request) {

    }

    public function get_posts_by_milestones(Request $request) {
        $feed_posts = DB::table('categories')->where('categories.id', 3)->where('is_archived', false)
            ->join('post_meta', 'categories.id', '=', 'post_meta.category_id')
            ->join('posts', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'posts.id', '=', 'post_status.post_id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->join('users', 'users.id', '=', 'posts.created_by')
            ->select(DB::table('comments')->where('comments.post_id', 'posts.id')->count())
            ->select('post_meta.category_id',
                'post_status.status_id as status_code',
                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                'categories.name as category_name', 'categories.slug as category_slug', 'categories.color as category_color',
                'posts.title as post_title', 'posts.created_at as post_date', 'posts.id as post_id',
                'users.name as user_name', 'users.id as user_id',
                DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count'))
            ->get();

        return view('dashboard', ['feed' => $feed_posts]);
    }

    public function get_posts_by_tasks(Request $request) {
        $feed_posts = DB::table('categories')->where('categories.id', 2)->where('is_archived', false)
            ->join('post_meta', 'categories.id', '=', 'post_meta.category_id')
            ->join('posts', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'posts.id', '=', 'post_status.post_id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->join('users', 'users.id', '=', 'posts.created_by')
            ->select(DB::table('comments')->where('comments.post_id', 'posts.id')->count())
            ->select('post_meta.category_id',
                'post_status.status_id as status_code',
                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                'categories.name as category_name', 'categories.slug as category_slug', 'categories.color as category_color',
                'posts.title as post_title', 'posts.created_at as post_date', 'posts.id as post_id',
                'users.name as user_name', 'users.id as user_id',
                DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count'))
            ->get();

        return view('dashboard', ['feed' => $feed_posts]);
    }

    public function get_posts_by_issues(Request $request) {
        $feed_posts = DB::table('categories')->where('categories.id', 1)->where('is_archived', false)
            ->join('post_meta', 'categories.id', '=', 'post_meta.category_id')
            ->join('posts', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'posts.id', '=', 'post_status.post_id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->join('users', 'users.id', '=', 'posts.created_by')
            ->select(DB::table('comments')->where('comments.post_id', 'posts.id')->count())
            ->select('post_meta.category_id',
                'post_status.status_id as status_code',
                'status_codes.status_name as status_name', 'status_codes.color as status_color',
                'categories.name as category_name', 'categories.slug as category_slug', 'categories.color as category_color',
                'posts.title as post_title', 'posts.created_at as post_date', 'posts.id as post_id',
                'users.name as user_name', 'users.id as user_id',
                DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count'))
            ->get();

        return view('dashboard', ['feed' => $feed_posts]);
    }

    public function get_feed(Request $request) {

        $feed_posts = DB::table('posts')->where('is_archived', false)
            ->join('post_meta', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'posts.id', '=', 'post_status.post_id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->join('categories', 'post_meta.category_id', '=', 'categories.id')
            ->join('users','users.id', '=', 'posts.created_by')
            ->select('post_meta.category_id',
                    'post_status.status_id as status_code',
                    'status_codes.status_name as status_name', 'status_codes.color as status_color',
                    'categories.name as category_name', 'categories.slug as category_slug', 'categories.color as category_color',
                    'posts.title as post_title', 'posts.created_at as post_date', 'posts.id as post_id',
                    'users.name as user_name', 'users.id as user_id',
                    DB::raw('(select count(*) from comments where comments.post_id = posts.id) as comment_count'))
            ->limit(50)->get();

        $get_announcement = AnnouncementModel::where('is_pinned', true)->first();

        if (isset($get_announcement)) {
            $has_announcement = true;
        } else {
            $has_announcement = false;
        }
        // return json_encode($annoucement);
        return view('dashboard',
            [
                'feed' => $feed_posts,
                'has_announcement'=> $has_announcement,
                'announcement' => $get_announcement
            ]
        );

    }

    public function change_status(Request $request) {
        $rules = [
            'post_id' => 'required|numeric',
            'status' => 'required|numeric'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error setting status');
        } else {
            $post_status = PostStatusModel::where('post_id', $request->post_id)->first();
            if (isset($post_status)) {
                $post_status->status_id = $request->status;
                $post_status->save();
            } else {
                $new_status = new PostStatusModel();
                $new_status->post_id = $request->post_id;
                $new_status->status_id = $request->status;
                $new_status->save();
            }
            return redirect()->back()->with('message', 'Status changed');
        }
    }

    public function asign_user(Request $request) {
        $rules = [
            'post_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('message', 'Error assigning user');
        } else {
            $select_asign = AsignModel::where('user_id', $request->user_id)->where('post_id', $request->post_id)->first();
            if (!isset($select_asign)) {
                $new_assign = new AsignModel();
                $new_assign->post_id = $request->post_id;
                $new_assign->user_id = $request->user_id;
                $new_assign->assigned_by = Auth::id();

                $new_assign->save();
            }

            $new_notification = new NotificationsModel();
            $new_notification->from_user_id = Auth::id();
            $new_notification->to_user_id = $request->user_id;
            $new_notification->post_id = $request->post_id;
            $new_notification->message = auth()->user()->name . ' assigned you with a new task';
            $new_notification->notification_type = 'task';
            $new_notification->save();

            return redirect()->back()->with('message', 'User assigned');
        }
    }

    public function unasign_user(Request $request) {
        $rules = [
            'post_id' => 'numeric|required',
            'user_id' => 'numeric|required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            $output = [
                'status' => 500,
                'message' => 'error removing user'
            ];
            return json_encode($output);
        } else {

            $find_post = AsignModel::where('post_id', $request->post_id)->where('user_id', $request->user_id);

            if ($find_post->first() !== NULL) {
                $find_post->delete();
                $output = ['status' => 200, 'message' => 'User unasigned'];
            } else {
                $output = ['status' => 404, 'message' => 'User not found'];
            }

            return json_encode($output);
        }
    }

    public function archive_post(Request $request) {
        $rules = [
            'post_id' => 'numeric|required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error archiving post');
        } else {
            $get_post = PostModel::find($request->post_id);
            if ($get_post->is_archived == false) {
                $get_post->is_archived = true;
                $get_post->save();
                return redirect()->back()->with('message', 'Post archived');
            } else {
                $get_post->is_archived = false;
                $get_post->save();
                return redirect()->back()->with('message', 'Post un-archived');
            }
        }
    }

    public function set_deadline(Request $request) {
        $rules = [
            'post_id' => 'numeric|required',
            'deadline' => 'required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error setting deadline');
        } else {
            $post = PostModel::find($request->post_id);
            $post->deadline = $request->deadline;
            $post->save();

            return redirect()->back()->with('message', 'Deadline set');
        }
    }

    public function change_priority(Request $request) {
        $rules = [
            'post_id' => 'numeric|required',
            'priority' => 'numeric|required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error setting priority');
        } else {
            $post = PostModel::find($request->post_id);
            $post->priority = $request->priority;
            $post->save();

            return redirect()->back()->with('message', 'Priority changed');
        }
    }
}
