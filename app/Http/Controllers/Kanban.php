<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PostModel;
use App\Models\PostStatusModel;
use App\Models\AsignModel;

class Kanban extends Controller
{
    //

    public function index(Request $request) {
        $get_milestones = DB::table('post_meta')->where('category_id', 3)->where('posts.is_archived', false)
            ->join('posts', 'posts.id', '=', 'post_meta.post_id')
            ->select('posts.id as milestone_id', 'posts.title as milestone')
            ->get();

        return view('kanban', ['milestones' => $get_milestones]);
    }

    public function tasks(Request $request) {
        $tasks = DB::table('post_meta')->where('posts.is_archived', false)->where('category_id', '2')->orWhere('category_id', '1')->where('posts.is_archived', false)
            ->join('posts', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'post_status.post_id', '=', 'posts.id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->leftJoin('categories', 'categories.id', '=', 'post_meta.category_id')
            ->leftJoin('asigns', 'posts.id', '=', 'asigns.post_id')
            ->leftJoin('users', 'asigns.user_id', '=', 'users.id')
            ->leftJoin('priority_codes', 'posts.priority', '=', 'priority_codes.id')
            ->leftJoin('milestones', 'posts.id', '=', 'milestones.post_id')
            ->select('posts.title as post_title', 'posts.id as post_id', 'posts.created_at as date', 'posts.deadline as deadline', 'posts.priority as priority',
                    'status_codes.status_name as status_code',
                    'status_codes.id as status_code_id',
                    'status_codes.color as status_color',
                    'post_status.id as post_status_id',
                    'users.name as asigned_user',
                    'milestones.milestone_id as milestone_id',
                    'priority_codes.priority_code as priority_code', 'priority_codes.color as priority_color',
                    'categories.name as category_name', 'categories.color as category_color')
            ->get();

        return $tasks;
    }

    public function beginTask(Request $request) {
        $rules = [
            'post_id' => 'required|numeric',
            'post_status_id' => 'required|numeric'
        ];

        $validate = Validator($request->all(), $rules);

        if ($validate->fails()) {
            return json_encode('invalid requrest');
        } else {
            $find_status = PostStatusModel::find($request->post_status_id);
            if ($find_status->first() !== NULL) {
                $find_status->status_id = 2;
                $find_status->save();
            } else {
                $new_status = new PostStatusModel();
                $new_status->post_id = $request->post_id;
                $new_status->status_id = 2;
            }

            $user_id = Auth::id();

            $find_assign = AsignModel::where('post_id', $request->post_id)->where('user_id', $user_id)->first();

            if (!isset($find_assign)) {
                $new_assign = new AsignModel();
                $new_assign->post_id = $request->post_id;
                $new_assign->user_id = $user_id;
                $new_assign->assigned_by = $user_id;
                $new_assign->save();
            }

            $output = [
                'status' => 200,
                'message' => 'tasks assigned'
            ];
            return json_encode($output);
        }
    }

    public function completeTask(Request $request) {
        $rules = [
            'post_id' => 'required|numeric',
            'post_status_id' => 'required|numeric'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return json_encode("invalid request");
        } else {
            $find_status = PostStatusModel::find($request->post_status_id);
            if ($find_status->first() !== NULL) {
                $find_status->status_id = 3;
                $find_status->save();
            } else {
                $new_status = new PostStatusModel();
                $new_status->post_id = $request->post_id;
                $new_status->status_id = 3;
            }

            $output = [
                'status' => 200,
                'message' => 'task completed'
            ];

            return json_encode($output);
        }

    }

    public function archieveTask(Request $request) {
        $rules = [
            'post_id' => 'required|numeric'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return json_encode("invalid request");
        } else {
            $post = PostModel::find($request->post_id);
            $post->is_archieved = true;
            $post->save();
            $output = [
                'status' => 200,
                'message' => 'post archieved'
            ];
            return json_encode($output);
        }
    }
}
